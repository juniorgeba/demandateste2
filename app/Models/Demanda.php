<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demanda extends Model
{
    protected $fillable = [
        'user_id',
        'unidade_id',
        'tipo_id',
        'violencia_id',
        'local_armazenamento',
        'classificacao',
        'data_triagem',
        'data_demanda_reprimida',
        'data_atribuicao',
        'status_administrativo'
    ];

    protected $dates = [
        'data_triagem',
        'data_demanda_reprimida',
        'data_atribuicao'
    ];

    // Relacionamentos
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }

    public function tipo()
    {
        return $this->belongsTo(Tipo::class);
    }

    public function violencia()
    {
        return $this->belongsTo(Violencia::class);
    }
}