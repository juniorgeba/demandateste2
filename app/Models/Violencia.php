<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violencia extends Model
{
    use HasFactory;

    protected $table = 'violencias';

    protected $fillable = [
        'nome',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
