<?php
namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Validation\Rule;

#[Layout('components.layouts.app')]
class EditarUtilizadorPagina extends Component
{
    public User $user; // A instância do utilizador a ser editado

    // Propriedades para o formulário
    public $name;
    public $email;
    public $role;
    public $is_active;

    // O Laravel injeta o utilizador da URL aqui
    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->is_active = $user->is_active;
    }

    public function atualizarUtilizador()
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->user->id)],
            'role' => 'required|in:admin,cidadao',
            'is_active' => 'required|boolean',
        ]);

        if (User::where('role', 'admin')->count() === 1 && $this->user->role === 'admin') {
            if ($this->user->id === auth()->id() && ($validatedData['role'] !== 'admin' || !$validatedData['is_active'])) {
                session()->flash('erro', 'Não é possível remover ou desativar o último administrador.');
                return;
            }
        }

        $this->user->update($validatedData);
        
        session()->flash('sucesso', 'Utilizador atualizado com sucesso!');
        $this->redirectRoute('utilizadores.index');
    }

    public function render()
    {
        return view('livewire.editar-utilizador-pagina');
    }
}