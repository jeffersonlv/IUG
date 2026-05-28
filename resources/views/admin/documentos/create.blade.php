@extends('app')

@section('content')
<div class="container">
    <h1>Novo Documento</h1>
    <form action="{{ route('admin.documentos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label>Nome:</label>
            <input type="text" name="nome" required>
            @error('nome') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div>
            <label>Arquivo PDF (máx 10MB):</label>
            <input type="file" name="arquivo_pdf" accept=".pdf" required>
            @error('arquivo_pdf') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div>
            <label>Ativo:</label>
            <input type="checkbox" name="ativo" value="1" checked>
        </div>
        <button type="submit">Criar</button>
    </form>
</div>
@endsection
