<?php

namespace App\Livewire;

use App\Models\Livro;
use App\Models\Autor;
use App\Models\Editora;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Attributes\Layout;

// Usa o layout de visitante
#[Layout('layouts.guest')]
class MontraLivros extends Component
{
    public function render()
    {
        // Busca os mesmos dados que a dashboard do admin
        $ultimosAdicionados = Livro::with('autores')->latest()->take(5)->get();
        $maisBaratos = Livro::with('autores')->orderBy('preco', 'asc')->take(5)->get();
        $editoraDestaque = Editora::withCount('livros')->orderByDesc('livros_count')->orderBy('id', 'asc')->first();
        $autorDestaque = Autor::withCount('livros')->orderByDesc('livros_count')->orderBy('id', 'asc')->first();

        // Passa todos os dados para a view
        return view('livewire.montra-livros', [
            'ultimosAdicionados' => $ultimosAdicionados,
            'maisBaratos' => $maisBaratos,
            'editoraDestaque' => $editoraDestaque,
            'autorDestaque' => $autorDestaque,
        ]);
    }
}