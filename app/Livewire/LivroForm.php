<?php

namespace App\Livewire;

use App\Models\Autor;
use App\Models\Editora;
use App\Models\Livro;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

class LivroForm extends Component
{
    use WithFileUploads;

    public ?Livro $livroAEditar = null;
    public $nome = '';
    public $isbn = '';
    public $editora_id = '';
    public $autores_selecionados = [];
    public $bibliografia = '';
    public $preco = '';
    public $imagem_capa;
    public $imagem_capa_url;
    public $todasEditoras;
    public $todosAutores;

    public function mount()
    {
        $this->carregarDropdowns();
    }

    public function carregarDropdowns()
    {
        $this->todasEditoras = Editora::all()->sortBy('nome');
        $this->todosAutores = Autor::all()->sortBy('nome');
    }

    // ================================================================
    // NOVO MÉTODO: Ouve o evento de fechar o modal e reseta o formulário
    // ================================================================
    #[On('resetar-formulario')]
    public function resetFormulario()
    {
        $this->reset(); // Reseta todas as propriedades públicas (incluindo $livroAEditar)
        $this->carregarDropdowns(); // Recarrega os dropdowns
    }

    #[On('editar-livro')]
    public function carregarParaEdicao($livroId)
    {
        $this->livroAEditar = Livro::find($livroId);
        if ($this->livroAEditar) {
            $this->nome = $this->livroAEditar->nome;
            $this->isbn = $this->livroAEditar->isbn;
            $this->editora_id = $this->livroAEditar->editora_id;
            $this->autores_selecionados = $this->livroAEditar->autores->pluck('id')->toArray();
            $this->bibliografia = $this->livroAEditar->bibliografia;
            $this->preco = $this->livroAEditar->preco;
            if ($this->livroAEditar->imagem_capa) {
                $this->imagem_capa_url = asset('storage/' . $this->livroAEditar->imagem_capa);
            }
        }
        $this->dispatch('open-modal', 'add_livro_modal');
    }

    public function updatedIsbn()
    {
        if (!$this->livroAEditar) {
            $this->reset(['nome', 'editora_id', 'autores_selecionados', 'bibliografia', 'preco', 'imagem_capa', 'imagem_capa_url']);
            $this->lookupIsbn();
        }
    }

    public function lookupIsbn()
    {
        if (empty(trim($this->isbn))) { return; }
        $this->resetErrorBag('isbn');
        $isbnLimpo = str_replace('-', '', $this->isbn);
        $response = Http::get("https://www.googleapis.com/books/v1/volumes?q=isbn:{$isbnLimpo}");

        if ($response->successful() && $response->json('totalItems') > 0) {
            $bookData = $response->json('items.0.volumeInfo');
            $this->nome = $bookData['title'] ?? '';
            $this->bibliografia = $bookData['description'] ?? '';
            if (isset($bookData['imageLinks']['thumbnail'])) {
                $this->imagem_capa_url = str_replace('http://', 'https://', $bookData['imageLinks']['thumbnail']);
            }
            if (isset($bookData['publisher'])) {
                $editoraNome = $bookData['publisher'];
                $editoraExistente = Editora::all()->firstWhere('nome', $editoraNome);
                if ($editoraExistente) {
                    $this->editora_id = $editoraExistente->id;
                } else {
                    $novaEditora = Editora::create(['nome' => $editoraNome]);
                    $this->editora_id = $novaEditora->id;
                }
            }
            if (isset($bookData['authors'])) {
                $authorIds = [];
                $autoresDaBD = Autor::all()->sortBy('nome');
                foreach ($bookData['authors'] as $authorName) {
                    $autorExistente = $autoresDaBD->firstWhere('nome', $authorName);
                    if ($autorExistente) {
                        $authorIds[] = $autorExistente->id;
                    } else {
                        $novoAutor = Autor::create(['nome' => $authorName]);
                        $autoresDaBD->push($novoAutor);
                        $autoresDaBD = $autoresDaBD->sortBy('nome');
                        $authorIds[] = $novoAutor->id;
                    }
                }
                $this->autores_selecionados = $authorIds;
            }
            $this->carregarDropdowns();
        } else {
            $this->addError('isbn', 'ISBN não encontrado ou inválido.');
        }
    }
    
    #[On('call-save')]
    public function save()
    {
        $isbnRule = 'required|string|unique:livros,isbn';
        if ($this->livroAEditar) {
            $isbnRule .= ',' . $this->livroAEditar->id;
        }

        $validatedData = $this->validate([
            'nome' => 'required|string|max:255',
            'isbn' => $isbnRule,
            'editora_id' => 'required|exists:editoras,id',
            'autores_selecionados' => 'required|array|min:1',
            'bibliografia' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'imagem_capa' => 'nullable|image|max:2048',
        ]);
        
        $caminhoImagem = $this->livroAEditar->imagem_capa ?? null;
        if ($this->imagem_capa) {
            if ($caminhoImagem) { Storage::disk('public')->delete($caminhoImagem); }
            $caminhoImagem = $this->imagem_capa->store('capas', 'public');
        } 
        elseif ($this->imagem_capa_url && !$this->livroAEditar) {
            try {
                $conteudoImagem = file_get_contents($this->imagem_capa_url);
                $nomeFicheiro = 'capas/' . Str::random(40) . '.jpg';
                Storage::disk('public')->put($nomeFicheiro, $conteudoImagem);
                $caminhoImagem = $nomeFicheiro;
            } catch (\Exception $e) { $caminhoImagem = null; }
        }

        $dadosParaSalvar = [
            'nome' => $validatedData['nome'], 'isbn' => $validatedData['isbn'], 'editora_id' => $validatedData['editora_id'],
            'bibliografia' => $validatedData['bibliografia'], 'preco' => $validatedData['preco'], 'imagem_capa' => $caminhoImagem,
        ];
        
        if ($this->livroAEditar) {
            $this->livroAEditar->update($dadosParaSalvar);
            $this->livroAEditar->autores()->sync($validatedData['autores_selecionados']);
            $mensagem = 'Livro atualizado com sucesso!';
        } else {
            $livro = Livro::create($dadosParaSalvar);
            $livro->autores()->attach($validatedData['autores_selecionados']);
            $mensagem = 'Livro criado com sucesso!';
        }
        
        $this->dispatch('livro-adicionado'); 
        $this->dispatch('livro-salvo-com-sucesso', mensagem: $mensagem);
        
        // Em vez de chamar reset() e mount() diretamente, chamamos a nossa nova função centralizada.
        $this->resetFormulario(); 
    }

    public function render()
    {
        return view('livewire.livro-form');
    }
}