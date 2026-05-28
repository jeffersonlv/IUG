@extends('admin_layout')

@section('title', 'Mensagem')

@section('content')
<div class="admin-page-header">
    <h1>Mensagem de <span>{{ $mensagem->nome }}</span></h1>
</div>

<div class="card p-4" style="max-width:680px;">
    <div class="accent-bar"></div>
    <p><strong class="form-label">Email:</strong> <a href="mailto:{{ $mensagem->email }}">{{ $mensagem->email }}</a></p>
    <div class="border-top pt-3 mt-2">
        <p class="form-label mb-1">Mensagem:</p>
        <p class="text-muted" style="white-space:pre-wrap;">{{ $mensagem->mensagem }}</p>
    </div>
    <div class="mt-3">
        <a href="{{ route('admin.mensagens.index') }}" class="btn btn-outline-secondary btn-sm">← Voltar</a>
    </div>
</div>
@endsection
