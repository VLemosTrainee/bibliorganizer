<div>
   
    <div class="space-y-6 mb-6">
        {{-- Linha do Título e Botão de Voltar --}}
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <h1 class="text-3xl font-bold">Gerir Editoras</h1>
            <a href="{{ route('dashboard') }}" class="btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Voltar para a Dashboard
            </a>
        </div>

        {{-- Linha dos Botões de Ação Principais --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            {{-- Botão Exportar --}}
            <button 
                wire:click="$dispatch('exportar-editoras', { ids: {{ json_encode(count($selecionados) > 0 ? $selecionados : $idsVisiveis) }} })"
                class="btn btn-success btn-lg w-full" 
                @if(count($editoras) === 0) disabled @endif>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                Exportar
            </button>
            {{-- Botão Adicionar --}}
            <button class="btn btn-primary btn-lg w-full" onclick="add_editora_modal.showModal()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Adicionar Editora
            </button>
        </div>
    </div>

    {{-- PESQUISA --}}
    <div class="mb-4 p-4 bg-white dark:bg-gray-800 rounded-box shadow">
        <input wire:model.live.debounce.300ms="pesquisa" type="text" placeholder="Pesquisar por nome da editora..." class="input input-bordered w-full sm:w-1/3">
    </div>

    {{-- LISTAGEM --}}
    <div class="space-y-2">
        @forelse ($editoras as $editora)
            <div wire:key="{{ $editora->id }}" class="flex items-center gap-4 bg-white dark:bg-gray-800 p-4 rounded-lg shadow hover:bg-base-100 transition">
                <div class="flex-shrink-0">
                    <input type="checkbox" wire:model.live="selecionados" value="{{ $editora->id }}" class="checkbox checkbox-primary" />
                </div>
                <div class="flex-shrink-0 w-12 h-12 bg-base-200 rounded-lg overflow-hidden flex items-center justify-center">
                    <img src="{{ $editora->logotipo ? asset('storage/' . $editora->logotipo) : asset('images/noAvailable.jpg') }}" alt="Logótipo de {{ $editora->nome }}" class="w-full h-auto object-contain" />
                </div>
                <div class="flex-grow">
                    <div class="text-lg font-bold">{{ $editora->nome }}</div>
                </div>
                <div class="flex-shrink-0 w-24 flex justify-center gap-2">
                    <button wire:click.stop="$dispatch('editar-editora', { editoraId: {{ $editora->id }} })" class="btn btn-ghost btn-sm" title="Editar">✏️</button>
                    <button 
                        wire:click.stop="$dispatch('apagar-editora', { editoraId: {{ $editora->id }} })" 
                        wire:confirm="Tem a certeza que deseja apagar esta editora?" 
                        class="btn btn-ghost btn-sm text-error" title="Apagar">❌</button>
                </div>
            </div>
        @empty
            <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-lg shadow"><p>Nenhuma editora encontrada.</p></div>
        @endforelse
    </div>
    
       @if ($editoras instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="mt-4">{{ $editoras->links() }}</div>
    @endif

    {{-- MODAL --}}
    <dialog id="add_editora_modal" class="modal" onclose="Livewire.dispatch('resetar-formulario-editora')">
        <div class="modal-box w-11/12 max-w-lg">
            <form method="dialog"><button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button></form>
            <livewire:editora-form />
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>
</div>