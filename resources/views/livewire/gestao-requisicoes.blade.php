<div>
    {{-- CABEÇALHO --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Gestão de Requisições</h1>
        <a href="{{ route('dashboard') }}" class="btn btn-ghost">Voltar para a Dashboard</a>
    </div>

    {{-- FILTROS --}}
    <div class="mb-4 p-4 bg-white dark:bg-gray-800 rounded-box shadow space-y-4">
        <input wire:model.live.debounce.300ms="pesquisa" type="text" placeholder="Pesquisar por nº, utilizador, livro..." class="input input-bordered w-full">
        <div class="tabs tabs-boxed">
            <a wire:click.prevent="filtrarPorStatus('')" class="tab @if($filtroStatus === '') tab-active @endif">Todas</a> 
            <a wire:click.prevent="filtrarPorStatus('pendente')" class="tab @if($filtroStatus === 'pendente') tab-active @endif">Pendentes</a> 
            <a wire:click.prevent="filtrarPorStatus('aprovada')" class="tab @if($filtroStatus === 'aprovada') tab-active @endif">Aprovadas/Ativas</a> 
            <a wire:click.prevent="filtrarPorStatus('concluida')" class="tab @if($filtroStatus === 'concluida') tab-active @endif">Concluídas</a>
        </div>
    </div>

    {{-- LISTAGEM DE REQUISIÇÕES (ESTILO CARTÃO) --}}
    <div class="space-y-3">
        @forelse($requisicoes as $req)
        <div wire:key="{{ $req->id }}" class="flex flex-col sm:flex-row items-center gap-4 bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
            
            <!-- Bloco do Livro e Número da Requisição -->
            <div class="flex items-center gap-3 w-full sm:w-1/3">
                <img src="{{ $req->livro->imagem_capa ? asset('storage/' . $req->livro->imagem_capa) : asset('images/noAvailable.jpg') }}" alt="{{ $req->livro->nome }}" class="w-10 h-14 object-cover rounded flex-shrink-0" />
                <div>
                    <div class="font-bold">{{ $req->livro->nome }}</div>
                    <div class="text-sm opacity-70 font-mono">{{ $req->numero_requisicao }}</div>
                </div>
            </div>

              <!-- Bloco do Utilizador (COM REPUTAÇÃO) -->
            <div class="flex items-center gap-3 w-full sm:w-1/4">
                <div class="avatar"><div class="w-10 rounded-full"><img src="{{ $req->user->profile_photo_url }}" alt="{{ $req->user->name }}" /></div></div>
                <div>
                    <div class="font-bold">{{ $req->user->name }}</div>
                    {{-- 
                    ================================================================
                     EXIBIÇÃO DA REPUTAÇÃO
                    ================================================================
                    --}}
                    <div class="rating rating-xs">
                        @for ($i = 1; $i <= 5; $i++)
                            <input type="radio" name="rating-{{ $req->user->id }}-{{ $req->id }}" class="mask mask-star-2 @if($i <= $req->user->pontuacao) bg-orange-400 @else bg-gray-300 @endif" disabled />
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Bloco de Datas e Status -->
            <div class="flex-grow text-center sm:text-left space-y-1">
                <div class="text-xs">Requisitado: <span class="font-semibold">{{ $req->data_requisicao->format('d/m/Y') }}</span></div>
                <div class="text-xs">Devolução: <span class="font-semibold">{{ $req->data_prevista_devolucao->format('d/m/Y') }}</span></div>
                <div>
                    <span class="badge @if($req->status === 'aprovada') badge-success @elseif($req->status === 'pendente') badge-warning @elseif($req->status === 'rejeitada') badge-error @else badge-ghost @endif text-xs">
                        {{ ucfirst(str_replace('_', ' ', $req->status)) }}
                    </span>
                </div>
            </div>

            <!-- Bloco de Ações -->
            <div class="flex-shrink-0 flex flex-col sm:flex-row items-center gap-2 w-full sm:w-auto">
                @if($req->status === 'pendente')
                    <button wire:click="$dispatch('mudar-status-requisicao', { requisicaoId: {{ $req->id }}, novoStatus: 'aprovada' })" class="btn btn-xs btn-success w-24">Aprovar</button>
                    <button wire:click="$dispatch('mudar-status-requisicao', { requisicaoId: {{ $req->id }}, novoStatus: 'rejeitada' })" class="btn btn-xs btn-error w-24">Rejeitar</button>
                @elseif(in_array($req->status, ['aprovada', 'atrasada']))
<a href="{{ route('requisicoes.devolver', ['requisicao' => $req->id]) }}" class="btn btn-sm btn-primary" wire:navigate>
    Devolver
</a>
                @endif
            </div>

        </div>
        @empty
            <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-lg shadow"><p>Nenhuma requisição encontrada para os filtros aplicados.</p></div>
        @endforelse
    </div>
