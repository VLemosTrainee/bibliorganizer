<div>
    {{-- TÍTULO DINÂMICO ADICIONADO AQUI --}}
    <h3 class="font-bold text-lg mb-4">
        @if ($editoraAEditar)
            Editar Editora
        @else
            Adicionar Nova Editora
        @endif
    </h3>

    <form>
        <div class="space-y-4">
            <!-- Campo Nome -->
            <div class="form-control">
                <label class="label"><span class="label-text font-semibold">Nome da Editora</span></label>
                <input type="text" wire:model="nome" class="input input-bordered w-full" />
                @error('nome') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Campo Logotipo -->
            <div class="form-control">
                <label class="label"><span class="label-text font-semibold">Logótipo (Opcional)</span></label>
                <input type="file" wire:model="logotipo" class="file-input file-input-bordered w-full" />
                @error('logotipo') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
            </div>
            
            <!-- Preview do Logotipo -->
            @if ($logotipo || $logotipo_url)
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Preview</span></label>
                    <div class="avatar">
                        <div class="w-24 rounded-lg ring ring-primary ring-offset-base-100 ring-offset-2">
                            <img src="{{ $logotipo ? $logotipo->temporaryUrl() : $logotipo_url }}" />
                        </div>
                    </div>
                </div>
            @endif

            <!-- Botões de Ação -->
            <div class="flex justify-end pt-4 gap-3">
                <button type="button" class="btn btn-ghost" onclick="add_editora_modal.close()">Cancelar</button>
                <button 
                    type="button" 
                    onclick="if(confirm('Tem a certeza que deseja guardar?')) { Livewire.dispatch('call-save-editora') }" 
                    class="btn btn-primary"
                >
                    <span wire:loading.remove wire:target="save">
                        @if ($editoraAEditar)
                            Atualizar
                        @else
                            Guardar
                        @endif
                    </span>
                    <span wire:loading wire:target="save" class="loading loading-spinner"></span>
                </button>
            </div>
        </div>
    </form>
</div>