<div>
    {{-- NOVO CABEÇALHO ALINHADO --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h1 class="text-3xl font-bold">Minhas Requisições</h1>
            <p class="text-base-content/70">Olá, <span class="font-semibold">{{ auth()->user()->name }}</span>! Este é o seu histórico.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-ghost">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Voltar ao Início
        </a>
    </div>

            {{-- SECÇÃO DE REPUTAÇÃO (ALINHADA À ESQUERDA) --}}
        <div class="mb-8 p-2 bg-base-200 rounded-box">
            <p class="text-sm font-semibold mb-1">A sua Reputação Atual</p>
            <div class="rating rating-lg">
                @for ($i = 1; $i <= 5; $i++)
                    <input type="radio" name="reputacao-cidadao" class="mask mask-star-2 @if($i <= $reputacao) bg-orange-400 @else bg-gray-300 @endif" disabled />
                @endfor
            </div>
            <p class="text-xs text-base-content/60 mt-1">(A sua reputação afeta a prioridade das suas requisições)</p>
        </div>


    {{-- LISTAGEM DO HISTÓRICO DE REQUISIÇÕES --}}
    <div class="space-y-4">
        @forelse ($requisicoes as $req)
            <div wire:key="{{ $req->id }}" class="card lg:card-side bg-base-100 shadow-md">
                <figure class="w-full lg:w-1/6 flex-shrink-0">
                    <img src="{{ $req->livro->imagem_capa ? asset('storage/' . $req->livro->imagem_capa) : asset('images/noAvailable.jpg') }}" alt="{{ $req->livro->nome }}" class="w-full h-full object-cover"/>
                </figure>
                <div class="card-body">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="card-title">{{ $req->livro->nome }}</h2>
                            <p class="text-sm font-mono">{{ $req->numero_requisicao }}</p>
                        </div>
                        @php
                            $statusClass = match($req->status) {
                                'aprovada' => 'badge-success',
                                'pendente' => 'badge-warning', 'em_avaliacao' => 'badge-info',
                                'rejeitada' => 'badge-error', 'atrasada' => 'badge-error badge-outline',
                                'concluida' => 'badge-ghost', default => 'badge-ghost',
                            };
                        @endphp
                        <span class="badge {{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $req->status)) }}</span>
                    </div>

                    <div class="divider my-2"></div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div>
                            <p class="font-semibold">Data da Requisição</p>
                            <p>{{ $req->data_requisicao->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <p class="font-semibold">Devolução Prevista</p>
                            <p>{{ $req->data_prevista_devolucao->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            @if($req->data_devolucao_efetiva)
                                <p class="font-semibold">Entregue em</p>
                                <p>{{ $req->data_devolucao_efetiva->format('d/m/Y') }}</p>
                            @endif
                        </div>
                    </div>

                    @if($req->status === 'concluida')
                        <div class="mt-4 pt-4 border-t">
                            <p class="font-semibold text-sm">Registo de Conservação:</p>
                            <div class="flex items-center gap-4 text-sm mt-1">
                                <span>Levantou: <span class="badge badge-outline">{{ $req->estado_no_emprestimo }}/10</span></span>
                                <span>→</span>
                                <span>Entregou: <span class="badge badge-outline">{{ $req->estado_na_devolucao }}/10</span></span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-lg shadow">
                <p>Você ainda não tem um histórico de requisições.</p>
                <a href="{{ route('livros.index') }}" class="btn btn-primary mt-4" wire:navigate>Ver Livros Disponíveis</a>
            </div>
        @endforelse
    </div>

    {{-- PAGINAÇÃO --}}
    <div class="mt-8">
        {{ $requisicoes->links() }}
    </div>
</div>