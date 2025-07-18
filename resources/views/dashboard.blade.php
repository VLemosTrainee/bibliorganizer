<div class="space-y-12"> {{-- Aumentei o espaçamento entre as secções --}}
    
    <!-- 1. SECÇÃO DE AÇÕES RÁPIDAS (sem alterações) -->
    <div>
        <h2 class="text-2xl font-bold mb-4">Ações Rápidas</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Adicionar Livro -->
            <button onclick="add_livro_modal.showModal()" class="card bg-primary text-primary-content shadow-lg hover:bg-primary-focus transition-transform hover:-translate-y-1">
                <div class="card-body items-center text-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v11.494m-5.747-5.747H17.747" /></svg><h2 class="card-title text-xl">Adicionar Novo Livro</h2></div>
            </button>
            <!-- Adicionar Autor -->
            <button onclick="add_autor_modal.showModal()" class="card bg-secondary text-secondary-content shadow-lg hover:bg-secondary-focus transition-transform hover:-translate-y-1">
                <div class="card-body items-center text-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg><h2 class="card-title text-xl">Adicionar Novo Autor</h2></div>
            </button>
            <!-- Adicionar Editora -->
            <button onclick="add_editora_modal.showModal()" class="card bg-accent text-accent-content shadow-lg hover:bg-accent-focus transition-transform hover:-translate-y-1">
                <div class="card-body items-center text-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg><h2 class="card-title text-xl">Adicionar Nova Editora</h2></div>
            </button>
        </div>
    </div>

    <!-- 2. SECÇÃO DE ESTATÍSTICAS (sem alterações) -->
    <div>
        <h2 class="text-2xl font-bold mb-4">Visão Geral</h2>
        <div class="stats shadow w-full">
            {{-- ... (seus stats aqui) ... --}}
        </div>
    </div>
    
    {{-- ======================================================= --}}
    <!-- 3. CARROSSEL: ÚLTIMOS LIVROS ADICIONADOS -->
    {{-- ======================================================= --}}
    <div>
        <h2 class="text-2xl font-bold mb-4">Recém-Adicionados</h2>
        <div class="carousel carousel-center w-full space-x-4 rounded-box p-4 bg-neutral">
            @forelse ($ultimosAdicionados as $livro)
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
            @empty
                <div class="text-center w-full text-neutral-content">Nenhum livro para mostrar.</div>
            @endforelse
        </div>
    </div>

    {{-- ======================================================= --}}
    <!-- 4. CARROSSEL: LIVROS MAIS BARATOS -->
    {{-- ======================================================= --}}
    <div>
        <h2 class="text-2xl font-bold mb-4">Livros em Destaque (Preço)</h2>
        <div class="carousel carousel-center w-full space-x-4 rounded-box p-4 bg-neutral">
            @forelse ($maisBaratos as $livro)
                <div class="carousel-item">
                    <div 
                        wire:click="$dispatch('mostrar-detalhes', { livroId: {{ $livro->id }} })"
                        class="card w-60 bg-base-100 shadow-xl transition-all duration-300 hover:scale-105 hover:shadow-2xl cursor-pointer"
                    >
                        <figure class="h-80"><img src="{{ $livro->imagem_capa ? asset('storage/' . $livro->imagem_capa) : asset('images/noAvailable.jpg') }}" alt="{{ $livro->nome }}" class="w-full h-full object-cover" /></figure>
                        <div class="card-body p-4 relative">
                            <div class="badge badge-secondary absolute top-2 right-2 font-bold">€ {{ number_format($livro->preco, 2, ',', '.') }}</div>
                            <h3 class="card-title text-sm truncate pt-4" title="{{ $livro->nome }}">{{ $livro->nome }}</h3>
                            <p class="text-xs text-base-content/60 truncate">{{ $livro->autores->pluck('nome')->join(', ') }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center w-full text-neutral-content">Nenhum livro para mostrar.</div>
            @endforelse
        </div>
    </div>

    <!-- 5. SECÇÃO DE DESTAQUES (AUTOR/EDITORA - sem alterações) -->
    <div>
         <h2 class="text-2xl font-bold mb-4">Destaques da Coleção</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @if($editoraDestaque)
            <div class="card bg-base-100 shadow-xl">
                {{-- ... (código da editora destaque aqui) ... --}}
            </div>
            @endif
            @if($autorDestaque)
            <div class="card bg-base-100 shadow-xl">
                {{-- ... (código do autor destaque aqui) ... --}}
            </div>
            @endif
        </div>
    </div>

</div>