<div>
    {{-- Spinner de loading --}}
    <div wire:loading class="text-center p-8">
        <span class="loading loading-lg loading-spinner"></span>
    </div>

    @if ($livro)
        <div wire:loading.remove class="p-4 space-y-6">
            <div class="flex flex-col sm:flex-row gap-6">
                <!-- Imagem da Capa -->
                <div class="flex-shrink-0 mx-auto sm:mx-0">
                    <img 
                        src="{{ $livro->imagem_capa ? asset('storage/' . $livro->imagem_capa) : asset('images/noAvailable.jpg') }}" 
                        alt="Capa de {{ $livro->nome }}" 
                        class="w-48 h-auto rounded-lg shadow-lg"
                    >
                </div>

                <!-- Informações Principais -->
                <div class="flex-grow">
                    <h3 class="text-3xl font-bold">{{ $livro->nome }}</h3>
                    <p class="text-lg text-base-content/80 mt-1">
                        por {{ $livro->autores->pluck('nome')->join(', ') }}
                    </p>
                    <div class="mt-4 text-sm space-y-1">
                        <p><span class="font-semibold">Editora:</span> {{ $livro->editora->nome }}</p>
                        <p><span class="font-semibold">ISBN:</span> {{ $livro->isbn }}</p>
                    </div>
                    <div class="mt-6 text-2xl font-bold text-primary">
                        € {{ number_format($livro->preco, 2, ',', '.') }}
                    </div>
                </div>
            </div>

            <!-- Bibliografia -->
            @if($livro->bibliografia)
                <div>
                    <h4 class="text-xl font-semibold border-b pb-2 mb-2">Bibliografia</h4>
                    <div class="prose max-w-none text-base-content/90 max-h-40 overflow-y-auto bg-base-200 p-4 rounded-lg">
                        {{ $livro->bibliografia }}
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>