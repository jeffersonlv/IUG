@extends('admin_layout')

@section('title', 'Nova Empresa')

@section('content')
<div class="admin-page-header">
    <h1>Nova <span>Empresa</span></h1>
</div>

<div class="card p-4" style="max-width:600px;">
    <div class="accent-bar"></div>
    <form action="{{ route('admin.empresas.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                   value="{{ old('nome') }}" required>
            @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Telefone</label>
                <input type="text" name="telefone" class="form-control @error('telefone') is-invalid @enderror"
                       value="{{ old('telefone') }}">
                @error('telefone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">WhatsApp</label>
                <input type="text" name="whatsapp" class="form-control @error('whatsapp') is-invalid @enderror"
                       value="{{ old('whatsapp') }}">
                @error('whatsapp')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Endereço</label>
            <input type="text" name="endereco" class="form-control @error('endereco') is-invalid @enderror"
                   value="{{ old('endereco') }}">
            @error('endereco')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Público Alvo</label>
            <input type="text" name="publico_alvo" class="form-control @error('publico_alvo') is-invalid @enderror"
                   value="{{ old('publico_alvo') }}">
            @error('publico_alvo')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Sobre</label>
            <textarea name="sobre_texto" rows="4" class="form-control @error('sobre_texto') is-invalid @enderror">{{ old('sobre_texto') }}</textarea>
            @error('sobre_texto')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="ativo" value="1" class="form-check-input" id="ativo" checked>
            <label class="form-check-label fw-semibold" for="ativo">Ativo</label>
        </div>
        <div class="mb-4 form-check">
            <input type="checkbox" name="visivel" value="1" class="form-check-input" id="visivel" checked>
            <label class="form-check-label fw-semibold" for="visivel">Visível</label>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4">Criar Empresa</button>
            <a href="{{ route('admin.empresas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
