<div>
    {{-- CABEÇALHO --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Gerir Utilizadores</h1>
        <a href="{{ route('dashboard') }}" class="btn btn-ghost">Voltar para a Dashboard</a>
    </div>

    {{-- PESQUISA --}}
    <div class="mb-4 p-4 bg-white dark:bg-gray-800 rounded-box shadow">
        <input wire:model.live.debounce.300ms="pesquisa" type="text" placeholder="Pesquisar por nome ou email..." class="input input-bordered w-full sm:w-1/3">
    </div>

    {{-- LISTAGEM DE UTILIZADORES --}}
    <div class="space-y-2">
        @forelse ($utilizadores as $user)
            <div wire:key="{{ $user->id }}" class="flex flex-col sm:flex-row items-center gap-4 bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
                
                <!-- Avatar e Nome -->
                <div class="avatar"><div class="w-12 rounded-full"><img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" /></div></div>
                <div class="flex-grow text-center sm:text-left">
                    <div class="font-bold">{{ $user->name }}</div>
                    <div class="text-sm opacity-70">{{ $user->email }}</div>
                </div>

                <!-- Reputação -->
                <div class="flex-shrink-0 flex flex-col items-center mx-4">
                    <span class="text-xs font-semibold">Reputação</span>
                    <div class="rating rating-sm">
                        @for ($i = 1; $i <= 5; $i++)
                            <input type="radio" name="rating-{{ $user->id }}" class="mask mask-star-2 @if($i <= $user->pontuacao) bg-orange-400 @else bg-gray-300 @endif" disabled />
                        @endfor
                    </div>
                </div>

                <!-- Role e Status -->
                <div class="flex-shrink-0"><span class="badge @if($user->role === 'admin') badge-primary @else badge-ghost @endif">{{ ucfirst($user->role) }}</span></div>
                <div class="flex-shrink-0"><span class="badge @if($user->is_active) badge-success @else badge-error @endif">{{ $user->is_active ? 'Ativo' : 'Inativo' }}</span></div>
                
                <!-- Ações -->
                <div class="flex-shrink-0 w-24 flex justify-center gap-2">
                    {{-- 
                    ================================================================
                    ALTERAÇÃO AQUI: O botão de editar agora é um link <a>
                    ================================================================
                    --}}
                    <a href="{{ route('utilizadores.editar', ['user' => $user->id]) }}" class="btn btn-ghost btn-sm" title="Editar" wire:navigate>
                        ✏️
                    </a>

                    <button 
                        wire:click="$dispatch('apagar-utilizador', { userId: {{ $user->id }} })" 
                        wire:confirm="Tem a certeza que deseja apagar este utilizador?"
                        class="btn btn-ghost btn-sm text-error" title="Apagar"
                        @if($user->id === auth()->id()) disabled @endif
                    >❌</button>
                </div>
            </div>
        @empty
            <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-lg shadow"><p>Nenhum utilizador encontrado.</p></div>
        @endforelse
    </div>

    {{-- PAGINAÇÃO --}}
    <div class="mt-8">{{ $utilizadores->links() }}</div>

</div>