@extends('admin_layout')

@section('title', 'Razão Social')

@section('content')
<div class="admin-page-header d-flex justify-content-between align-items-center">
    <h1>Razão Social</h1>
    <a href="{{ route('admin.empresas.create') }}" class="btn btn-primary btn-sm">+ Nova Empresa</a>
</div>

@if(session('success'))
    <div class="alert alert-success mb-3">{{ session('success') }}</div>
@endif

<form method="GET" class="mb-3 d-flex gap-2" style="max-width:400px;">
    <input type="text" name="q" value="{{ $q }}" class="form-control form-control-sm" placeholder="Buscar por nome...">
    <button class="btn btn-sm btn-outline-primary px-3">Buscar</button>
    @if($q)<a href="{{ route('admin.empresas.index') }}" class="btn btn-sm btn-outline-secondary">✕</a>@endif
</form>

<div class="card">
    <table class="table mb-0">
        @php
            function empSortUrl($col, $sort, $dir) {
                return request()->fullUrlWithQuery(['sort' => $col, 'dir' => ($sort === $col && $dir === 'asc') ? 'desc' : 'asc']);
            }
            function empSortIcon($col, $sort, $dir) {
                return $sort === $col ? ($dir === 'asc' ? ' ▲' : ' ▼') : ' ⇅';
            }
        @endphp
        <thead>
            <tr>
                <th><a href="{{ empSortUrl('nome', $sort, $dir) }}" style="color:inherit;text-decoration:none;">Nome{!! empSortIcon('nome', $sort, $dir) !!}</a></th>
                <th><a href="{{ empSortUrl('data_criacao', $sort, $dir) }}" style="color:inherit;text-decoration:none;">Data Criação{!! empSortIcon('data_criacao', $sort, $dir) !!}</a></th>
                <th><a href="{{ empSortUrl('ativo', $sort, $dir) }}" style="color:inherit;text-decoration:none;">Ativo{!! empSortIcon('ativo', $sort, $dir) !!}</a></th>
                <th><a href="{{ empSortUrl('visivel', $sort, $dir) }}" style="color:inherit;text-decoration:none;">Visível{!! empSortIcon('visivel', $sort, $dir) !!}</a></th>
                <th style="width:140px;">Ações</th>
            </tr>
        </thead>
        <tbody>
        @forelse($empresas as $e)
            <tr>
                <td class="fw-semibold align-middle">{{ $e->nome }}</td>
                <td class="align-middle">{{ $e->data_criacao ? $e->data_criacao->format('d/m/Y') : '-' }}</td>
                <td class="align-middle">
                    @if($e->ativo)
                        <span class="badge" style="background:#1A2B5F;">Sim</span>
                    @else
                        <span class="badge bg-secondary">Não</span>
                    @endif
                </td>
                <td class="align-middle">
                    @if($e->visivel)
                        <span class="badge" style="background:#1A2B5F;">Sim</span>
                    @else
                        <span class="badge bg-secondary">Não</span>
                    @endif
                </td>
                <td class="align-middle">
                    <a href="{{ route('admin.empresas.edit', $e->id) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                    <form action="{{ route('admin.empresas.destroy', $e->id) }}" method="POST" style="display:inline;"
                          onsubmit="return confirm('Deletar esta empresa?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Del</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center text-muted py-4">Nenhuma empresa encontrada.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

@if($empresas->hasPages())
<div class="mt-3">{{ $empresas->links() }}</div>
@endif
@endsection
