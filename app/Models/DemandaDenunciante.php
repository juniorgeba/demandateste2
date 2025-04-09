<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemandaDenunciante extends Model
{
    protected $fillable = ['demanda_id', 'user_id', 'pessoa_id'];

    public function demanda()
    {
        return $this->belongsTo(Demanda::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class); // Supondo que você tenha um modelo Pessoa
    }
}
