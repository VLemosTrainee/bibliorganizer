<?php

namespace App\Livewire;

use App\Models\Autor;
use App\Models\Editora;
use App\Models\Livro;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        // --- STATS TOTAIS ---
        $totalLivros = Livro::count();
        $totalAutores = Autor::count();
        $totalEditoras = Editora::count();

        // --- DESTAQUES ---
        // Editora com mais livros. Em caso de empate, a mais antiga (menor ID) ganha.
        $editoraDestaque = Editora::withCount('livros')
            ->orderByDesc('livros_count')
            ->orderBy('id', 'asc')
            ->first();

        // Autor com mais livros. Em caso de empate, o mais antigo (menor ID) ganha.
        $autorDestaque = Autor::withCount('livros')
            ->orderByDesc('livros_count')
            ->orderBy('id', 'asc')
            ->first();
        
        // --- COLEÇÕES PARA OS CARROSSÉIS ---
        // Os 5 últimos livros adicionados (ordenados pelo mais recente primeiro)
        $ultimosAdicionados = Livro::with('autores')->latest()->take(5)->get();

        // Os 5 livros mais baratos (ordenados pelo preço, do menor para o maior)
        $maisBaratos = Livro::with('autores')->orderBy('preco', 'asc')->take(5)->get();

        // A passagem de dados para a view
        return view('livewire.dashboard', [
            'totalLivros' => $totalLivros,
            'totalAutores' => $totalAutores,
            'totalEditoras' => $totalEditoras,
            'editoraDestaque' => $editoraDestaque,
            'autorDestaque' => $autorDestaque,
            'ultimosAdicionados' => $ultimosAdicionados,
            'maisBaratos' => $maisBaratos,
        ]);
    }
}