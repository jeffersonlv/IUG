@extends('admin_layout')

@section('title', 'Novo Curso')

@section('content')
<div class="admin-page-header">
    <h1>Novo <span>Curso</span></h1>
</div>

<div class="card p-4" style="max-width:900px;">
    <div class="accent-bar"></div>
    <form action="{{ route('admin.cursos.store') }}" method="POST" enctype="multipart/form-data" id="curso-form">
        @csrf

        {{-- Título + Número do Seminário --}}
        <div class="row mb-3">
            <div class="col-md-8">
                <label class="form-label">Título</label>
                <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror"
                       value="{{ old('titulo') }}" required>
                @error('titulo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Número do Seminário</label>
                <input type="text" name="numero_seminario" class="form-control"
                       placeholder="Ex: 33º" value="{{ old('numero_seminario') }}">
            </div>
        </div>

        {{-- Datas --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Data Início</label>
                <input type="date" name="data_inicio" class="form-control @error('data_inicio') is-invalid @enderror"
                       value="{{ old('data_inicio') }}" required>
                @error('data_inicio')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Data Fim</label>
                <input type="date" name="data_fim" class="form-control @error('data_fim') is-invalid @enderror"
                       value="{{ old('data_fim') }}" required>
                @error('data_fim')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- Local, Investimento, Carga --}}
        <div class="row mb-3">
            <div class="col-md-5">
                <label class="form-label">Local / Cidade</label>
                <input type="text" name="local" class="form-control @error('local') is-invalid @enderror"
                       value="{{ old('local') }}" required>
                @error('local')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Investimento</label>
                <input type="text" name="investimento" class="form-control"
                       placeholder="Ex: R$1.490,00 por participante"
                       value="{{ old('investimento') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Carga Horária</label>
                <input type="text" name="carga_horaria" class="form-control"
                       placeholder="Ex: 10h/aulas"
                       value="{{ old('carga_horaria') }}">
            </div>
        </div>

        {{-- Público-alvo --}}
        <div class="mb-3">
            <label class="form-label">Público-Alvo</label>
            <input type="text" name="publico_alvo" class="form-control"
                   placeholder="Ex: Vereadores, Assessores, Prefeitos..."
                   value="{{ old('publico_alvo') }}">
        </div>

        {{-- Tópicos (legado) --}}
        <div class="mb-3">
            <label class="form-label">Tópicos <small class="text-muted">(texto livre, legado)</small></label>
            <textarea name="topicos" rows="3" class="form-control @error('topicos') is-invalid @enderror">{{ old('topicos') }}</textarea>
            @error('topicos')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <hr class="my-4">
        <h6 class="text-uppercase fw-bold mb-3" style="color:#1A2B5F; font-size:0.75rem; letter-spacing:1px;">Programação do Folder</h6>

        {{-- Programação por dia --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Programação por Dia</label>
            <div id="programacao-container"></div>
            <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="adicionarDia()">
                <i class="fas fa-plus me-1"></i>Adicionar Dia
            </button>
            <input type="hidden" name="programacao" id="programacao-json" value="[]">
        </div>

        {{-- Palestrantes do folder --}}
        <div class="mb-4">
            <label class="form-label fw-semibold">Palestrantes (Folder)</label>
            <div id="palestrantes-container"></div>
            <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="adicionarPalestrante()">
                <i class="fas fa-plus me-1"></i>Adicionar Palestrante
            </button>
            <input type="hidden" name="folder_palestrantes" id="palestrantes-json" value="[]">
        </div>

        <hr class="my-4">

        {{-- Upload PDF --}}
        <div class="mb-3">
            <label class="form-label">PDF do Curso <small class="text-muted">(máx 10MB — ou use o botão abaixo para gerar)</small></label>
            <input type="file" name="arquivo_pdf" class="form-control @error('arquivo_pdf') is-invalid @enderror" accept=".pdf">
            @error('arquivo_pdf')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- Palestrantes do sistema --}}
        @if($palestrantes->count())
        <div class="mb-3">
            <label class="form-label">Palestrantes (Sistema)</label>
            <input type="text" id="busca-palestrantes" class="form-control form-control-sm mb-2" placeholder="Buscar palestrante...">
            <div class="border rounded p-3" style="max-height:240px; overflow-y:auto;" id="lista-palestrantes">
                @foreach($palestrantes as $p)
                <div class="palestrante-item mb-2" data-nome="{{ strtolower($p->nome) }} {{ strtolower($p->descricao) }}">
                    <div class="d-flex align-items-start gap-2">
                        <input type="checkbox" name="palestrantes[]" value="{{ $p->id }}"
                               class="form-check-input mt-1" id="pc{{ $p->id }}"
                               {{ in_array($p->id, old('palestrantes', [])) ? 'checked' : '' }}>
                        <label for="pc{{ $p->id }}" style="cursor:pointer;">
                            <span class="fw-semibold d-block" style="font-size:0.875rem;">{{ $p->nome }}</span>
                            @if($p->descricao)<span class="text-muted" style="font-size:0.8rem;">{{ $p->descricao }}</span>@endif
                        </label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="mb-3">
            <label class="form-label">Ordem</label>
            <input type="number" name="ordem" class="form-control" value="{{ old('ordem', 0) }}" min="0" max="999" style="max-width:120px;">
        </div>
        <div class="mb-4 form-check">
            <input type="checkbox" name="ativo" value="1" class="form-check-input" id="ativo" checked>
            <label class="form-check-label fw-semibold" for="ativo">Ativo (visível no site)</label>
        </div>

        {{-- Botão Gerar PDF + campo oculto --}}
        <input type="hidden" name="folder_pdf_gerado" id="folder-pdf-gerado" value="">
        <div id="pdf-status" class="mb-3" style="display:none;">
            <span class="text-success fw-semibold"><i class="fas fa-check-circle me-1"></i>Folder PDF gerado — será salvo ao criar o curso.</span>
            <a id="pdf-preview-link" href="#" target="_blank" class="ms-2 small">Visualizar</a>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <button type="submit" class="btn btn-primary px-4">Criar Curso</button>
            <button type="button" class="btn btn-outline-danger px-4" id="btn-gerar-pdf" onclick="gerarFolderPDF()">
                <i class="fas fa-magic me-2"></i>Gerar Folder PDF
            </button>
            <a href="{{ route('admin.cursos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
const GERAR_PDF_URL = @json(route('admin.cursos.gerar-folder-pdf'));
const CSRF_TOKEN    = @json(csrf_token());

// Serializa antes do submit
document.getElementById('curso-form').addEventListener('submit', function() {
    serializarDados();
});

function serializarDados() {
    const dias = [];
    document.querySelectorAll('.dia-row').forEach(function(row) {
        dias.push({
            dia_semana: row.querySelector('.dia-semana').value,
            data:       row.querySelector('.dia-data').value,
            horario:    row.querySelector('.dia-horario').value,
            tipo:       row.querySelector('.dia-tipo').value,
            temas:      row.querySelector('.dia-temas').value.split('\n').map(t => t.trim()).filter(t => t),
        });
    });
    document.getElementById('programacao-json').value = JSON.stringify(dias);

    const pals = [];
    document.querySelectorAll('.palestrante-row').forEach(function(row) {
        const nome  = row.querySelector('.pal-nome').value.trim();
        const cargo = row.querySelector('.pal-cargo').value.trim();
        if (nome) pals.push({ nome, cargo });
    });
    document.getElementById('palestrantes-json').value = JSON.stringify(pals);
}

function adicionarDia(dados) {
    const container = document.getElementById('programacao-container');
    const div = document.createElement('div');
    div.className = 'dia-row border rounded p-3 mb-2 bg-light';
    div.innerHTML = `
        <div class="row g-2">
            <div class="col-md-3">
                <input class="form-control form-control-sm dia-semana" placeholder="Ex: Quarta-feira"
                       value="${esc(dados && dados.dia_semana ? dados.dia_semana : '')}">
            </div>
            <div class="col-md-2">
                <input class="form-control form-control-sm dia-data" placeholder="Ex: 15/07"
                       value="${esc(dados && dados.data ? dados.data : '')}">
            </div>
            <div class="col-md-3">
                <input class="form-control form-control-sm dia-horario" placeholder="Ex: 08:00 às 12:00"
                       value="${esc(dados && dados.horario ? dados.horario : '')}">
            </div>
            <div class="col-md-2">
                <select class="form-select form-select-sm dia-tipo">
                    <option value="palestra"${selecionado(dados,'palestra')}>Palestra</option>
                    <option value="credenciamento"${selecionado(dados,'credenciamento')}>Credenciamento</option>
                    <option value="encerramento"${selecionado(dados,'encerramento')}>Encerramento</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-sm btn-outline-danger w-100"
                        onclick="this.closest('.dia-row').remove()">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="col-12">
                <textarea class="form-control form-control-sm dia-temas" rows="3"
                          placeholder="Um tema por linha...">${esc(dados && dados.temas ? dados.temas.join('\n') : '')}</textarea>
            </div>
        </div>`;
    container.appendChild(div);
}

function adicionarPalestrante(dados) {
    const container = document.getElementById('palestrantes-container');
    const div = document.createElement('div');
    div.className = 'palestrante-row d-flex gap-2 mb-2';
    div.innerHTML = `
        <input class="form-control form-control-sm pal-nome" placeholder="Nome completo"
               value="${esc(dados && dados.nome ? dados.nome : '')}">
        <input class="form-control form-control-sm pal-cargo" placeholder="Cargo/Título"
               value="${esc(dados && dados.cargo ? dados.cargo : '')}">
        <button type="button" class="btn btn-sm btn-outline-danger"
                onclick="this.closest('.palestrante-row').remove()">
            <i class="fas fa-trash"></i>
        </button>`;
    container.appendChild(div);
}

async function gerarFolderPDF() {
    serializarDados();
    const btn = document.getElementById('btn-gerar-pdf');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Gerando...';

    const dados = {
        titulo:               document.querySelector('[name=titulo]').value,
        numero_seminario:     document.querySelector('[name=numero_seminario]').value,
        data_inicio:          document.querySelector('[name=data_inicio]').value,
        data_fim:             document.querySelector('[name=data_fim]').value,
        local:                document.querySelector('[name=local]').value,
        investimento:         document.querySelector('[name=investimento]').value,
        carga_horaria:        document.querySelector('[name=carga_horaria]').value,
        publico_alvo:         document.querySelector('[name=publico_alvo]').value,
        programacao:          JSON.parse(document.getElementById('programacao-json').value || '[]'),
        folder_palestrantes:  JSON.parse(document.getElementById('palestrantes-json').value || '[]'),
    };

    try {
        const resp = await fetch(GERAR_PDF_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
            },
            body: JSON.stringify(dados),
        });
        const result = await resp.json();

        if (result.success) {
            document.getElementById('folder-pdf-gerado').value = result.path;
            document.getElementById('pdf-status').style.display = '';
            document.getElementById('pdf-preview-link').href = result.url;
            btn.innerHTML = '<i class="fas fa-check me-2"></i>PDF Gerado!';
            btn.classList.replace('btn-outline-danger', 'btn-success');
        } else {
            alert('Erro ao gerar PDF: ' + (result.message || 'Erro desconhecido'));
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-magic me-2"></i>Gerar Folder PDF';
        }
    } catch (e) {
        alert('Erro de conexão: ' + e.message);
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-magic me-2"></i>Gerar Folder PDF';
    }
}

function esc(str) {
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
function selecionado(dados, tipo) {
    return (dados && dados.tipo === tipo) ? ' selected' : '';
}

// Busca palestrante
const buscaInput = document.getElementById('busca-palestrantes');
if (buscaInput) {
    buscaInput.addEventListener('input', function() {
        const val = this.value.toLowerCase();
        document.querySelectorAll('#lista-palestrantes .palestrante-item').forEach(function(el) {
            el.style.display = el.dataset.nome.includes(val) ? '' : 'none';
        });
    });
}
</script>
@endsection
