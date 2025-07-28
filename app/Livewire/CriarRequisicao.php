<?php

namespace App\Livewire;

use App\Models\Livro;
use App\Models\Requisicao;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class CriarRequisicao extends Component
{
    public Livro $livro;

    // O Livewire injeta automaticamente o livro da URL aqui
    public function mount(Livro $livro)
    {
        $this->livro = $livro;
    }

    public function confirmarRequisicao()
    {
        $user = auth()->user();

        if ($user->requisicoes()->where('status', 'ativa')->count() >= 3) {
            session()->flash('erro', 'Você já atingiu o limite de 3 livros requisitados.');
            return;
        }
        if ($this->livro->stock_disponivel <= 0) {
            session()->flash('erro', 'Este livro já não está disponível.');
            return;
        }

        Requisicao::create([
            'user_id' => $user->id,
            'livro_id' => $this->livro->id,
            'estado_no_emprestimo' => $this->livro->estado_conservacao,
            'data_requisicao' => now(),
            'data_prevista_devolucao' => now()->addDays(5),
            'status' => 'pendente',
        ]);

        $this->livro->decrement('stock_disponivel');

        // Redireciona para a página 'Minhas Requisições' com uma mensagem de sucesso
        session()->flash('sucesso', 'Livro requisitado com sucesso! Aguarde a aprovação.');
        $this->redirectRoute('requisicoes.minhas');
    }

    public function render()
    {
        return view('livewire.criar-requisicao');
    }
}