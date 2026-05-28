@extends('admin_layout')

@section('title', 'Dashboard')

@section('content')
<div class="admin-page-header">
    <h1>Dashboard</h1>
</div>

<div class="row g-3">
    <div class="col-md-3 col-sm-6">
        <a href="{{ route('admin.cursos.index') }}" class="text-decoration-none">
            <div class="card p-3 text-center h-100">
                <div style="font-size:2rem; margin-bottom:0.5rem;">🎓</div>
                <h6 class="fw-bold mb-0" style="color:#1A2B5F;">Cursos</h6>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-6">
        <a href="{{ route('admin.documentos.index') }}" class="text-decoration-none">
            <div class="card p-3 text-center h-100">
                <div style="font-size:2rem; margin-bottom:0.5rem;">📄</div>
                <h6 class="fw-bold mb-0" style="color:#1A2B5F;">Documentos</h6>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-6">
        <a href="{{ route('admin.mensagens.index') }}" class="text-decoration-none">
            <div class="card p-3 text-center h-100">
                <div style="font-size:2rem; margin-bottom:0.5rem;">✉️</div>
                <h6 class="fw-bold mb-0" style="color:#1A2B5F;">Mensagens</h6>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-6">
        <a href="{{ route('admin.config.index') }}" class="text-decoration-none">
            <div class="card p-3 text-center h-100">
                <div style="font-size:2rem; margin-bottom:0.5rem;">⚙️</div>
                <h6 class="fw-bold mb-0" style="color:#1A2B5F;">Configurações</h6>
            </div>
        </a>
    </div>
</div>
@endsection
