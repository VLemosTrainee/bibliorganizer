<div>
    {{-- Só mostra o conteúdo se a variável $livro não for nula --}}
    @if ($livro)
        <h3 class="font-bold text-lg mb-4">Confirmar Requisição</h3>
        <div class="card lg:card-side bg-base-100">
            <figure class="w-full lg:w-1/4 flex-shrink-0">
                <img src="{{ $livro->imagem_capa ? asset('storage/' . $livro->imagem_capa) : asset('images/noAvailable.jpg') }}" alt="{{ $livro->nome }}"/>
            </figure>
            <div class="card-body">
                <h2 class="card-title text-2xl">{{ $livro->nome }}</h2>
                <p>por {{ $livro->autores->pluck('nome')->join(', ') }}</p>
                <div class="divider my-2"></div>
                <div class="text-sm space-y-1">
                    <p><span class="font-semibold">Estado de Conservação Atual:</span> {{ $livro->estado_conservacao }}/10</p>
                    <p><span class="font-semibold">Data da Requisição:</span> {{ now()->format('d/m/Y') }}</p>
                    <p class="font-bold text-primary"><span class="font-semibold">Data Prevista de Devolução:</span> {{ now()->addDays(5)->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>
        <div class="modal-action">
            <form method="dialog">
                <button class="btn btn-ghost">Cancelar</button>
            </form>
            {{-- O wire:click chama o método 'confirmar' no seu componente PHP --}}
            <button wire:click="confirmar" class="btn btn-primary">Confirmar e Requisitar</button>
        </div>
    @else
        {{-- Mensagem enquanto o livro não é carregado --}}
        <div class="text-center p-8">
            <span class="loading loading-spinner loading-lg"></span>
        </div>
    @endif
</div>