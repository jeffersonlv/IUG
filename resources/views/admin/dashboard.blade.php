@extends('admin_layout')

@section('title', 'Dashboard')

@section('content')
<div class="admin-page-header mb-4">
    <h1>Dashboard</h1>
</div>

<div class="row g-4">

    {{-- ── Timeline de Cursos ── --}}
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0" style="color:#1A2B5F;">📅 Agenda de Cursos</h6>
                <small class="text-muted">{{ now()->subMonth()->format('d/m/Y') }} — {{ now()->addMonth()->format('d/m/Y') }}</small>
            </div>
            <div class="p-3">
                @forelse($cursos as $curso)
                @php
                    $hoje   = now()->startOfDay();
                    $inicio = $curso->data_inicio->startOfDay();
                    $fim    = $curso->data_fim->startOfDay();
                    $status = $inicio > $hoje ? 'futuro' : ($fim < $hoje ? 'passado' : 'hoje');
                    $diasParaIniciar = $hoje->diffInDays($inicio, false);
                    $diasTerminou   = $fim->diffInDays($hoje, false);
                @endphp
                <div class="d-flex gap-3 mb-3">
                    {{-- Dot timeline --}}
                    <div class="d-flex flex-column align-items-center" style="min-width:16px;">
                        <div style="width:14px; height:14px; border-radius:50%; margin-top:3px; flex-shrink:0;
                            background:{{ $status === 'hoje' ? '#E8600A' : ($status === 'futuro' ? '#1A2B5F' : '#ccc') }};"></div>
                        @if(!$loop->last)
                        <div style="width:2px; flex:1; background:#e9ecef; margin:4px 0;"></div>
                        @endif
                    </div>
                    {{-- Conteúdo --}}
                    <div class="pb-1" style="flex:1;">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-1">
                            <span class="fw-semibold" style="font-size:0.875rem; color:#1A2B5F;">{{ $curso->titulo }}</span>
                            @if($status === 'hoje')
                                <span class="badge" style="background:#E8600A; font-size:0.65rem;">Em andamento</span>
                            @elseif($status === 'futuro')
                                <span class="badge bg-primary" style="font-size:0.65rem;">Começa em {{ $diasParaIniciar }} dia{{ $diasParaIniciar != 1 ? 's' : '' }}</span>
                            @elseif($status === 'passado')
                                <span class="badge bg-secondary" style="font-size:0.65rem;">Terminou há {{ $diasTerminou }} dia{{ $diasTerminou != 1 ? 's' : '' }}</span>
                            @endif
                        </div>
                        <small class="text-muted d-block">
                            📍 {{ $curso->local }} &nbsp;·&nbsp;
                            {{ $curso->data_inicio->format('d/m') }}
                            @if($curso->data_inicio->format('d/m/Y') !== $curso->data_fim->format('d/m/Y'))
                                — {{ $curso->data_fim->format('d/m/Y') }}
                            @else
                                /{{ $curso->data_inicio->format('Y') }}
                            @endif
                        </small>
                    </div>
                    <a href="{{ route('admin.cursos.edit', $curso->id) }}" class="btn btn-sm btn-outline-primary align-self-start" style="font-size:0.7rem; padding:2px 8px;">Editar</a>
                </div>
                @empty
                <p class="text-muted small py-2">Nenhum curso no período.</p>
                @endforelse
            </div>
            <div class="px-3 pb-3">
                <a href="{{ route('admin.cursos.index') }}" class="btn btn-sm btn-outline-primary">Ver todos os cursos</a>
            </div>
        </div>
    </div>

    {{-- ── Documentos + Atalhos ── --}}
    <div class="col-lg-5 d-flex flex-column gap-4">

        {{-- Documentos --}}
        <div class="card">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0" style="color:#1A2B5F;">📄 Documentos Ativos</h6>
                <a href="{{ route('admin.documentos.index') }}" style="font-size:0.75rem; color:#E8600A;">Ver todos</a>
            </div>
            <ul class="list-group list-group-flush">
                @forelse($documentos as $doc)
                <li class="list-group-item d-flex justify-content-between align-items-center px-3 py-2">
                    <span style="font-size:0.8rem; color:#333;">{{ Str::limit($doc->nome, 45) }}</span>
                    <a href="{{ route('admin.documentos.edit', $doc->id) }}" style="font-size:0.7rem; color:#E8600A; white-space:nowrap;">Editar</a>
                </li>
                @empty
                <li class="list-group-item text-muted small px-3 py-2">Nenhum documento.</li>
                @endforelse
            </ul>
        </div>

    </div>

</div>
@endsection
