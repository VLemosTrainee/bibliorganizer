<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Editora extends Model
{
    use HasFactory;

    /**
     * A "lista branca" de atributos que podem ser preenchidos em massa.
     * ESTA É A PROPRIEDADE QUE FALTA E QUE RESOLVE O SEU ERRO.
     */
    protected $fillable = [
        'nome',
        'logotipo',
    ];

    /**
     * Os atributos que devem ser convertidos (ou encriptados).
     */
    protected $casts = [
        'nome' => 'encrypted',
    ];

    /**
     * Define a relação de que uma Editora pode ter muitos Livros.
     */
    public function livros()
    {
        return $this->hasMany(Livro::class);
    }
}