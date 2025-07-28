<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    use HasFactory;

    /**
     * Os atributos que são preenchíveis em massa.
     */
    protected $fillable = [
        'isbn',
        'nome',
        'editora_id',
        'bibliografia',
        'imagem_capa',
        'preco',
        'stock_total',         // Adicionado
        'stock_disponivel',    // Adicionado
        'estado_conservacao',  // Adicionado
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

    /**
     * Define a relação de que um Livro pode ter muitas Requisições.
     */
    public function requisicoes()
    {
        return $this->hasMany(Requisicao::class);
    }
}