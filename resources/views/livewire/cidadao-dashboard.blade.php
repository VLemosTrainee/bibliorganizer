<div class="space-y-12">
    <div>
        <h2 class="text-2xl font-bold mb-4">Ações Rápidas</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('profile.show') }}" class="card bg-primary text-primary-content shadow-lg hover:bg-primary-focus transition-transform hover:-translate-y-1">
                <div class="card-body items-center text-center p-6"><h2 class="card-title text-xl mt-2">Gerir Meu Perfil</h2></div>
            </a>
            <a href="{{ route('livros.index') }}" class="card bg-secondary text-secondary-content shadow-lg hover:bg-secondary-focus transition-transform hover:-translate-y-1">
                <div class="card-body items-center text-center p-6"><h2 class="card-title text-xl mt-2">Pesquisar Livros</h2></div>
            </a>
            <a href="{{ route('requisicoes.minhas') }}" class="card bg-accent ...">
                <div class="card-body ..."><h2 class="card-title ...">Minhas Requisições</h2></div>
            </a>
        </div>
    </div>
    <div>
        <h2 class="text-2xl font-bold mb-4">Minhas Últimas Requisições</h2>
        <div class="space-y-2">
            @forelse($minhasRequisicoes as $requisicao)
                <div class="bg-base-100 p-4 rounded-lg shadow flex justify-between items-center">
                    <div>
                        <p class="font-bold">{{ $requisicao->livro->nome }}</p>
                        <p class="text-sm">Requisitado em: {{ $requisicao->data_requisicao->format('d/m/Y') }}</p>
                    </div>
                    {{-- 
                    ================================================================
                    LÓGICA DE CORES PARA OS SELOS DE STATUS
                    ================================================================
                    --}}
                    @php
                        $statusClass = match($requisicao->status) {
                            'aprovada' => 'badge-success',
                            'pendente' => 'badge-warning',
                            'em_avaliacao' => 'badge-info',
                            'rejeitada' => 'badge-error',
                            'atrasada' => 'badge-error badge-outline',
                            'concluida' => 'badge-ghost',
                            default => 'badge-ghost',
                        };
                    @endphp
                    <span class="badge {{ $statusClass }}">
                        {{ ucfirst(str_replace('_', ' ', $requisicao->status)) }}
                    </span>
                </div>
            @empty
                <p>Você ainda não fez nenhuma requisição.</p>
            @endforelse
        </div>
    </div>
     <!-- 3. CARROSSEL DOS LIVROS MAIS POPULARES (IMPLEMENTADO) -->
    <div>
        <h2 class="text-2xl font-bold mb-4">Livros Mais Populares</h2>
        <div class="carousel carousel-center w-full space-x-4 rounded-box p-4 bg-base-200">
            @forelse ($livrosPopulares as $livro)
                <div class="carousel-item">
                    <div 
                        wire:click="$dispatch('mostrar-detalhes', { livroId: {{ $livro->id }} })"
                        class="card w-60 bg-base-100 shadow-xl transition-all duration-300 hover:scale-105 hover:shadow-2xl cursor-pointer"
                    >
                        <figure class="h-80"><img src="{{ $livro->imagem_capa ? asset('storage/' . $livro->imagem_capa) : asset('images/noAvailable.jpg') }}" alt="{{ $livro->nome }}" class="w-full h-full object-cover" /></figure>
                        <div class="card-body p-4 relative">
                            <div class="badge badge-accent absolute top-2 right-2 font-bold">{{ $livro->requisicoes_count }} {{ Str::plural('requisição', $livro->requisicoes_count) }}</div>
                            <h3 class="card-title text-sm truncate pt-4" title="{{ $livro->nome }}">{{ $livro->nome }}</h3>
                            <p class="text-xs text-base-content/60 truncate">{{ $livro->autores->pluck('nome')->join(', ') }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center w-full text-base-content/70 p-8">Nenhum livro popular no momento.</div>
            @endforelse
        </div>
    </div>
    {{-- 
================================================================
NOVA SECÇÃO: SUGESTÕES "PODES GOSTAR"
================================================================
--}}
@if($livrosSugeridos->count() > 0)
<div>
    <h2 class="text-2xl font-bold mb-4">Podes Gostar...</h2>
    <div class="carousel carousel-center w-full space-x-4 rounded-box p-4 bg-base-200">
        @foreach ($livrosSugeridos as $livro)
            <div class="carousel-item">
                <div 
                    wire:click="$dispatch('mostrar-detalhes', { livroId: {{ $livro->id }} })"
                    class="card w-60 bg-base-100 shadow-xl transition-all duration-300 hover:scale-105 hover:shadow-2xl cursor-pointer"
                >
                    <figure class="h-80"><img src="{{ $livro->imagem_capa ? asset('storage/' . $livro->imagem_capa) : asset('images/noAvailable.jpg') }}" alt="{{ $livro->nome }}" class="w-full h-full object-cover" /></figure>
                    <div class="card-body p-4">
                        <h3 class="card-title text-sm truncate" title="{{ $livro->nome }}">{{ $livro->nome }}</h3>
                        <p class="text-xs text-base-content/60 truncate">{{ $livro->autores->pluck('nome')->join(', ') }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif
</div>