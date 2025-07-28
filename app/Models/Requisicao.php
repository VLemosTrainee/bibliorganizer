<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisicao extends Model
{
    use HasFactory;

    /**
     * O nome da tabela associada com o model.
     */
    protected $table = 'requisicoes';

    /**
     * Os atributos que são preenchíveis em massa.
     */
    protected $fillable = [
        'numero_requisicao',
        'user_id',
        'livro_id',
        'estado_no_emprestimo',
        'data_requisicao',
        'data_prevista_devolucao',
        'data_devolucao_efetiva',
        'estado_na_devolucao',
        'status',
        'notas_admin',
    ];
    
    /**
     * Os atributos que devem ser convertidos para tipos de data.
     */
    protected $casts = [
        'data_requisicao' => 'date',
        'data_prevista_devolucao' => 'date',
        'data_devolucao_efetiva' => 'date',
    ];

    /**
     * Obtém o utilizador que fez a requisição.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtém o livro que foi requisitado.
     */
    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }
}