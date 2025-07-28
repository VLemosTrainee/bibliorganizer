<x-action-section>
    <x-slot name="title">{{ __('Apagar Conta') }}</x-slot>
    <x-slot name="description">{{ __('Apague permanentemente a sua conta.') }}</x-slot>
    <x-slot name="content">
        {{-- ... (Traduza o texto interno) ... --}}
        <x-danger-button wire:click="confirmUserDeletion" wire:loading.attr="disabled">{{ __('Apagar Conta') }}</x-danger-button>
    </x-slot>
</x-action-section>