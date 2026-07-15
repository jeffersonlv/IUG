@extends('admin_layout')

@section('title', 'Editar Empresa')

@section('content')
<div class="admin-page-header">
    <h1>Editar <span>Empresa</span></h1>
</div>

<div class="card p-4" style="max-width:600px;">
    <div class="accent-bar"></div>
    <form action="{{ route('admin.empresas.update', $empresa->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                   value="{{ old('nome', $empresa->nome) }}" required>
            @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Data de Criação</label>
            <input type="date" name="data_criacao" class="form-control @error('data_criacao') is-invalid @enderror"
                   value="{{ old('data_criacao', $empresa->data_criacao ? $empresa->data_criacao->format('Y-m-d') : '') }}">
            @error('data_criacao')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="ativo" value="1" class="form-check-input" id="ativo" {{ old('ativo', $empresa->ativo) ? 'checked' : '' }}>
            <label class="form-check-label fw-semibold" for="ativo">Ativo</label>
        </div>
        <div class="mb-4 form-check">
            <input type="checkbox" name="visivel" value="1" class="form-check-input" id="visivel" {{ old('visivel', $empresa->visivel) ? 'checked' : '' }}>
            <label class="form-check-label fw-semibold" for="visivel">Visível</label>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4">Salvar Alterações</button>
            <a href="{{ route('admin.empresas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
