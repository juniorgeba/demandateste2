<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Origem extends Model
{
    protected $table = 'origens';
    protected $fillable = ['nome', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
