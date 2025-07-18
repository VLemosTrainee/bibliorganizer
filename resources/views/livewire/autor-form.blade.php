<div>
    <h3 class="font-bold text-lg mb-4">
        @if ($autorAEditar)
            Editar Autor
        @else
            Adicionar Novo Autor
        @endif
    </h3>
    <form>
        <div class="space-y-4">
            <div class="form-control">
                <label class="label"><span class="label-text font-semibold">Nome do Autor</span></label>
                <input type="text" wire:model="nome" class="input input-bordered w-full" />
                @error('nome') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="form-control">
                <label class="label"><span class="label-text font-semibold">Foto (Opcional)</span></label>
                <input type="file" wire:model="foto" class="file-input file-input-bordered w-full" />
                @error('foto') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
            </div>
            @if ($foto || $foto_url)
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Preview:</span></label>
                    <div class="avatar">
                        <div class="w-24 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                            <img src="{{ $foto ? $foto->temporaryUrl() : $foto_url }}" />
                        </div>
                    </div>
                </div>
            @endif
            <div class="flex justify-end pt-4 gap-3">
                <button type="button" class="btn btn-ghost" onclick="add_autor_modal.close()">Cancelar</button>
                <button 
                    type="button" 
                    onclick="if(confirm('Tem a certeza que deseja guardar?')) { Livewire.dispatch('call-save-autor') }" 
                    class="btn btn-primary"
                >
                    <span wire:loading.remove wire:target="save">
                        @if ($autorAEditar) Atualizar @else Guardar @endif
                    </span>
                    <span wire:loading wire:target="save" class="loading loading-spinner"></span>
                </button>
            </div>
        </div>
    </form>
</div>