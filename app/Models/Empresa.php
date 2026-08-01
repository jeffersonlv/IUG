<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 'cnpj', 'data_criacao', 'ativo', 'visivel', 'icone', 'logo', 'fundo_certificado',
        'telefone', 'whatsapp', 'email', 'sobre_texto', 'endereco', 'publico_alvo', 'instagram',
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

    public function getLogoUrlAttribute(): ?string
    {
        if (!$this->logo) return null;
        if (strpos($this->logo, '/') === 0) return $this->logo;
        return \Illuminate\Support\Facades\Storage::url('empresas/' . $this->logo);
    }

    public function getFundoCertificadoUrlAttribute(): ?string
    {
        if (!$this->fundo_certificado) return null;
        if (strpos($this->fundo_certificado, '/') === 0) return $this->fundo_certificado;
        return \Illuminate\Support\Facades\Storage::url('empresas/' . $this->fundo_certificado);
    }
}
