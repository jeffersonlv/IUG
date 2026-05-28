@extends('admin_layout')

@section('title', 'Documentos')

@section('content')
<div class="admin-page-header d-flex justify-content-between align-items-center">
    <h1>Documentos</h1>
    <a href="{{ route('admin.documentos.create') }}" class="btn btn-primary btn-sm">+ Novo Documento</a>
</div>

@if(session('success'))
    <div class="alert alert-success mb-3">{{ session('success') }}</div>
@endif

<div class="card">
    <table class="table mb-0">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Ativo</th>
                <th style="width:140px;">Ações</th>
            </tr>
        </thead>
        <tbody>
        @forelse($documentos as $doc)
            <tr>
                <td class="fw-semibold">{{ $doc->nome }}</td>
                <td>
                    @if($doc->ativo)
                        <span class="badge" style="background:#1A2B5F;">Sim</span>
                    @else
                        <span class="badge bg-secondary">Não</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.documentos.edit', $doc->id) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                    <form action="{{ route('admin.documentos.destroy', $doc->id) }}" method="POST" style="display:inline;"
                          onsubmit="return confirm('Deletar este documento?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Del</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="3" class="text-center text-muted py-4">Nenhum documento cadastrado.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
