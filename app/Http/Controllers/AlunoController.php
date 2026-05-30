<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Curso;
use Illuminate\Http\Request;

class AlunoController extends Controller
{
    private static $estados = [
        'AC','AL','AM','AP','BA','CE','DF','ES','GO','MA','MG','MS','MT',
        'PA','PB','PE','PI','PR','RJ','RN','RO','RR','RS','SC','SE','SP','TO',
    ];

    public function adminIndex(Request $request)
    {
        $q = $request->input('q');
        $qs = $q ? '%' . str_replace(['%', '_', '\\'], ['\\%', '\\_', '\\\\'], $q) . '%' : null;
        $sortable = ['nome_completo', 'cidade', 'estado'];
        $sort = in_array($request->input('sort'), $sortable) ? $request->input('sort') : 'nome_completo';
        $dir  = $request->input('dir') === 'desc' ? 'desc' : 'asc';

        $alunos = Aluno::when($qs, fn($query) => $query->where('nome_completo', 'like', $qs)
                ->orWhere('cidade', 'like', $qs)
                ->orWhere('estado', 'like', $qs))
            ->orderBy($sort, $dir)
            ->paginate(20)
            ->withQueryString();
        return view('admin.alunos.index', compact('alunos', 'q', 'sort', 'dir'));
    }

    public function adminCreate()
    {
        $cursos = Curso::whereDate('data_fim', '>=', now()->toDateString())
            ->orderBy('data_inicio')->get();
        return view('admin.alunos.create', ['cursos' => $cursos, 'estados' => self::$estados]);
    }

    public function adminStore(Request $request)
    {
        $validated = $request->validate([
            'nome_completo' => 'required|string|max:255',
            'cidade'        => 'required|string|max:100',
            'estado'        => 'required|string|size:2',
            'cursos'        => 'nullable|array',
            'cursos.*'      => 'exists:cursos,id',
        ]);

        $aluno = Aluno::create([
            'nome_completo' => $validated['nome_completo'],
            'cidade'        => $validated['cidade'],
            'estado'        => strtoupper($validated['estado']),
        ]);

        if (!empty($validated['cursos'])) {
            $aluno->cursos()->sync($validated['cursos']);
        }

        return redirect()->route('admin.alunos.index')->with('success', 'Aluno cadastrado com sucesso.');
    }

    public function adminEdit($id)
    {
        $aluno = Aluno::with('cursos')->findOrFail($id);
        $cursos = Curso::whereDate('data_fim', '>=', now()->toDateString())
            ->orderBy('data_inicio')->get();
        $cursosSelecionados = $aluno->cursos->pluck('id')->toArray();
        return view('admin.alunos.edit', compact('aluno', 'cursos', 'cursosSelecionados') + ['estados' => self::$estados]);
    }

    public function adminUpdate(Request $request, $id)
    {
        $aluno = Aluno::findOrFail($id);
        $validated = $request->validate([
            'nome_completo' => 'required|string|max:255',
            'cidade'        => 'required|string|max:100',
            'estado'        => 'required|string|size:2',
            'cursos'        => 'nullable|array',
            'cursos.*'      => 'exists:cursos,id',
        ]);

        $aluno->update([
            'nome_completo' => $validated['nome_completo'],
            'cidade'        => $validated['cidade'],
            'estado'        => strtoupper($validated['estado']),
        ]);

        $aluno->cursos()->sync($validated['cursos'] ?? []);

        return redirect()->route('admin.alunos.index')->with('success', 'Aluno atualizado com sucesso.');
    }

    public function adminLote()
    {
        $cursos = Curso::whereDate('data_fim', '>=', now()->toDateString())
            ->orderBy('data_inicio')->get();
        return view('admin.alunos.lote', ['cursos' => $cursos, 'estados' => self::$estados]);
    }

    public function adminLoteStore(Request $request)
    {
        $request->validate([
            'cidade'   => 'required|string|max:100',
            'estado'   => 'required|string|size:2',
            'curso_id' => 'required|exists:cursos,id',
            'nomes'    => 'required|string',
        ]);

        $nomes = array_filter(array_map('trim', explode("\n", $request->nomes)));

        if (empty($nomes)) {
            return back()->withErrors(['nomes' => 'Informe ao menos um nome.'])->withInput();
        }

        $cidade = $request->cidade;
        $estado = strtoupper($request->estado);
        $cursoId = $request->curso_id;
        $count = 0;

        foreach ($nomes as $nome) {
            if ($nome === '') continue;
            $aluno = Aluno::firstOrCreate(
                ['nome_completo' => $nome, 'cidade' => $cidade, 'estado' => $estado],
            );
            $aluno->cursos()->syncWithoutDetaching([$cursoId]);
            $count++;
        }

        return redirect()->route('admin.alunos.index')
            ->with('success', "$count aluno(s) cadastrado(s) com sucesso.");
    }

    public function adminDestroy($id)
    {
        $aluno = Aluno::findOrFail($id);
        $aluno->cursos()->detach();
        $aluno->delete();
        return redirect()->route('admin.alunos.index')->with('success', 'Aluno removido.');
    }
}
