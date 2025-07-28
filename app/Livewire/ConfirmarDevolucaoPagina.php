<?php

namespace App\Livewire;

use App\Models\Requisicao;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class ConfirmarDevolucaoPagina extends Component
{
    public Requisicao $requisicao;
    public int $estadoDevolucao;

    // O Laravel injeta a requisição da URL aqui
    public function mount(Requisicao $requisicao)
    {
        $this->requisicao = $requisicao;
        // Inicia o slider com o estado que o livro tinha no empréstimo
        $this->estadoDevolucao = $this->requisicao->estado_no_emprestimo ?? 10;
    }

    public function confirmarDevolucao()
    {
        $this->validate(['estadoDevolucao' => 'required|integer|min:0|max:10']);

        $user = $this->requisicao->user;
        $livro = $this->requisicao->livro;

        // 1. Atualiza a requisição
        $this->requisicao->update([
            'status' => 'concluida',
            'data_devolucao_efetiva' => now(),
            'estado_na_devolucao' => $this->estadoDevolucao,
        ]);

        // 2. Atualiza o stock e o estado do livro
        $livro->increment('stock_disponivel');
        $livro->update(['estado_conservacao' => $this->estadoDevolucao]);

        // 3. Algoritmo de Pontuação
        $pontosPerdidos = 0;
        if ($this->requisicao->data_devolucao_efetiva->gt($this->requisicao->data_prevista_devolucao)) {
            $diasAtraso = $this->requisicao->data_devolucao_efetiva->diffInDays($this->requisicao->data_prevista_devolucao);
            $pontosPerdidos += floor($diasAtraso / 3);
        }
        $degradacao = $this->requisicao->estado_no_emprestimo - $this->estadoDevolucao;
        if ($degradacao > 0) {
            $pontosPerdidos += floor($degradacao / 2);
        }

        // Aplica a penalização
        if ($pontosPerdidos > 0 && $user->pontuacao > 0) {
            $novaPontuacao = $user->pontuacao - $pontosPerdidos;
            $user->update(['pontuacao' => $novaPontuacao < 0 ? 0 : $novaPontuacao]);
        }

        // Redireciona de volta para a lista com uma mensagem de sucesso
        session()->flash('sucesso', 'Devolução confirmada com sucesso!');
        $this->redirectRoute('requisicoes.admin');
    }

    public function render()
    {
        return view('livewire.confirmar-devolucao-pagina');
    }
}