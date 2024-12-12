<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'sobrenome',
        'email',
        'cpf',
        'funcao',
        'status',
        'password',
        'user_id',
        'unidade_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relacionamento com a Unidade.
     */
    public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }

    /**
     * Relacionamento com o usuário que criou este usuário.
     */
    public function criadoPor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relacionamento com os usuários que este usuário criou.
     */
    public function createdUsers()
    {
        return $this->hasMany(User::class, 'user_id');
    }

    //retorna nome completo
    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->sobrenome;
    }

}
