<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 'data_criacao', 'ativo', 'visivel',
        'telefone', 'whatsapp', 'email', 'sobre_texto', 'endereco', 'publico_alvo',
    ];

    protected $casts = [
        'data_criacao' => 'date',
        'ativo'        => 'boolean',
        'visivel'      => 'boolean',
    ];
}
