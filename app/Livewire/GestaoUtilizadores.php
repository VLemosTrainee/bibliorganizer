<?php
namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('components.layouts.app')]
class GestaoUtilizadores extends Component
{
    use WithPagination;

    public string $pesquisa = '';

    public function updatingPesquisa()
    {
        $this->resetPage();
    }

    // A lógica de apagar permanece aqui, pois a ação acontece na página de listagem
   #[On('apagar-utilizador')]
public function apagarUtilizador($userId)
{
    $user = User::find($userId);

    if ($user->id === auth()->id()) {
        $this->dispatch('erro', 'Você não pode apagar a sua própria conta.');
        return;
    }
    if (User::where('role', 'admin')->count() === 1 && $user->role === 'admin') {
        $this->dispatch('erro', 'Não é possível apagar o último administrador.');
        return;
    }

    // ================================================================
    // NOVA REGRA DE NEGÓCIO
    // ================================================================
    // Verifica se o utilizador tem QUALQUER requisição, independentemente do status
    if ($user->requisicoes()->exists()) {
        $this->dispatch('erro', 'Não é possível apagar um utilizador com histórico de requisições. Por favor, inative a conta como alternativa.');
        return;
    }
    
    // Se todas as verificações passarem, apaga o utilizador
    $user->delete();
    $this->dispatch('sucesso', 'Utilizador apagado com sucesso!');
}
    // A lógica de renderização busca e passa os utilizadores para a view
    public function render()
    {
        $utilizadores = User::query()
            ->where(function ($query) {
                $query->where('name', 'like', '%'.$this->pesquisa.'%')
                      ->orWhere('email', 'like', '%'.$this->pesquisa.'%');
            })
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.gestao-utilizadores', [
            'utilizadores' => $utilizadores,
        ]);
    }
}