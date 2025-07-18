<div>
    {{-- CABEÇALHO --}}
    <div class="space-y-6 mb-6">
        {{-- Linha do Título e Botão de Voltar --}}
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <h1 class="text-3xl font-bold">Gerir Autores</h1>
            
            {{-- Botão para voltar para a Dashboard com ícone --}}
            <a href="{{ route('dashboard') }}" class="btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Voltar para a Dashboard
            </a>
        </div>

        {{-- Linha dos Botões de Ação Principais --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            {{-- Botão Exportar --}}
            <button 
                wire:click="$dispatch('exportar-autores', { ids: {{ json_encode(count($selecionados) > 0 ? $selecionados : $idsVisiveis) }} })"
                class="btn btn-success btn-lg w-full"
                @if(count($autores) === 0) disabled @endif>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                Exportar
            </button>
            {{-- Botão Adicionar --}}
            <button class="btn btn-primary btn-lg w-full" onclick="add_autor_modal.showModal()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Adicionar Autor
            </button>
        </div>
    </div>

    {{-- PESQUISA --}}
    <div class="mb-4 p-4 bg-white dark:bg-gray-800 rounded-box shadow">
        <input wire:model.live.debounce.300ms="pesquisa" type="text" placeholder="Pesquisar por nome do autor..." class="input input-bordered w-full sm:w-1/3">
    </div>

    {{-- LISTAGEM --}}
    <div class="space-y-2">
        @forelse ($autores as $autor)
            <div wire:key="{{ $autor->id }}" class="flex items-center gap-4 bg-white dark:bg-gray-800 p-4 rounded-lg shadow hover:bg-base-100 transition duration-150">
                <div class="flex-shrink-0">
                    <input type="checkbox" wire:model.live="selecionados" value="{{ $autor->id }}" class="checkbox checkbox-primary" />
                </div>
                <div 
                    class="flex-shrink-0 bg-base-200 rounded-full overflow-hidden"
                    style="width: 48px !important; height: 48px !important;"
                >
                    <img 
                        src="{{ $autor->foto ? asset('storage/' . $autor->foto) : asset('images/avatar.jpg') }}" 
                        alt="Foto de {{ $autor->nome }}" 
                        class="w-full h-full object-cover" 
                    />
                </div>
                <div class="flex-grow">
                    <div class="text-lg font-bold text-base-content">{{ $autor->nome }}</div>
                </div>
                <div class="flex-shrink-0 w-24 flex justify-center gap-2">
                    <button wire:click.stop="$dispatch('editar-autor', { autorId: {{ $autor->id }} })" class="btn btn-ghost btn-sm" title="Editar">✏️</button>
                    <button 
                    wire:click.stop="$dispatch('iniciar-apagamento-autor', { autorId: {{ $autor->id }} })"
                    class="btn btn-ghost btn-sm text-error" title="Apagar">❌</button>
                                
                </div>
            </div>
        @empty
            <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-lg shadow">
                <p>Nenhum autor encontrado. Comece por adicionar um!</p>
            </div>
        @endforelse
   </div>

{{-- MODAL DE ADICIONAR --}}
<dialog id="add_autor_modal" class="modal" onclose="Livewire.dispatch('resetar-formulario-autor')">
    <div class="modal-box w-11/12 max-w-lg">
        <form method="dialog"><button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button></form>
        <livewire:autor-form />
    </div>
    <form method="dialog" class="modal-backdrop"><button>close</button></form>
</dialog>

{{-- =================================================================== --}}
{{--      NOVO MODAL DE FEEDBACK (ESPECÍFICO PARA ESTA PÁGINA)      --}}
{{-- =================================================================== --}}
<dialog id="feedback_autor_modal" class="modal">
    <div class="modal-box" 
         x-data="{ title: '', message: '' }" 
         x-on:show-feedback-autor.window="
            title = event.detail.title;
            message = event.detail.message;
            feedback_autor_modal.showModal();
         "
    >
        <h3 class="font-bold text-2xl text-error" x-text="title"></h3>
        <p class="py-4" x-text="message"></p>

        <div class="modal-action">
            <form method="dialog">
                <button class="btn">Ok, entendi</button>
            </form>
        </div>
    </div>
    <form method="dialog" class="modal-backdrop"><button>close</button></form>
</dialog>
{{-- =================================================================== --}}