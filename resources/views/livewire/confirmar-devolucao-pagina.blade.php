<div>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Confirmar Devolução</h1>
        <a href="{{ route('requisicoes.admin') }}" class="btn btn-ghost" wire:navigate>Voltar à Lista</a>
    </div>

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="card-title">{{ $requisicao->livro->nome }}</h2>
                    <p class="text-sm">Requisitado por: <span class="font-semibold">{{ $requisicao->user->name }}</span></p>
                    <p class="text-sm">Nº da Requisição: <span class="font-mono">{{ $requisicao->numero_requisicao }}</span></p>
                    <div class="divider"></div>
                    <p>Estado no Empréstimo: <span class="font-bold text-lg">{{ $requisicao->estado_no_emprestimo }} / 10</span></p>
                </div>
                <div>
                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold">Estado de Conservação na Devolução (0-10)</span></label>
                        <input type="range" min="0" max="10" wire:model.live="estadoDevolucao" class="range range-primary" step="1" />
                        <div class="text-center font-bold text-2xl mt-2">{{ $estadoDevolucao }}</div>
                    </div>
                </div>
            </div>
            <div class="card-actions justify-end mt-6">
                <button wire:click="confirmarDevolucao" class="btn btn-primary">Confirmar Devolução</button>
            </div>
        </div>
    </div>
</div>