@extends('app')

@section('title', $curso->titulo . ' — IUG')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>{{ $curso->titulo }}</h1>
    </div>
</div>

<div class="container pb-5">
    <div class="card p-4">
        <div class="accent-bar"></div>
        <div class="d-flex flex-wrap gap-3 mb-3">
            <span class="text-muted small">📅 {{ $curso->data_inicio->format('d/m/Y') }} — {{ $curso->data_fim->format('d/m/Y') }}</span>
            <span class="text-muted small">📍 {{ $curso->local }}</span>
        </div>

        @if($curso->topicos)
        <div class="border-top pt-3">
            <p class="fw-semibold mb-1" style="color:#1A2B5F; font-size:0.875rem;">Tópicos abordados:</p>
            <p class="text-muted">{{ $curso->topicos }}</p>
        </div>
        @endif

        <a href="{{ route('cursos.index') }}" class="btn btn-outline-primary mt-2" style="width:fit-content;">← Voltar</a>
    </div>
</div>
@endsection
