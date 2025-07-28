<?php
namespace App\Livewire;

use App\Models\Autor;
use App\Models\Editora;
use App\Models\Livro;
use App\Models\User; // Importar o Model User
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            // Lógica para a dashboard do Admin
            $totalLivros = Livro::sum('stock_total');
            $totalAutores = Autor::count();
            $totalEditoras = Editora::count();
            $editoraDestaque = Editora::withCount('livros')->orderByDesc('livros_count')->orderBy('id', 'asc')->first();
            $autorDestaque = Autor::withCount('livros')->orderByDesc('livros_count')->orderBy('id', 'asc')->first();
            $ultimosAdicionados = Livro::with('autores')->latest()->take(5)->get();
            $maisBaratos = Livro::with('autores')->orderBy('preco', 'asc')->take(5)->get();
            
            return view('livewire.admin-dashboard', compact(
                'totalLivros', 'totalAutores', 'totalEditoras', 'editoraDestaque',
                'autorDestaque', 'ultimosAdicionados', 'maisBaratos'
            ));
        } 
        else {
            // Lógica para a dashboard do Cidadão
            $minhasRequisicoes = $user->requisicoes()->with('livro')->latest()->take(3)->get();
            $livrosPopulares = Livro::with('autores')->withCount('requisicoes')->orderBy('requisicoes_count', 'desc')->take(5)->get();

            // Chama o novo algoritmo para obter as sugestões
            $livrosSugeridos = $this->obterLivrosSugeridos($user);

            return view('livewire.cidadao-dashboard', compact(
                'minhasRequisicoes', 'livrosPopulares', 'livrosSugeridos'
            ));
        }
    }

    /**
     * Algoritmo para obter livros sugeridos com base no histórico de leitura.
     */
    private function obterLivrosSugeridos(User $user)
    {
        // 1. Recolhe os IDs dos livros que o utilizador já leu (requisições concluídas)
        $idsLivrosLidos = $user->requisicoes()->where('status', 'concluida')->pluck('livro_id');

        // Se o utilizador não tem histórico, não há nada a sugerir
        if ($idsLivrosLidos->isEmpty()) {
            return collect();
        }

        // 2. Junta todas as bibliografias dos livros lidos num único texto
        $bibliografias = Livro::whereIn('id', $idsLivrosLidos)->pluck('bibliografia')->implode(' ');

        if (empty(trim($bibliografias))) {
            return collect();
        }

        // 3. Analisa o texto para encontrar as palavras-chave mais importantes
        $stopwords = [
            'a', 'ao', 'aos', 'as', 'às', 'com', 'da', 'das', 'de', 'do', 'dos', 'e', 'é', 'em', 'era',
            'essa', 'esse', 'esta', 'este', 'foi', 'mas', 'na', 'nas', 'não', 'no', 'nos', 'o', 'os',
            'ou', 'para', 'pela', 'pelas', 'pelo', 'pelos', 'por', 'que', 'se', 'sem', 'sua', 'são', 'um', 'uma'
        ]; // Lista simplificada, pode ser expandida

        // Remove pontuação e números, e converte para minúsculas
        $textoLimpo = preg_replace('/[0-9\p{P}]+/u', '', Str::lower($bibliografias));

        // Divide em palavras, remove stopwords e palavras pequenas
        $palavras = array_filter(
            explode(' ', $textoLimpo),
            fn($palavra) => !in_array($palavra, $stopwords) && strlen($palavra) > 3
        );

        // Conta a frequência de cada palavra e ordena
        $frequenciaPalavras = array_count_values($palavras);
        arsort($frequenciaPalavras);

        // Pega nas 30 palavras mais frequentes
        $palavrasChave = array_slice(array_keys($frequenciaPalavras), 0, 30);

        if (empty($palavrasChave)) {
            return collect();
        }

        // 4. Busca os livros que o utilizador AINDA NÃO LEU e que estão disponíveis
        $livrosParaSugerir = Livro::whereNotIn('id', $idsLivrosLidos)->where('stock_disponivel', '>', 0)->get();

        // 5. Pontua cada livro novo com base nas palavras-chave e retorna os melhores
            return $livrosParaSugerir->map(function ($livro) use ($palavrasChave) {
                $pontuacao = 0;
                $bibliografiaLivro = Str::lower($livro->bibliografia);
                foreach ($palavrasChave as $palavra) {
                    $pontuacao += Str::substrCount($bibliografiaLivro, $palavra);
                }
                $livro->pontuacao_sugestao = $pontuacao;
                return $livro;
            })

            ->where('pontuacao_sugestao', '>=', 20)

            ->sortByDesc('pontuacao_sugestao')
            ->take(4);
                }
}