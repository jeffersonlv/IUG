<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 'data_criacao', 'ativo', 'visivel', 'icone',
        'telefone', 'whatsapp', 'email', 'sobre_texto', 'endereco', 'publico_alvo',
    ];

    protected $casts = [
        'data_criacao' => 'date',
        'ativo'        => 'boolean',
        'visivel'      => 'boolean',
    ];

    public function getIconeUrlAttribute(): ?string
    {
        if (!$this->icone) return null;
        if (strpos($this->icone, '/') === 0) return $this->icone;
        return \Illuminate\Support\Facades\Storage::url('empresas/' . $this->icone);
    }
}
