<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedidaObservacao extends Model
{
    protected $table = 'medidas_observacoes';

    protected $fillable = ['user_id', 'medida_id', 'observacao'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function medida()
    {
        return $this->belongsTo(Medida::class);
    }
}