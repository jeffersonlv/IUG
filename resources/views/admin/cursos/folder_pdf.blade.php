<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body {
    font-family: Arial, Helvetica, sans-serif;
    width: 210mm;
    min-height: 297mm;
}
.page {
    width: 210mm;
    min-height: 297mm;
    position: relative;
    background: #dbeafe;
}
.bg-img {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    object-fit: cover;
    z-index: 0;
}
.content-wrapper {
    position: relative;
    z-index: 1;
    padding: 10mm 10mm 8mm 10mm;
}
.header {
    background: rgba(30, 64, 175, 0.92);
    color: white;
    text-align: center;
    padding: 6mm 5mm;
    border-radius: 3mm;
    margin-bottom: 5mm;
}
.header-logo {
    height: 14mm;
    margin-bottom: 2mm;
}
.header h1 {
    font-size: 15pt;
    font-weight: bold;
    letter-spacing: 1px;
    margin-bottom: 1mm;
}
.header h2 {
    font-size: 11pt;
    font-weight: normal;
    margin-bottom: 2mm;
}
.header .divider {
    border: none;
    border-top: 1px solid rgba(255,255,255,0.4);
    margin: 2mm 0;
}
.header h3 {
    font-size: 13pt;
    font-weight: bold;
}
.header h4 {
    font-size: 10pt;
    font-weight: normal;
    margin-top: 1mm;
}
.badge-publico {
    background: #1e40af;
    color: white;
    padding: 1.5mm 4mm;
    font-size: 8.5pt;
    border-radius: 2mm;
    display: inline-block;
    margin-bottom: 4mm;
}
.cols {
    width: 100%;
    border-collapse: collapse;
}
.col-left {
    width: 62%;
    vertical-align: top;
    padding-right: 4mm;
}
.col-right {
    width: 38%;
    vertical-align: top;
    background: rgba(255,255,255,0.90);
    border-radius: 3mm;
    padding: 4mm;
}
.dia-bloco {
    margin-bottom: 4mm;
}
.dia-titulo {
    color: #1e3a8a;
    font-weight: bold;
    font-size: 9pt;
    border-left: 3px solid #1e40af;
    padding-left: 2mm;
    margin-bottom: 1.5mm;
    background: rgba(219,234,254,0.6);
    padding-top: 0.5mm;
    padding-bottom: 0.5mm;
}
.dia-tema {
    font-size: 8.5pt;
    padding-left: 5mm;
    line-height: 1.55;
    color: #1a1a1a;
}
.secao-titulo {
    color: #1e3a8a;
    font-weight: bold;
    font-size: 9.5pt;
    margin-bottom: 2mm;
    padding-bottom: 1mm;
    border-bottom: 1px solid #1e40af;
}
.palestrante-item {
    margin-bottom: 3mm;
    text-align: center;
}
.pal-nome {
    font-weight: bold;
    font-size: 8pt;
    color: #1a1a1a;
}
.pal-cargo {
    font-size: 7.5pt;
    color: #555;
    font-style: italic;
}
.info-bloco {
    margin-top: 3mm;
    font-size: 8pt;
    color: #222;
    line-height: 1.6;
}
.info-bloco strong {
    color: #1e3a8a;
}
.footer {
    margin-top: 5mm;
    background: rgba(30, 64, 175, 0.88);
    color: white;
    padding: 3mm 5mm;
    border-radius: 2mm;
    font-size: 7.5pt;
    text-align: center;
}
.footer a { color: #bfdbfe; }
</style>
</head>
<body>
@php
    $d = $dados;
    $whatsapp = $configs['whatsapp'] ?? $configs['telefone'] ?? '';
    $email    = $configs['email']    ?? '';
@endphp
<div class="page">
    @if($bgBase64)
    <img class="bg-img" src="{{ $bgBase64 }}" alt="">
    @endif

    <div class="content-wrapper">

        {{-- Cabeçalho --}}
        <div class="header">
            @if($logoBase64)
            <img class="header-logo" src="{{ $logoBase64 }}" alt="Logo IUG">
            @endif
            <h1>INSTITUTO ULYSSES GUIMARÃES</h1>
            <h2>Gestão Pública</h2>
            <hr class="divider">
            @if(!empty($d['numero_seminario']))
            <h3>{{ strtoupper($d['numero_seminario']) }} SEMINÁRIO DE GESTÃO PÚBLICA</h3>
            @else
            <h3>{{ strtoupper($d['titulo']) }}</h3>
            @endif
            @if(!empty($d['data_inicio']) && !empty($d['data_fim']))
            <h4>
                de {{ \Carbon\Carbon::parse($d['data_inicio'])->format('d/m/Y') }}
                a {{ \Carbon\Carbon::parse($d['data_fim'])->format('d/m/Y') }}
                @if(!empty($d['local'])) — {{ $d['local'] }} @endif
            </h4>
            @endif
        </div>

        @if(!empty($d['publico_alvo']))
        <div>
            <span class="badge-publico">Público-Alvo: {{ $d['publico_alvo'] }}</span>
        </div>
        @endif

        {{-- Colunas --}}
        <table class="cols">
            <tr>
                <td class="col-left">
                    {{-- Programação --}}
                    @if(!empty($d['programacao']))
                    <div class="secao-titulo">Programação</div>
                    @foreach($d['programacao'] as $dia)
                    <div class="dia-bloco">
                        <div class="dia-titulo">
                            {{ $dia['dia_semana'] ?? '' }}
                            @if(!empty($dia['data'])) {{ $dia['data'] }} @endif
                            @if(!empty($dia['horario'])) — {{ $dia['horario'] }} @endif
                            @if(($dia['tipo'] ?? '') === 'credenciamento') — Credenciamento
                            @elseif(($dia['tipo'] ?? '') === 'encerramento') — Encerramento
                            @elseif(($dia['tipo'] ?? '') === 'palestra') — Palestra
                            @endif
                        </div>
                        @foreach($dia['temas'] ?? [] as $tema)
                        <div class="dia-tema">• {{ $tema }}</div>
                        @endforeach
                    </div>
                    @endforeach
                    @endif

                    {{-- Info de contato/investimento --}}
                    <div class="info-bloco">
                        @if(!empty($d['investimento']))
                        <strong>Investimento:</strong> {{ $d['investimento'] }}<br>
                        @endif
                        @if(!empty($d['carga_horaria']))
                        <strong>Carga Horária:</strong> {{ $d['carga_horaria'] }}<br>
                        @endif
                        @if($whatsapp)
                        <strong>Telefone/WhatsApp:</strong> {{ $whatsapp }}<br>
                        @endif
                        @if($email)
                        <strong>E-mail:</strong> {{ $email }}<br>
                        @endif
                        <strong>Site:</strong> institutoulyssesguimaraes.com.br<br><br>
                        <strong>Dados Bancários:</strong><br>
                        Banco do Brasil / Ag. 2901-7 / CC 51010-6<br>
                        Instituto Ulysses Guimarães Ltda.<br>
                        CNPJ: 40.033.708/0001-63
                    </div>
                </td>

                <td class="col-right">
                    @if(!empty($d['folder_palestrantes']))
                    <div class="secao-titulo">Palestrantes</div>
                    @foreach($d['folder_palestrantes'] as $p)
                    <div class="palestrante-item">
                        <div class="pal-nome">{{ $p['nome'] ?? '' }}</div>
                        @if(!empty($p['cargo']))
                        <div class="pal-cargo">{{ $p['cargo'] }}</div>
                        @endif
                    </div>
                    @endforeach
                    @endif

                    <div class="info-bloco" style="margin-top:4mm; border-top:1px solid #ddd; padding-top:3mm;">
                        <strong>Instagram:</strong><br>
                        @institutoulyssesguimaraes<br><br>
                        @if(!empty($d['local']))
                        <strong>Local:</strong><br>
                        {{ $d['local'] }}
                        @endif
                    </div>
                </td>
            </tr>
        </table>

        {{-- Rodapé --}}
        <div class="footer">
            institutoulyssesguimaraes.com.br/cursos &nbsp;|&nbsp;
            {{ $whatsapp }} &nbsp;|&nbsp;
            {{ $email }}
        </div>

    </div>
</div>
</body>
</html>
