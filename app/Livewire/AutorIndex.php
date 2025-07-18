<?php

namespace App\Livewire;

use App\Models\Autor;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AutorIndex extends Component
{
    public string $pesquisa = '';
    public array $selecionados = [];

    #[On('autor-adicionado')]
    public function fecharModalEAtualizar()
    {
        $this->dispatch('close-modal', 'add_autor_modal');
    }

    /**
     * NOVA LÓGICA - Passo 1: Inicia o processo de exclusão.
     * Este método é chamado quando o botão de apagar é clicado.
     */
    #[On('iniciar-apagamento-autor')]
    public function iniciarApagamentoAutor($autorId)
    {
        // -------------------------------------------------------------------
        // PONTO DE DEBUG 1: Verificar se o clique do botão chega aqui e qual o ID.
        // Descomente a linha abaixo, salve e clique no botão ❌ na página.
        // -------------------------------------------------------------------
        // dd('DEBUG 1: Método iniciarApagamentoAutor() foi chamado com o autorId:', $autorId);


        // Carrega o autor e a contagem de livros de forma eficiente
        $autor = Autor::withCount('livros')->find($autorId);

        // -------------------------------------------------------------------
        // PONTO DE DEBUG 2: Verificar o autor e a contagem de livros.
        // Comente o DD anterior, descomente este, salve e clique no botão ❌.
        // -------------------------------------------------------------------
        // dd(
        //     'DEBUG 2: Dados do autor carregado',
        //     $autor->toArray(), 
        //     'Contagem de livros (livros_count)', 
        //     $autor->livros_count
        // );


        if (!$autor) {
            return; // Medida de segurança, caso o autor já tenha sido apagado
        }

        if ($autor->livros_count > 0) {
            $this->dispatch('confirmar-apagamento-com-livros', [
                'autorId'     => $autor->id,
                'nomeAutor'   => $autor->nome,
                'livrosCount' => $autor->livros_count,
            ]);
        } 
        else {
            $this->forcarApagarAutor($autorId);
        }
    }

    /**
     * NOVA LÓGICA - Passo 2: Executa a exclusão final.
     * Ouve o evento do JavaScript (após o usuário confirmar) ou é chamado diretamente
     * pelo método acima. Este método realiza a exclusão final.
     */
    #[On('forcar-apagar-autor')]
    public function forcarApagarAutor($autorId)
    {
        // -------------------------------------------------------------------
        // PONTO DE DEBUG 3: Verificar se a confirmação do JS chegou aqui.
        // Comente os DDs anteriores, descomente este. Clique no ❌ de um autor COM livros e clique "OK" no popup.
        // -------------------------------------------------------------------
        // dd('DEBUG 3: Método forcarApagarAutor() foi chamado com o autorId:', $autorId);


        $autor = Autor::withCount('livros')->find($autorId);
        
        if (!$autor) {
            return;
        }

        // -------------------------------------------------------------------
        // PONTO DE DEBUG 4: Verificar a contagem ANTES de apagar qualquer coisa.
        // Comente os DDs anteriores, descomente este. Repita o teste anterior.
        // -------------------------------------------------------------------
        // dd(
        //     'DEBUG 4: Contagem de livros no momento da exclusão',
        //     $autor->livros_count
        // );

        
        $livrosAssociadosCount = $autor->livros_count;
        
        if ($autor->foto) {
            Storage::disk('public')->delete($autor->foto);
        }
        
        $autor->livros()->detach();
        $autor->delete();
        $this->selecionados = array_diff($this->selecionados, [$autorId]);

        if ($livrosAssociadosCount > 0) {
            $this->dispatch('show-feedback', [
                'title'   => 'Autor Apagado',
                'message' => 'Lembre-se de editar os ' . $livrosAssociadosCount . ' livro(s) que estavam associados para atribuir um novo autor.',
                'style'   => 'warning'
            ]);
        } else {
            $this->dispatch('show-feedback', [
                'title'   => 'Sucesso!',
                'message' => 'O autor foi apagado com sucesso.',
                'style'   => 'success'
            ]);
        }
    }

    public function render()
    {
        $query = Autor::query();

        if (strlen($this->pesquisa) > 0) {
            $query->where('nome', 'like', '%' . $this->pesquisa . '%');
        }

        $autores = $query->orderBy('nome')->get();
        
        $idsVisiveis = $autores->pluck('id')->toArray();

        return view('livewire.autor-index', [
            'autores' => $autores,
            'idsVisiveis' => $idsVisiveis 
        ]);
    }
}