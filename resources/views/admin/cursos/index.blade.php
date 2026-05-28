@extends('app')

@section('title', 'Cursos — Admin IUG')

@section('content')
<div class="page-header">
    <div class="container d-flex justify-content-between align-items-center">
        <h1>Gerenciar <span>Cursos</span></h1>
        <a href="{{ route('admin.cursos.create') }}" class="btn btn-primary">+ Novo Curso</a>
    </div>
</div>

<div class="container pb-5">
    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <div class="card">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Data Início</th>
                    <th>Local</th>
                    <th>Ativo</th>
                    <th style="width:140px;">Ações</th>
                </tr>
            </thead>
            <tbody>
            @forelse($cursos as $curso)
                <tr>
                    <td class="fw-semibold">{{ $curso->titulo }}</td>
                    <td>{{ $curso->data_inicio->format('d/m/Y') }}</td>
                    <td>{{ $curso->local }}</td>
                    <td>
                        @if($curso->ativo)
                            <span class="badge" style="background:#1A2B5F;">Sim</span>
                        @else
                            <span class="badge bg-secondary">Não</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.cursos.edit', $curso->id) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                        <form action="{{ route('admin.cursos.destroy', $curso->id) }}" method="POST" style="display:inline;"
                              onsubmit="return confirm('Deletar este curso?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Nenhum curso cadastrado.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.dashboard') }}" class="text-muted small">← Dashboard</a>
    </div>
</div>
@endsection
