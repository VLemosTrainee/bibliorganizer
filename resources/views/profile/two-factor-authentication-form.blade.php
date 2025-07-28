<x-action-section>
    <x-slot name="title">{{ __('Autenticação de Dois Fatores') }}</x-slot>
    <x-slot name="description">{{ __('Adicione segurança adicional à sua conta usando a autenticação de dois fatores.') }}</x-slot>
    <x-slot name="content">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            @if ($this->enabled)
                {{ __('Você ativou a autenticação de dois fatores.') }}
            @else
                {{ __('Você não ativou a autenticação de dois fatores.') }}
            @endif
        </h3>
        <div class="mt-3 max-w-xl text-sm text-gray-600 dark:text-gray-400">
            <p>{{ __('Quando a autenticação de dois fatores está ativa, ser-lhe-á pedido um token seguro e aleatório durante a autenticação. Pode obter este token na aplicação Google Authenticator do seu telemóvel.') }}</p>
        </div>
        {{-- Resto do conteúdo (QR Code, etc.) pode ser traduzido se necessário --}}
        <x-button type="button" class="mt-4" wire:click="enableTwoFactorAuthentication" wire:loading.attr="disabled">{{ __('Ativar') }}</x-button>
    </x-slot>
</x-action-section>