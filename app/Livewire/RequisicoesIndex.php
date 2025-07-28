<?php

namespace App\Livewire;

use App\Models\Requisicao;
use Livewire\Component;
use Livewire\WithPagination;

class RequisicoesIndex extends Component
{
    use WithPagination;

    public $filtroStatus = ''; // <-- A variável que estava a dar erro
    public $pesquisa = '';     // <-- A variável para a pesquisa

    public function filtrarPorStatus($status)
    {
        $this->filtroStatus = $status;
        $this->resetPage(); // Reinicia a paginação ao mudar de filtro
    }
    
    // O Livewire deteta a mudança em 'pesquisa' e corre o render novamente
    public function updatedPesquisa()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Lógica para ir buscar as requisições à base de dados com os filtros
        $requisicoes = Requisicao::query()
            ->when($this->filtroStatus, function ($query) {
                $query->where('status', $this->filtroStatus);
            })
            ->when($this->pesquisa, function ($query) {
                $query->where('numero_requisicao', 'like', '%'.$this->pesquisa.'%');
                // Adicione outras pesquisas aqui (ex: nome do user, nome do livro)
            })
            ->latest() // Ordena pelas mais recentes
            ->paginate(10); // Usa paginação

        return view('livewire.requisicoes-index', [
            'requisicoes' => $requisicoes,
        ]);
    }
}