<div>
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

    {{-- LISTAGEM (coloque aqui a sua tabela para listar as $requisicoes) --}}
    <div class="overflow-x-auto bg-white rounded-box shadow">
        <table class="table w-full align-middle">
            <thead>
                <tr>
                    <th>Nº Requisição</th>
                    <th>Livro</th>
                    <th>Utilizador</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($requisicoes as $requisicao)
                    <tr>
                        <td>{{ $requisicao->numero_requisicao }}</td>
                        <td>{{ $requisicao->livro->nome }}</td>
                        <td>{{ $requisicao->user->name }}</td>
                        <td><span class="badge">{{ $requisicao->status }}</span></td>
                        <td>...</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Nenhuma requisição encontrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $requisicoes->links() }}
    </div>
</div>