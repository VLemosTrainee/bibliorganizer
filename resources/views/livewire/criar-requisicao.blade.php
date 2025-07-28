<div>
    <h1 class="text-3xl font-bold mb-6">Confirmar Requisição</h1>

    @if(session('erro'))
        <div class="alert alert-error mb-4">{{ session('erro') }}</div>
    @endif

    <div class="card lg:card-side bg-base-100 shadow-xl">
        <figure class="w-full lg:w-1/3"><img src="{{ $livro->imagem_capa ? asset('storage/' . $livro->imagem_capa) : asset('images/noAvailable.jpg') }}" alt="{{ $livro->nome }}"/></figure>
        <div class="card-body">
            <h2 class="card-title text-2xl">{{ $livro->nome }}</h2>
            <p>por {{ $livro->autores->pluck('nome')->join(', ') }}</p>
            <div class="divider"></div>
            <p><span class="font-semibold">Estado de Conservação Atual:</span> {{ $livro->estado_conservacao }}/10</p>
            <p><span class="font-semibold">Data da Requisição:</span> {{ now()->format('d/m/Y') }}</p>
            <p class="font-bold"><span class="font-semibold">Data Prevista de Devolução:</span> {{ now()->addDays(5)->format('d/m/Y') }}</p>
            <div class="card-actions justify-end mt-4">
                <a href="{{ route('livros.index') }}" class="btn btn-ghost" wire:navigate>Cancelar</a>
                <button wire:click="confirmarRequisicao" class="btn btn-primary">Confirmar e Requisitar</button>
            </div>
        </div>
    </div>
</div>