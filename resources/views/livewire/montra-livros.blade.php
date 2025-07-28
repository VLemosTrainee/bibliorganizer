<div>
    {{-- Barra de Navegação para Visitantes --}}
    <nav class="bg-white shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-primary" BookOrganizer</a>
                <div class="space-x-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-ghost">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-ghost">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">Registar Conta</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- O conteúdo principal agora tem um padding --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="space-y-12">
    
            <!-- SECÇÃO DE AÇÕES PARA VISITANTES -->
            <div>
                <h2 class="text-2xl font-bold mb-4 text-base-content">Junte-se à nossa comunidade</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <a href="{{ route('login') }}" class="card bg-primary text-primary-content shadow-lg hover:bg-primary-focus transition-transform hover:-translate-y-1">
                        <div class="card-body items-center text-center p-6"><svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg><h2 class="card-title text-xl mt-2">Login</h2></div>
                    </a>
                    <a href="{{ route('register') }}" class="card bg-secondary text-secondary-content shadow-lg hover:bg-secondary-focus transition-transform hover:-translate-y-1">
                        <div class="card-body items-center text-center p-6"><svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg><h2 class="card-title text-xl mt-2">Registar Conta</h2></div>
                    </a>
                </div>
            </div>
        
            <!-- CARROSSEL: ÚLTIMOS LIVROS ADICIONADOS -->
            <div>
                <h2 class="text-2xl font-bold mb-4 text-base-content">Recém-Adicionados</h2>
                {{-- ALTERAÇÃO AQUI: de bg-neutral para bg-base-200 --}}
                <div class="carousel carousel-center w-full space-x-4 rounded-box p-4 bg-base-200">
                    @forelse ($ultimosAdicionados as $livro)
                        <div class="carousel-item">
                            {{-- ALTERAÇÃO AQUI: adicionadas as classes de transição e hover --}}
                            <div class="card w-60 bg-base-100 shadow-xl transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                                <figure class="h-80"><img src="{{ $livro->imagem_capa ? asset('storage/' . $livro->imagem_capa) : asset('images/noAvailable.jpg') }}" alt="{{ $livro->nome }}" class="w-full h-full object-cover" /></figure>
                                <div class="card-body p-4">
                                    <h3 class="card-title text-sm truncate" title="{{ $livro->nome }}">{{ $livro->nome }}</h3>
                                    <p class="text-xs text-base-content/60 truncate">{{ $livro->autores->pluck('nome')->join(', ') }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center w-full text-base-content/70 p-8">Nenhum livro para mostrar.</div>
                    @endforelse
                </div>
            </div>
        
            <!-- CARROSSEL: LIVROS MAIS BARATOS -->
            <div>
                <h2 class="text-2xl font-bold mb-4 text-base-content">Livros em Destaque (Preço)</h2>
                {{-- ALTERAÇÃO AQUI: de bg-neutral para bg-base-200 --}}
                <div class="carousel carousel-center w-full space-x-4 rounded-box p-4 bg-base-200">
                    @forelse ($maisBaratos as $livro)
                        <div class="carousel-item">
                            {{-- ALTERAÇÃO AQUI: adicionadas as classes de transição e hover --}}
                            <div class="card w-60 bg-base-100 shadow-xl transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                                <figure class="h-80"><img src="{{ $livro->imagem_capa ? asset('storage/' . $livro->imagem_capa) : asset('images/noAvailable.jpg') }}" alt="{{ $livro->nome }}" class="w-full h-full object-cover" /></figure>
                                <div class="card-body p-4 relative">
                                    <div class="badge badge-secondary absolute top-2 right-2 font-bold">€ {{ number_format($livro->preco, 2, ',', '.') }}</div>
                                    <h3 class="card-title text-sm truncate pt-4" title="{{ $livro->nome }}">{{ $livro->nome }}</h3>
                                    <p class="text-xs text-base-content/60 truncate">{{ $livro->autores->pluck('nome')->join(', ') }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center w-full text-base-content/70 p-8">Nenhum livro para mostrar.</div>
                    @endforelse
                </div>
            </div>
        
            <!-- SECÇÃO DE DESTAQUES -->
            <div>
                <h2 class="text-2xl font-bold mb-4 text-base-content">Destaques da Coleção</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($editoraDestaque)
                        <div class="card bg-base-100 shadow-xl"><div class="card-body"><h2 class="card-title text-base-content/70">Editora Popular</h2><div class="flex items-center gap-4 mt-2"><div class="avatar"><div class="w-16 rounded-lg"><img src="{{ $editoraDestaque->logotipo ? asset('storage/' . $editoraDestaque->logotipo) : asset('images/noAvailable.jpg') }}" /></div></div><div><p class="text-xl font-bold">{{ $editoraDestaque->nome }}</p><p class="text-sm">{{ $editoraDestaque->livros_count }} {{ Str::plural('livro', $editoraDestaque->livros_count) }}</p></div></div></div></div>
                    @endif
                    @if($autorDestaque)
                        <div class="card bg-base-100 shadow-xl"><div class="card-body"><h2 class="card-title text-base-content/70">Autor Popular</h2><div class="flex items-center gap-4 mt-2"><div class="avatar"><div class="w-16 rounded-full"><img src="{{ $autorDestaque->foto ? asset('storage/' . $autorDestaque->foto) : asset('images/avatar.jpg') }}" /></div></div><div><p class="text-xl font-bold">{{ $autorDestaque->nome }}</p><p class="text-sm">{{ $autorDestaque->livros_count }} {{ Str::plural('livro', $autorDestaque->livros_count) }}</p></div></div></div></div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>