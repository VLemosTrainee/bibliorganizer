<?php

namespace App\Livewire;

use App\Models\Autor;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Storage;

class AutorForm extends Component
{
    use WithFileUploads;

    public ?Autor $autorAEditar = null;
    public $nome = '';
    public $foto;
    public $foto_url;

    // Ouve o evento para carregar dados para edição
    #[On('editar-autor')]
    public function carregarParaEdicao($autorId)
    {
        $this->autorAEditar = Autor::find($autorId);
        if ($this->autorAEditar) {
            $this->nome = $this->autorAEditar->nome;
            if ($this->autorAEditar->foto) {
                $this->foto_url = asset('storage/' . $this->autorAEditar->foto);
            }
        }
        $this->dispatch('open-modal', 'add_autor_modal');
    }

    // Ouve o evento para limpar o formulário quando o modal fecha
    #[On('resetar-formulario-autor')]
    public function resetFormulario()
    {
        $this->reset();
    }

    // Ouve o evento do botão de guardar
    #[On('call-save-autor')]
    public function save()
    {
        $nomeRule = 'required|string|max:255|unique:autors,nome';
        if ($this->autorAEditar) {
            $nomeRule .= ',' . $this->autorAEditar->id;
        }

        $validatedData = $this->validate([
            'nome' => $nomeRule,
            'foto' => 'nullable|image|mimes:jpg,png|max:1024',
        ]);

        $caminhoFoto = $this->autorAEditar->foto ?? null;
        if ($this->foto) {
            if ($caminhoFoto) {
                Storage::disk('public')->delete($caminhoFoto);
            }
            $caminhoFoto = $this->foto->store('autores', 'public');
        }

        $dadosParaSalvar = [
            'nome' => $validatedData['nome'],
            'foto' => $caminhoFoto,
        ];

        if ($this->autorAEditar) {
            $this->autorAEditar->update($dadosParaSalvar);
        } else {
            Autor::create($dadosParaSalvar);
        }

        $this->dispatch('autor-adicionado');
        $this->dispatch('close-modal', 'add_autor_modal');
    }

    public function render()
    {
        return view('livewire.autor-form');
    }
}