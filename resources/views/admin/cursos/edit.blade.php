@extends('admin_layout')

@section('title', 'Editar Curso')

@section('content')
<div class="admin-page-header">
    <h1>Editar <span>Curso</span></h1>
</div>

<div class="card p-4" style="max-width:760px;">
    <div class="accent-bar"></div>
    <form action="{{ route('admin.cursos.update', $curso->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror"
                   value="{{ old('titulo', $curso->titulo) }}" required>
            @error('titulo')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Data Início</label>
                <input type="datetime-local" name="data_inicio" class="form-control @error('data_inicio') is-invalid @enderror"
                       value="{{ old('data_inicio', $curso->data_inicio->format('Y-m-d\TH:i')) }}" required>
                @error('data_inicio')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Data Fim</label>
                <input type="datetime-local" name="data_fim" class="form-control @error('data_fim') is-invalid @enderror"
                       value="{{ old('data_fim', $curso->data_fim->format('Y-m-d\TH:i')) }}" required>
                @error('data_fim')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Local / Cidade</label>
            <input type="text" name="local" class="form-control @error('local') is-invalid @enderror"
                   value="{{ old('local', $curso->local) }}" required>
            @error('local')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Tópicos</label>
            <textarea name="topicos" rows="5" class="form-control @error('topicos') is-invalid @enderror">{{ old('topicos', $curso->topicos) }}</textarea>
            @error('topicos')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Ordem</label>
            <input type="number" name="ordem" class="form-control" value="{{ old('ordem', $curso->ordem) }}" min="0" max="999" style="max-width:120px;">
        </div>
        <div class="mb-4 form-check">
            <input type="checkbox" name="ativo" value="1" class="form-check-input" id="ativo" {{ $curso->ativo ? 'checked' : '' }}>
            <label class="form-check-label fw-semibold" for="ativo">Ativo (visível no site)</label>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4">Salvar Alterações</button>
            <a href="{{ route('admin.cursos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
