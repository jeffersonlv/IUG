@extends('app')

@section('title', 'Contato — Instituto Ulysses Guimarães')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Entre em <span>Contato</span></h1>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            @if(session('success'))
                <div class="alert alert-success mb-4">{{ session('success') }}</div>
            @endif

            <div class="card p-4">
                <div class="accent-bar"></div>
                <h4 class="fw-bold mb-4" style="color:#1A2B5F;">Envie sua mensagem</h4>

                <form action="{{ route('contato.store') }}" method="POST">
                    @csrf
                    <input type="text" name="website" style="display:none;" tabindex="-1" autocomplete="off">

                    <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                               value="{{ old('nome') }}" placeholder="Seu nome completo" required>
                        @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">E-mail</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" placeholder="seu@email.com" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Mensagem</label>
                        <textarea name="mensagem" rows="5" class="form-control @error('mensagem') is-invalid @enderror"
                                  placeholder="Escreva sua mensagem..." required>{{ old('mensagem') }}</textarea>
                        @error('mensagem')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary px-4">Enviar Mensagem</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
