<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    use HasFactory;

    /**
     * A "lista branca" de atributos que podem ser preenchidos em massa.
     * ESTA É A PROPRIEDADE QUE FALTA E QUE RESOLVE O ERRO FINAL.
     */
    protected $fillable = [
        'isbn',
        'nome',
        'editora_id',
        'bibliografia',
        'imagem_capa',
        'preco',
    ];

    /**
     * Os atributos que devem ser convertidos (ou encriptados).
     */
    protected $casts = [
        'nome' => 'encrypted',
        'bibliografia' => 'encrypted',
    ];

    /**
     * Define a relação de que um Livro pertence a uma Editora.
     */
    public function editora()
    {
        return $this->belongsTo(Editora::class);
    }

    /**
     * Define a relação de que um Livro pode ter muitos Autores.
     */
    public function autores()
    {
        return $this->belongsToMany(Autor::class, 'autor_livro');
    }
}