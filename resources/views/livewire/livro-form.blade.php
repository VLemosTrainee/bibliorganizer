<div class="p-4 sm:p-6">
    {{-- A tag <form> já está correta, não precisa de wire:submit --}}
    <form>

        <h2 class="text-2xl font-bold text-base-content mb-6">
            @if ($livroAEditar)
                Editar Livro
            @else
                Adicionar Novo Livro
            @endif
        </h2>

        <div class="space-y-6">
            <!-- Linha do ISBN e Nome do Livro -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">ISBN</span></label>
                    <div class="relative">
                        
                        {{-- MUDANÇA 1: De wire:model para wire:model.lazy --}}
                        <input type="text" wire:model.lazy="isbn" class="input input-bordered w-full pr-12" placeholder="Digite o ISBN" @if($livroAEditar) disabled @endif />
                        
                        {{-- MUDANÇA 2: Adicionados os wire:target --}}
                        <button 
                            type="button" 
                            wire:click="lookupIsbn" 
                            class="btn btn-ghost btn-square absolute top-0 right-0"
                            wire:loading.attr="disabled" 
                            wire:target="lookupIsbn"
                            title="Buscar dados pelo ISBN" 
                            @if($livroAEditar) disabled @endif
                        >
                            <svg wire:loading.remove wire:target="lookupIsbn" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            <span wire:loading wire:target="lookupIsbn" class="loading loading-spinner loading-sm"></span>
                        </button>

                    </div>
                    @error('isbn') <span class="text-error text-sm mt-2">{{ $message }}</span> @enderror
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Nome do Livro</span></label>
                    <input type="text" wire:model="nome" class="input input-bordered w-full" placeholder="Será preenchido pela busca" />
                    @error('nome') <span class="text-error text-sm mt-2">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Linha da Editora, Autores e Bibliografia -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-6">
                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold">Editora</span></label>
                        <select wire:model="editora_id" class="select select-bordered w-full">
                            <option value="" disabled>Selecione uma editora</option>
                            @if($todasEditoras)
                                @foreach($todasEditoras as $editora)
                                    <option value="{{ $editora->id }}">{{ $editora->nome }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('editora_id') <span class="text-error text-sm mt-2">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold">Bibliografia</span></label>
                        <textarea wire:model="bibliografia" class="textarea textarea-bordered w-full h-40" placeholder="Será preenchido pela busca"></textarea>
                        @error('bibliografia') <span class="text-error text-sm mt-2">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Autores (Ctrl/Cmd para múltiplos)</span></label>
                    <select wire:model="autores_selecionados" multiple class="select select-bordered w-full h-full">
                        @if($todosAutores)
                            @foreach($todosAutores as $autor)
                                <option value="{{ $autor->id }}">{{ $autor->nome }}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('autores_selecionados') <span class="text-error text-sm mt-2">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Linha do Preço e Imagem da Capa -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Preço</span></label>
                    <input type="number" step="0.01" wire:model="preco" class="input input-bordered w-full" placeholder="0.00" />
                    @error('preco') <span class="text-error text-sm mt-2">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-start gap-4">
                    <div class="form-control w-full">
                        <label class="label"><span class="label-text font-semibold">Imagem da Capa</span></label>
                        <input type="file" wire:model="imagem_capa" class="file-input file-input-bordered w-full" />
                        @error('imagem_capa') <span class="text-error text-sm mt-2">{{ $message }}</span> @enderror
                    </div>
                    @if ($imagem_capa || $imagem_capa_url)
                        <div class="form-control">
                             <label class="label"><span class="label-text opacity-0">Preview</span></label>
                            <div class="w-[60px] h-[60px] bg-base-200 rounded-lg overflow-hidden shadow-md shrink-0">
                                <img src="{{ $imagem_capa ? $imagem_capa->temporaryUrl() : $imagem_capa_url }}" class="w-full h-full object-cover" alt="Preview da capa">
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Botões de Ação do Formulário -->
            <div class="flex justify-end gap-4 pt-4">
                <button type="button" class="btn btn-ghost" onclick="add_livro_modal.close()">Cancelar</button>
                
                <button 
                    type="button" 
                    onclick="if(confirm('Tem a certeza que deseja guardar as alterações?')) { Livewire.dispatch('call-save') }"
                    class="btn btn-primary"
                >
                    <span wire:loading.remove>
                        @if ($livroAEditar)
                            Atualizar Livro
                        @else
                            Guardar Livro
                        @endif
                    </span>
                    {{-- O spinner geral para o botão de guardar, que só aparece quando 'call-save' está a correr --}}
                    <span wire:loading wire:target="save" class="loading loading-spinner"></span>
                </button>
            </div>
        </div>
    </form>
</div>