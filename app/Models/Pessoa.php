<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    use hasFactory;

    protected $fillable = [
        'user_id',
        'nome',
        'genero',
        'deficiencia',
        'data_nascimento',
        'rg',
        'cpf',
        'nome_mae',
        'nome_pai',
        'nome_responsavel',
        'grau_parentesco_responsavel',
        'rg_responsavel',
        'cpf_responsavel',
        'telefone_responsavel',
        'cep',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'email',
        'telefone'
    ];

    protected $dates = [
        'data_nascimento'
    ];

    // Relacionamento com User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mutator para o campo nome
     */
    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = mb_strtoupper($value, 'UTF-8');
    }

    /**
     * Mutator para o campo nome_mae
     */
    public function setNomeMaeAttribute($value)
    {
        $this->attributes['nome_mae'] = $value ? mb_strtoupper($value, 'UTF-8') : null;
    }

    /**
     * Mutator para o campo nome_pai
     */
    public function setNomePaiAttribute($value)
    {
        $this->attributes['nome_pai'] = $value ? mb_strtoupper($value, 'UTF-8') : null;
    }

    /**
     * Mutator para o campo nome_responsavel
     */
    public function setNomeResponsavelAttribute($value)
    {
        $this->attributes['nome_responsavel'] = $value ? mb_strtoupper($value, 'UTF-8') : null;
    }
}
