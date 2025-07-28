<div>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Editar Utilizador</h1>
        <a href="{{ route('utilizadores.index') }}" class="btn btn-ghost" wire:navigate>Voltar à Lista</a>
    </div>

    @if(session('erro')) <div class="alert alert-error mb-4">{{ session('erro') }}</div> @endif

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <form wire:submit="atualizarUtilizador">
                <div class="space-y-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text">Nome</span></label>
                        <input type="text" wire:model="name" class="input input-bordered" />
                        @error('name') <span class="text-error text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Email</span></label>
                        <input type="email" wire:model="email" class="input input-bordered" />
                        @error('email') <span class="text-error text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Role</span></label>
                        <select wire:model="role" class="select select-bordered">
                            <option value="cidadao">Cidadão</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="form-control">
                        <label class="cursor-pointer label">
                          <span class="label-text">Utilizador Ativo</span> 
                          <input type="checkbox" wire:model="is_active" class="toggle toggle-success" />
                        </label>
                    </div>
                </div>
                <div class="card-actions justify-end mt-6">
                    <button type="submit" class="btn btn-primary">Atualizar Utilizador</button>
                </div>
            </form>
        </div>
    </div>
</div>