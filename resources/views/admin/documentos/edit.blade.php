@extends('app')

@section('content')
<div class="container">
    <h1>Editar Documento</h1>
    <form action="{{ route('admin.documentos.update', $documento->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <label>Nome:</label>
            <input type="text" name="nome" value="{{ $documento->nome }}" required>
            @error('nome') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div>
            <label>Arquivo PDF (máx 10MB, deixe em branco para manter atual):</label>
            <input type="file" name="arquivo_pdf" accept=".pdf">
            <small>Atual: {{ $documento->arquivo_pdf }}</small>
            @error('arquivo_pdf') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div>
            <label>Ativo:</label>
            <input type="checkbox" name="ativo" value="1" {{ $documento->ativo ? 'checked' : '' }}>
        </div>
        <button type="submit">Atualizar</button>
    </form>
</div>
@endsection
