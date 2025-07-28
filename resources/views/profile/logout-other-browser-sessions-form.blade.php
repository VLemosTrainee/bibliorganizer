<x-action-section>
    <x-slot name="title">{{ __('Sessões do Navegador') }}</x-slot>
    <x-slot name="description">{{ __('Faça a gestão e termine as suas sessões ativas noutros navegadores e dispositivos.') }}</x-slot>
    <x-slot name="content">
        {{-- ... (Traduza o texto interno) ... --}}
        <x-button wire:click="confirmLogout" wire:loading.attr="disabled">{{ __('Terminar Sessão nos Outros Navegadores') }}</x-button>
    </x-slot>
</x-action-section>