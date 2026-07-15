<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $fillable = ['empresa_id', 'nome', 'arquivo_pdf', 'ativo', 'ordem', 'data_vencimento', 'downloads'];

    protected $casts = [
        'ativo'            => 'boolean',
        'data_vencimento'  => 'date',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function getVencidoAttribute(): bool
    {
        return $this->data_vencimento && $this->data_vencimento->isPast();
    }
}
