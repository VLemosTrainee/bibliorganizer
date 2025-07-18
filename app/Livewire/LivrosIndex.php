<?php

namespace App\Livewire;

use App\Models\Livro;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class LivrosIndex extends Component
{
    public string $pesquisa = '';
    public string $ordenarPor = 'nome';
    public string $ordem = 'asc';
    public array $selecionados = [];

    #[On('livro-adicionado')]
    public function fecharModalEAtualizar()
    {
        $this->dispatch('close-modal', 'add_livro_modal');
    }

    // ================================================================
    // A CORREÇÃO ESTÁ AQUI: ADICIONAMOS O ATRIBUTO #[On]
    // Agora este método é um "ouvinte" do evento 'ordenar-lista'.
    // ================================================================
    #[On('ordenar-lista')]
    public function ordenarPor($coluna)
    {
        if ($this->ordenarPor === $coluna) {
            $this->ordem = $this->ordem === 'asc' ? 'desc' : 'asc';
        } else {
            $this->ordem = 'asc';
        }
        $this->ordenarPor = $coluna;
    }

    public function updatingPesquisa()
    {
        // Pode ficar vazio
    }

    public function render()
    {
        $livros = Livro::with(['editora', 'autores'])->get();

        if (strlen($this->pesquisa) > 0) {
            $livros = $livros->filter(function ($livro) {
                $termoPesquisa = Str::lower(Str::ascii($this->pesquisa));
                if (Str::contains(Str::lower(Str::ascii($livro->nome)), $termoPesquisa)) { return true; }
                if (Str::contains($livro->isbn, $this->pesquisa)) { return true; }
                foreach ($livro->autores as $autor) {
                    if (Str::contains(Str::lower(Str::ascii($autor->nome)), $termoPesquisa)) { return true; }
                }
                return false;
            });
        }
        
        $callbackOrdenacao = function ($livro) {
            switch ($this->ordenarPor) {
                case 'preco':
                    return (float) $livro->preco; 
                case 'nome':
                default:
                    return $livro->nome;
            }
        };

        if ($this->ordem === 'asc') {
            $livros = $livros->sortBy($callbackOrdenacao);
        } else {
            $livros = $livros->sortByDesc($callbackOrdenacao);
        }

        $idsVisiveis = $livros->pluck('id')->toArray();

        return view('livewire.livros-index', [
            'livros' => $livros,
            'idsVisiveis' => $idsVisiveis
        ]);
    }

    #[On('apagar-livro')]
    public function apagarLivro($livroId)
    {
        // 1. Encontra o livro que queremos apagar.
        $livro = Livro::find($livroId);

        if ($livro) {
            // 2. Verifica se existe uma imagem de capa associada e apaga-a do disco.
            if ($livro->imagem_capa) {
                Storage::disk('public')->delete($livro->imagem_capa);
            }
            
            // 3. Apaga o registo do livro da tabela 'livros'.
            // Devido ao 'onDelete(cascade)', a base de dados irá apagar
            // automaticamente as linhas correspondentes na tabela 'autor_livro'.
            $livro->delete();

            // (Opcional) Poderíamos enviar uma notificação de sucesso.
            // A re-renderização do Livewire já irá atualizar a lista na tela.
        }
    }
}