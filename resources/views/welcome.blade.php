@extends('app')

@section('title', 'Instituto Ulysses Guimarães — Gestão Pública')

@section('content')
{{-- Hero --}}
<div style="background: linear-gradient(135deg, #1A2B5F 0%, #243a7a 100%); padding: 5rem 0 4rem;">
    <div class="container text-center text-white">
        <div class="accent-bar mx-auto mb-3" style="background:#E8600A;"></div>
        <h1 style="font-size:2.2rem; font-weight:700; margin-bottom:1rem;">
            Instituto Ulysses Guimarães
        </h1>
        <p style="font-size:1.1rem; color:rgba(255,255,255,0.75); max-width:560px; margin:0 auto 2rem;">
            Formação e capacitação em Gestão Pública para servidores e gestores municipais.
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="/cursos" class="btn btn-primary px-4 py-2">Ver Cursos</a>
            <a href="/contato" class="btn btn-outline-light px-4 py-2">Entre em Contato</a>
        </div>
    </div>
</div>

{{-- Cards atalho --}}
<div class="container py-5">
    <div class="row g-4 justify-content-center">
        <div class="col-md-4">
            <a href="/cursos" class="text-decoration-none">
                <div class="card h-100 p-3 text-center">
                    <div class="card-body">
                        <div style="font-size:2rem; color:#E8600A; margin-bottom:0.75rem;">🎓</div>
                        <h5 class="card-title fw-bold">Cursos</h5>
                        <p class="text-muted small mb-0">Capacitações e formações para gestores e servidores públicos.</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="/documentos" class="text-decoration-none">
                <div class="card h-100 p-3 text-center">
                    <div class="card-body">
                        <div style="font-size:2rem; color:#E8600A; margin-bottom:0.75rem;">📄</div>
                        <h5 class="card-title fw-bold">Documentos</h5>
                        <p class="text-muted small mb-0">Materiais, manuais e publicações para download.</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="/contato" class="text-decoration-none">
                <div class="card h-100 p-3 text-center">
                    <div class="card-body">
                        <div style="font-size:2rem; color:#E8600A; margin-bottom:0.75rem;">✉️</div>
                        <h5 class="card-title fw-bold">Contato</h5>
                        <p class="text-muted small mb-0">Fale conosco para mais informações sobre cursos e projetos.</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
