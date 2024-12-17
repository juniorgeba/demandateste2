<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Medida extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'unidade_id',
        'tecnico_user_id',
        'pessoa_id',
        'prazo_meses',
        'egresso',
        'data_entrada_no_creas',
        'motivo_infracao',
        'cod_motivo_infracao',
        'possui_irmao_em_atedimento',
        'local_armazenamento',
        'data_ativacao',
        'data_desligamento',
        'status'
    ];

    protected $dates = [
        'data_entrada_no_creas',
        'data_ativacao',
        'data_desligamento',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'egresso' => 'boolean',
        'possui_irmao_em_atedimento' => 'boolean',
    ];

    // Relacionamentos
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tecnico()
    {
        return $this->belongsTo(User::class, 'tecnico_user_id');
    }

    public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class);
    }

    public function observacoes()
    {
        return $this->hasMany(MedidaObservacao::class)->orderBy('created_at', 'desc');
    }

    public function documentos()
    {
        return $this->hasMany(MedidaDocumento::class)->orderBy('created_at', 'desc');
    }

    // Scopes
    public function scopeAtivas($query)
    {
        return $query->where('status', 'ativo');
    }

    public function scopeDesligadas($query)
    {
        return $query->where('status', 'desligado');
    }

    // Métodos
    public function getStatusFormatadoAttribute()
    {
        return [
            'ativo' => '<span class="badge bg-success">Ativo</span>',
            'adj' => '<span class="badge bg-warning">ADJ</span>',
            'desligado' => '<span class="badge bg-danger">Desligado</span>',
        ][$this->status] ?? $this->status;
    }

    /*public function getPrazoFormatadoAttribute()
    {
        return $this->prazo_meses . ' ' . str_plural('mês', $this->prazo_meses);
    }*/
}
