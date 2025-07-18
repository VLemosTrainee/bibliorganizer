<?php

namespace App\Livewire;

use App\Models\Editora;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Storage;

class EditoraForm extends Component
{
    use WithFileUploads;

    public ?Editora $editoraAEditar = null;
    public $nome = '';
    public $logotipo;
    public $logotipo_url;

    // NOVO MÉTODO: Ouve o evento para carregar dados para edição
    #[On('editar-editora')]
    public function carregarParaEdicao($editoraId)
    {
        $this->editoraAEditar = Editora::find($editoraId);
        if ($this->editoraAEditar) {
            $this->nome = $this->editoraAEditar->nome;
            if ($this->editoraAEditar->logotipo) {
                $this->logotipo_url = asset('storage/' . $this->editoraAEditar->logotipo);
            }
        }
        $this->dispatch('open-modal', 'add_editora_modal');
    }

    // NOVO MÉTODO: Ouve o evento para limpar o formulário
    #[On('resetar-formulario-editora')]
    public function resetFormulario()
    {
        $this->reset();
    }

    // NOVO MÉTODO: Ouve o evento do JavaScript para guardar
    #[On('call-save-editora')]
    public function save()
    {
        $nomeRule = 'required|string|max:255|unique:editoras,nome';
        if ($this->editoraAEditar) {
            $nomeRule .= ',' . $this->editoraAEditar->id;
        }

        $validatedData = $this->validate([
            'nome' => $nomeRule,
            'logotipo' => 'nullable|image|mimes:jpg,png|max:1024',
        ]);

        $caminhoLogotipo = $this->editoraAEditar->logotipo ?? null;
        if ($this->logotipo) {
            if ($caminhoLogotipo) {
                Storage::disk('public')->delete($caminhoLogotipo);
            }
            $caminhoLogotipo = $this->logotipo->store('logotipos', 'public');
        }

        $dadosParaSalvar = [
            'nome' => $validatedData['nome'],
            'logotipo' => $caminhoLogotipo,
        ];

        if ($this->editoraAEditar) {
            $this->editoraAEditar->update($dadosParaSalvar);
        } else {
            Editora::create($dadosParaSalvar);
        }

        $this->dispatch('editora-adicionada');
        $this->dispatch('close-modal', 'add_editora_modal');
    }

    public function render()
    {
        return view('livewire.editora-form');
    }
}