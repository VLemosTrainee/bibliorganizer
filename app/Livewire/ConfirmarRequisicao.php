<?php

namespace App\Livewire;

use App\Models\Livro;
use App\Models\Requisicao;
use Livewire\Component;
use Livewire\Attributes\On;

class ConfirmarRequisicao extends Component
{
    public ?Livro $livro = null;

    #[On('abrir-modal-requisicao')]
    public function carregarLivro($livroId)
    {
        $this->livro = Livro::find($livroId);
        $this->dispatch('open-modal', 'confirmar_requisicao_modal');
    }

    public function confirmar()
    {
        $user = auth()->user();

        if (!$this->livro) {
            $this->dispatch('erro', 'Livro não encontrado.');
            return;
        }

        if ($user->requisicoes()->whereIn('status', ['pendente', 'aprovada', 'em_avaliacao'])->count() >= 3) {
            $this->dispatch('erro', 'Você já atingiu o limite de 3 requisições ativas.');
            $this->dispatch('close-modal', 'confirmar_requisicao_modal');
            return;
        }

        if ($this->livro->stock_disponivel <= 0) {
            $this->dispatch('erro', 'Este livro já não está disponível.');
            $this->dispatch('close-modal', 'confirmar_requisicao_modal');
            return;
        }

        // --- LÓGICA DO NÚMERO DA REQUISIÇÃO (JÁ INTEGRADA) ---
        $ultimoId = Requisicao::max('id') ?? 0;
        $proximoId = $ultimoId + 1;
        $numeroRequisicao = '#' . str_pad($proximoId, 4, '0', STR_PAD_LEFT);

        Requisicao::create([
            'numero_requisicao' => $numeroRequisicao, // Garante que este campo está a ser passado
            'user_id' => $user->id,
            'livro_id' => $this->livro->id,
            'estado_no_emprestimo' => $this->livro->estado_conservacao,
            'data_requisicao' => now(),
            'data_prevista_devolucao' => now()->addDays(5),
            'status' => 'pendente',
        ]);

        $this->livro->decrement('stock_disponivel');
        
        $this->dispatch('requisicao-concluida'); 
        $this->dispatch('close-modal', 'confirmar_requisicao_modal');
        $this->dispatch('sucesso', 'Livro requisitado com sucesso! Acompanhe em "Minhas Requisições".');
    }

    public function render()
    {
        return view('livewire.confirmar-requisicao');
    }
}