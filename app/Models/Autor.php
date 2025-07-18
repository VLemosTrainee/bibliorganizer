<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Autor extends Model
{
    protected $table = 'autors';
    
    protected $fillable = [
        'nome',
        'foto',
    ];

    /**
     * Isto garante que o nome do autor será guardado de forma cifrada na base de dados.
     */
    protected $casts = [
        'nome' => 'encrypted',
    ];
    
    /**
     * Define a relação de que um Autor pode ter (pertencer a) muitos Livros.
     * A ligação é feita através da tabela pivot 'autor_livro'.
     */
    public function livros()
    {
        return $this->belongsToMany(Livro::class, 'autor_livro');
    }
}