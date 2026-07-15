@extends('admin_layout')

@section('title', 'Cadastro em Lote — Alunos')

@section('content')
<div class="admin-page-header d-flex justify-content-between align-items-center">
    <h1>Cadastro em Lote</h1>
    <a href="{{ route('admin.alunos.index') }}" class="btn btn-sm btn-outline-secondary">← Voltar</a>
</div>

@if($errors->any())
    <div class="alert alert-danger mb-3">{{ $errors->first() }}</div>
@endif

<div class="card p-4" style="max-width:640px;">
    <p class="text-muted mb-4" style="font-size:0.875rem;">
        Cadastra vários alunos de uma vez — mesma cidade, estado e curso. Um nome por linha.
    </p>

    <form method="POST" action="{{ route('admin.alunos.lote.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold">Curso <span class="text-danger">*</span></label>
            <input type="text" id="curso-busca" class="form-control mb-1" placeholder="Buscar curso pelo título...">
            <select name="curso_id" id="curso-select" class="form-select" size="8" required style="height:auto;">
                @foreach($cursos as $curso)
                    <option value="{{ $curso->id }}" data-titulo="{{ mb_strtolower($curso->titulo) }}"
                            {{ old('curso_id') == $curso->id ? 'selected' : '' }}>
                        {{ $curso->titulo }} — {{ $curso->data_inicio->format('d/m/Y') }}
                    </option>
                @endforeach
            </select>
        </div>
        <script>
        (function () {
            var busca = document.getElementById('curso-busca');
            var select = document.getElementById('curso-select');
            if (!busca || !select) return;
            busca.addEventListener('input', function () {
                var termo = busca.value.trim().toLowerCase();
                Array.from(select.options).forEach(function (opt) {
                    opt.hidden = termo !== '' && opt.dataset.titulo.indexOf(termo) === -1;
                });
            });
        })();
        </script>

        <div class="row g-3 mb-3">
            <div class="col-8">
                <label class="form-label fw-semibold">Cidade <span class="text-danger">*</span></label>
                <input type="text" name="cidade" class="form-control" value="{{ old('cidade') }}" required>
            </div>
            <div class="col-4">
                <label class="form-label fw-semibold">Estado <span class="text-danger">*</span></label>
                <select name="estado" class="form-select" required>
                    <option value="">UF</option>
                    @foreach($estados as $uf)
                        <option value="{{ $uf }}" {{ old('estado') === $uf ? 'selected' : '' }}>{{ $uf }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Nomes dos Alunos <span class="text-danger">*</span></label>
            <textarea name="nomes" rows="10" class="form-control" required
                      placeholder="João da Silva&#10;Maria Oliveira&#10;Carlos Santos&#10;..."
                      style="font-family: monospace; font-size: 0.9rem;">{{ old('nomes') }}</textarea>
            <div class="form-text">Um nome por linha. Alunos já existentes (mesmo nome + cidade + estado) serão apenas vinculados ao curso.</div>
        </div>

        <button type="submit" class="btn btn-primary px-4">Cadastrar Alunos</button>
    </form>
</div>
@endsection
