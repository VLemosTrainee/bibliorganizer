<?php
namespace App\Livewire;
use App\Models\Requisicao;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\Mail;
use App\Mail\RequisicaoAprovada;

#[Layout('components.layouts.app')]
class GestaoRequisicoes extends Component
{
    use WithPagination;

    public string $pesquisa = '';
    public string $filtroStatus = '';
    
    // Propriedades para o modal de devolução
    public $requisicaoIdParaDevolucao = null;
    public $livroNomeParaDevolucao = null;
    public $estadoEmprestimoParaDevolucao = null;
    public int $estadoDevolucao = 10;

    public function updatingPesquisa() { $this->resetPage(); }
    public function filtrarPorStatus($status) { $this->filtroStatus = $status; $this->resetPage(); }

    #[On('mudar-status-requisicao')]
    public function mudarStatus($requisicaoId, $novoStatus)
    {
        $requisicao = Requisicao::find($requisicaoId);
        if ($requisicao) {
            if ($novoStatus === 'rejeitada' && $requisicao->status !== 'rejeitada') {
                $requisicao->livro->increment('stock_disponivel');
            }
            if (($novoStatus === 'aprovada' || $novoStatus === 'pendente') && $requisicao->status === 'rejeitada') {
                $requisicao->livro->decrement('stock_disponivel');
            }
            $requisicao->update(['status' => $novoStatus]);


        // =======================================================
        // LÓGICA DE ENVIO DE EMAIL
        // =======================================================
        // Se o novo status for 'aprovada' e o status anterior não era, envia o email.
        if ($novoStatus === 'aprovada' && $requisicao->wasChanged('status')) {
            Mail::to($requisicao->user->email)->send(new RequisicaoAprovada($requisicao));
        }

            $this->dispatch('sucesso', 'Status atualizado!');
        }
    }
    
    // ================================================================
    // MÉTODO REINTRODUZIDO PARA ABRIR O MODAL DE DEVOLUÇÃO
    // ================================================================
    public function abrirModalDevolucao($requisicaoId)
    {
        $requisicao = Requisicao::with('livro')->find($requisicaoId);
        
        if ($requisicao && $requisicao->livro) {
            $this->requisicaoIdParaDevolucao = $requisicao->id;
            $this->livroNomeParaDevolucao = $requisicao->livro->nome;
            $this->estadoEmprestimoParaDevolucao = $requisicao->estado_no_emprestimo;
            $this->estadoDevolucao = $requisicao->estado_no_emprestimo ?? 10;
            $this->dispatch('open-modal', 'devolucao_modal');
        } else {
            $this->dispatch('erro', 'Não foi possível carregar os dados da requisição.');
        }
    }

    // ================================================================
    // MÉTODO REINTRODUZIDO PARA CONFIRMAR A DEVOLUÇÃO E CALCULAR REPUTAÇÃO
    // ================================================================
    public function confirmarDevolucao()
    {
        $this->validate(['estadoDevolucao' => 'required|integer|min:0|max:10']);
        
        $requisicao = Requisicao::with(['user', 'livro'])->find($this->requisicaoIdParaDevolucao);

        if (!$requisicao) {
            $this->dispatch('erro', 'Requisição não encontrada.');
            return;
        }

        $user = $requisicao->user;
        $livro = $requisicao->livro;

        // 1. Atualiza a requisição, registando a data e o estado da devolução
        $requisicao->status = 'concluida';
        $requisicao->data_devolucao_efetiva = now();
        $requisicao->estado_na_devolucao = $this->estadoDevolucao;
        $requisicao->save();

        // 2. Atualiza o livro (stock e estado)
        $livro->increment('stock_disponivel');
        $livro->estado_conservacao = $this->estadoDevolucao;
        $livro->save();

        // 3. Algoritmo de Pontuação
        $pontosPerdidos = 0;
        if ($requisicao->data_devolucao_efetiva->gt($requisicao->data_prevista_devolucao)) {
            $diasAtraso = $requisicao->data_devolucao_efetiva->diffInDays($requisicao->data_prevista_devolucao);
            $pontosPerdidos += floor($diasAtraso / 3);
        }
        $degradacao = $requisicao->estado_no_emprestimo - $this->estadoDevolucao;
        if ($degradacao > 0) {
            $pontosPerdidos += floor($degradacao / 2);
        }

        // 4. Aplica a penalização ao utilizador
        if ($pontosPerdidos > 0 && $user->pontuacao > 0) {
            $novaPontuacao = $user->pontuacao - $pontosPerdidos;
            $user->pontuacao = $novaPontuacao < 0 ? 0 : $novaPontuacao;
            $user->save();
        }

        $this->dispatch('close-modal', 'devolucao_modal');
        $this->dispatch('sucesso', 'Devolução confirmada com sucesso!');
        $this->reset(['requisicaoIdParaDevolucao', 'livroNomeParaDevolucao', 'estadoEmprestimoParaDevolucao', 'estadoDevolucao']);
    }


    public function render()
    {
        $requisicoes = Requisicao::with(['user', 'livro.editora'])
            ->when($this->filtroStatus, fn($q) => $q->where('status', $this->filtroStatus))
            ->where(function ($query) {
                $query->where('numero_requisicao', 'like', '%'.$this->pesquisa.'%')
                      ->orWhereHas('user', fn($q) => $q->where('name', 'like', '%'.$this->pesquisa.'%')->orWhere('email', 'like', '%'.$this->pesquisa.'%'))
                      ->orWhereHas('livro', fn($q) => $q->where('nome', 'like', '%'.$this->pesquisa.'%')
                            ->orWhereHas('editora', fn($eq) => $eq->where('nome', 'like', '%'.$this->pesquisa.'%')));
            })
            ->latest('data_requisicao')
            ->paginate(10);

        return view('livewire.gestao-requisicoes', ['requisicoes' => $requisicoes]);
    }
}