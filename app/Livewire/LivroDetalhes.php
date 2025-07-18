<?php

namespace App\Livewire;

use App\Models\Livro;
use Livewire\Component;
use Livewire\Attributes\On;

class LivroDetalhes extends Component
{
    public ?Livro $livro = null; // A propriedade que guardará o livro

    // Ouve o evento 'mostrar-detalhes' vindo da página de listagem
    #[On('mostrar-detalhes')]
    public function carregarLivro($livroId)
    {
        // Carrega o livro com todas as suas relações
        $this->livro = Livro::with(['editora', 'autores'])->find($livroId);

        // Abre o modal de detalhes
        $this->dispatch('open-modal', 'detalhes_livro_modal');
    }

    public function render()
    {
        return view('livewire.livro-detalhes');
    }
}