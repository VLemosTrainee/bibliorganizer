<?php

namespace App\Livewire;

use App\Models\Editora;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EditoraIndex extends Component
{
    public string $pesquisa = '';
    public array $selecionados = []; // Para guardar os IDs selecionados

    #[On('editora-adicionada')]
    public function fecharModalEAtualizar()
    {
        $this->dispatch('close-modal', 'add_editora_modal');
    }

    // NOVO MÉTODO: Ouve o evento 'apagar-editora'
    #[On('apagar-editora')]
    public function apagarEditora($editoraId)
    {
        $editora = Editora::withCount('livros')->find($editoraId);

        if ($editora && $editora->livros_count > 0) {
            // Se a editora tem livros, envia um alerta de erro
            $this->dispatch('erro-apagar', 'Não é possível apagar uma editora que possui livros associados.');
            return;
        }

        if ($editora) {
            if ($editora->logotipo) {
                Storage::disk('public')->delete($editora->logotipo);
            }
            $editora->delete();
        }
    }

    public function render()
    {
        $editoras = Editora::all();

        if (strlen($this->pesquisa) > 0) {
            $editoras = $editoras->filter(function ($editora) {
                return Str::contains(Str::lower(Str::ascii($editora->nome)), Str::lower(Str::ascii($this->pesquisa)));
            });
        }

        $editoras = $editoras->sortBy('nome');
        
        // Passa os IDs visíveis para a view, para serem usados na exportação
        $idsVisiveis = $editoras->pluck('id')->toArray();

        return view('livewire.editora-index', [
            'editoras' => $editoras,
            'idsVisiveis' => $idsVisiveis
        ]);
    }
}