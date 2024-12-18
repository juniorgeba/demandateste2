<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $table = 'tipos';
    protected $fillable = ['nome', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
