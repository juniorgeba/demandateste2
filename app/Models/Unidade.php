<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    use HasFactory;

    protected $table = 'unidades';

    protected $fillable = [
        'nome',
        'user_id',
        'numero_max_atribuicoes_por_tecnico'
    ];

    /**
     * Relacionamento com os usuários da unidade.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function criadoPor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}