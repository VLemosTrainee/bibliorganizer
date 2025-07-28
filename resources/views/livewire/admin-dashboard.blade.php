<div class="space-y-12">
    
    <!-- 1. SECÇÃO DE AÇÕES RÁPIDAS -->
    <div>
        <h2 class="text-2xl font-bold mb-4 text-base-content">Ações Rápidas</h2>
        
        {{-- ALTERAÇÃO AQUI: de lg:grid-cols-4 para lg:grid-cols-5 --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-1.5">

            <a href="{{ route('livros.index') }}" class="card bg-primary text-primary-content shadow-lg hover:bg-primary-focus transition-transform hover:-translate-y-1">
                <div class="card-body items-center text-center p-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                    <h2 class="card-title text-xl mt-2">Gerir Livros</h2>
                </div>
            </a>

            <a href="{{ route('autores.index') }}" class="card bg-secondary text-secondary-content shadow-lg hover:bg-secondary-focus transition-transform hover:-translate-y-1">
                <div class="card-body items-center text-center p-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    <h2 class="card-title text-xl mt-2">Gerir Autores</h2>
                </div>
            </a>

            <a href="{{ route('editoras.index') }}" class="card bg-accent text-accent-content shadow-lg hover:bg-accent-focus transition-transform hover:-translate-y-1">
                <div class="card-body items-center text-center p-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                    <h2 class="card-title text-xl mt-2">Gerir Editoras</h2>
                </div>
            </a>
            
            <a href="{{ route('utilizadores.index') }}" class="card bg-neutral text-neutral-content shadow-lg hover:bg-neutral-focus transition-transform hover:-translate-y-1">
                <div class="card-body items-center text-center p-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197m0 0A5.975 5.975 0 0112 13a5.975 5.975 0 01-3 5.197M15 21a9 9 0 100-18 9 9 0 000 18zm-9-2a9 9 0 00-3-5.197" /></svg>
                    <h2 class="card-title text-xl mt-2">Gerir Utilizadores</h2>
                </div>
            </a>
            
            <a href="{{ route('requisicoes.admin') }}" class="card bg-info text-info-content shadow-lg hover:bg-info-focus transition-transform hover:-translate-y-1">
                <div class="card-body items-center text-center p-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                    <h2 class="card-title text-xl mt-2">Gerir Requisições</h2>
                </div>
            </a>
        </div>
    </div>

    <!-- 2. SECÇÃO DE ESTATÍSTICAS -->
    <div>
        <h2 class="text-2xl font-bold mb-4 text-base-content">Visão Geral</h2>
        <div class="stats shadow w-full">
            <div class="stat"><div class="stat-figure text-primary"><svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg></div><div class="stat-title">Total de Livros</div><div class="stat-value text-primary">{{ $totalLivros }}</div></div>
            <div class="stat"><div class="stat-figure text-secondary"><svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg></div><div class="stat-title">Total de Autores</div><div class="stat-value text-secondary">{{ $totalAutores }}</div></div>
            <div class="stat"><div class="stat-figure text-accent"><svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg></div><div class="stat-title">Total de Editoras</div><div class="stat-value text-accent">{{ $totalEditoras }}</div></div>
        </div>
    </div>
    
<!-- 3. CARROSSEL: ÚLTIMOS LIVROS ADICIONADOS -->
<div>
    <h2 class="text-2xl font-bold mb-4 text-base-content">Recém-Adicionados</h2>
    <div class="carousel carousel-center w-full space-x-4 rounded-box p-4 dark:bg-black" style="background-color: #f5f5faff;">
        @forelse ($ultimosAdicionados as $livro)
            <div class="carousel-item">
                <div wire:click="$dispatch('mostrar-detalhes', { livroId: {{ $livro->id }} })" class="card w-60 bg-base-100 shadow-xl transition-all duration-300 hover:scale-105 hover:shadow-2xl cursor-pointer">
                    <figure class="h-80">
                        <img src="{{ $livro->imagem_capa ? asset('storage/' . $livro->imagem_capa) : asset('images/noAvailable.jpg') }}" alt="{{ $livro->nome }}" class="w-full h-full object-cover" />
                    </figure>
                    <div class="card-body p-4">
                        <h3 class="card-title text-sm truncate" title="{{ $livro->nome }}">{{ $livro->nome }}</h3>
                        <p class="text-xs text-base-content/60 truncate">{{ $livro->autores->pluck('nome')->join(', ') }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center w-full text-neutral-content p-8">Nenhum livro para mostrar.</div>
        @endforelse
    </div>
</div>

<!-- 4. CARROSSEL: LIVROS MAIS BARATOS -->
<div>
    <h2 class="text-2xl font-bold mb-4 text-base-content">Livros em Destaque (Preço)</h2>
    <div class="carousel carousel-center w-full space-x-4 rounded-box p-4 dark:bg-black" style="background-color: #e5e7eb;">
        @forelse ($maisBaratos as $livro)
            <div class="carousel-item">
                <div wire:click="$dispatch('mostrar-detalhes', { livroId: {{ $livro->id }} })" class="card w-60 bg-base-100 shadow-xl transition-all duration-300 hover:scale-105 hover:shadow-2xl cursor-pointer">
                    <figure class="h-80">
                        <img src="{{ $livro->imagem_capa ? asset('storage/' . $livro->imagem_capa) : asset('images/noAvailable.jpg') }}" alt="{{ $livro->nome }}" class="w-full h-full object-cover" />
                    </figure>
                    <div class="card-body p-4 relative">
                        <div class="badge badge-secondary absolute top-2 right-2 font-bold">€ {{ number_format($livro->preco, 2, ',', '.') }}</div>
                        <h3 class="card-title text-sm truncate pt-4" title="{{ $livro->nome }}">{{ $livro->nome }}</h3>
                        <p class="text-xs text-base-content/60 truncate">{{ $livro->autores->pluck('nome')->join(', ') }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center w-full text-neutral-content p-8">Nenhum livro para mostrar.</div>
        @endforelse
    </div>
</div>


    <!-- 5. SECÇÃO DE DESTAQUES (AUTOR/EDITORA) -->
    <div>
        <h2 class="text-2xl font-bold mb-4 text-base-content">Destaques da Coleção</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            @if($editoraDestaque)
            <div class="card bg-base-100 shadow-xl"><div class="card-body"><h2 class="card-title text-base-content/70">Editora com Mais Livros</h2><div class="flex items-center gap-4 mt-2"><div class="avatar"><div class="w-16 rounded-lg"><img src="{{ $editoraDestaque->logotipo ? asset('storage/' . $editoraDestaque->logotipo) : asset('images/noAvailable.jpg') }}" /></div></div><div><p class="text-xl font-bold">{{ $editoraDestaque->nome }}</p><p class="text-sm">{{ $editoraDestaque->livros_count }} {{ Str::plural('livro', $editoraDestaque->livros_count) }}</p></div></div></div></div>
            @endif
            @if($autorDestaque)
            <div class="card bg-base-100 shadow-xl"><div class="card-body"><h2 class="card-title text-base-content/70">Autor com Mais Livros</h2><div class="flex items-center gap-4 mt-2"><div class="avatar"><div class="w-16 rounded-full"><img src="{{ $autorDestaque->foto ? asset('storage/' . $autorDestaque->foto) : asset('images/avatar.jpg') }}" /></div></div><div><p class="text-xl font-bold">{{ $autorDestaque->nome }}</p><p class="text-sm">{{ $autorDestaque->livros_count }} {{ Str::plural('livro', $autorDestaque->livros_count) }}</p></div></div></div></div>
            @endif
        </div>
    </div>

    {{-- MODAL PARA DETALHES DE LIVROS --}}
    <dialog id="detalhes_livro_modal" class="modal">
        <div class="modal-box w-11/12 max-w-4xl">
            <form method="dialog"><button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button></form>
            <livewire:livro-detalhes />
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>
</div>