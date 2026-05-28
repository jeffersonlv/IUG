@extends('app')

@section('title', 'Documentos — Instituto Ulysses Guimarães')

@section('content')
<div class="page-header">
    <div class="container">
        <h1><span>Documentos</span> e Materiais</h1>
    </div>
</div>

<div class="container pb-5">
    @forelse($documentos as $doc)
    <div class="card mb-3">
        <div class="card-body d-flex align-items-center justify-content-between p-3">
            <div class="d-flex align-items-center gap-3">
                <span style="font-size:1.5rem; color:#E8600A;">📄</span>
                <div>
                    <p class="fw-semibold mb-0" style="color:#1A2B5F;">{{ $doc->nome }}</p>
                    @if($doc->descricao)
                        <p class="text-muted small mb-0">{{ $doc->descricao }}</p>
                    @endif
                </div>
            </div>
            @if($doc->arquivo)
            <a href="{{ route('download.documento', $doc->id) }}" class="btn btn-primary btn-sm">Download</a>
            @endif
        </div>
    </div>
    @empty
    <div class="text-center py-5 text-muted">
        <p>Nenhum documento disponível no momento.</p>
    </div>
    @endforelse
</div>
@endsection
