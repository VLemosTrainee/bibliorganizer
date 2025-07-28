<?php

namespace App\Livewire;
use Livewire\Component;
use Livewire\WithPagination; 
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class MinhasRequisicoes extends Component
{
    use WithPagination;

    public function render()
    {
        $user = auth()->user();

        // Busca todas as requisições do utilizador logado, com os dados do livro,
        // ordenadas pela mais recente.
        $requisicoes = $user->requisicoes()
            ->with('livro')
            ->latest('data_requisicao')
            ->paginate(10); // 10 requisições por página

        return view('livewire.minhas-requisicoes', [
            'requisicoes' => $requisicoes,
            'reputacao' => $user->pontuacao, // Passa a pontuação para a view
        ]);
    }
}