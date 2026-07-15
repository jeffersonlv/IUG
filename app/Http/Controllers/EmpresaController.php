<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpresaController extends Controller
{
    public function adminIndex(Request $request)
    {
        $q = $request->input('q');
        $qs = $q ? '%' . str_replace(['%', '_', '\\'], ['\\%', '\\_', '\\\\'], $q) . '%' : null;
        $sortable = ['nome', 'data_criacao', 'ativo', 'visivel'];
        $sort = in_array($request->input('sort'), $sortable) ? $request->input('sort') : 'nome';
        $dir  = $request->input('dir') === 'desc' ? 'desc' : 'asc';

        $empresas = Empresa::when($qs, fn($query) => $query->where('nome', 'like', $qs))
            ->orderBy($sort, $dir)->paginate(15)->withQueryString();
        return view('admin.empresas.index', compact('empresas', 'q', 'sort', 'dir'));
    }

    public function adminCreate()
    {
        return view('admin.empresas.create');
    }

    public function adminStore(Request $request)
    {
        $validated = $request->validate([
            'nome'         => 'required|string|max:255',
            'ativo'        => 'boolean',
            'visivel'      => 'boolean',
            'telefone'     => 'nullable|string|max:30',
            'whatsapp'     => 'nullable|string|max:30',
            'email'        => 'nullable|email|max:255',
            'sobre_texto'  => 'nullable|string|max:2000',
            'endereco'     => 'nullable|string|max:255',
            'publico_alvo' => 'nullable|string|max:255',
            'icone'        => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:1024',
        ]);

        if ($request->hasFile('icone')) {
            $file = $request->file('icone');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('empresas', $filename, 'public');
            $validated['icone'] = $filename;
        }

        $validated['data_criacao'] = now();
        $validated['ativo'] = $request->boolean('ativo');
        $validated['visivel'] = $request->boolean('visivel');
        Empresa::create($validated);
        return redirect()->route('admin.empresas.index')->with('success', 'Empresa criada com sucesso.');
    }

    public function adminEdit($id)
    {
        $empresa = Empresa::findOrFail($id);
        return view('admin.empresas.edit', compact('empresa'));
    }

    public function adminUpdate(Request $request, $id)
    {
        $empresa = Empresa::findOrFail($id);
        $validated = $request->validate([
            'nome'         => 'required|string|max:255',
            'ativo'        => 'boolean',
            'visivel'      => 'boolean',
            'telefone'     => 'nullable|string|max:30',
            'whatsapp'     => 'nullable|string|max:30',
            'email'        => 'nullable|email|max:255',
            'sobre_texto'  => 'nullable|string|max:2000',
            'endereco'     => 'nullable|string|max:255',
            'publico_alvo' => 'nullable|string|max:255',
            'icone'        => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:1024',
        ]);

        if ($request->hasFile('icone')) {
            if ($empresa->icone) {
                Storage::disk('public')->delete('empresas/' . $empresa->icone);
            }
            $file = $request->file('icone');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('empresas', $filename, 'public');
            $validated['icone'] = $filename;
        }

        $validated['ativo'] = $request->boolean('ativo');
        $validated['visivel'] = $request->boolean('visivel');
        $empresa->update($validated);
        return redirect()->route('admin.empresas.index')->with('success', 'Empresa atualizada com sucesso.');
    }

    public function adminDestroy($id)
    {
        $empresa = Empresa::findOrFail($id);
        if ($empresa->icone) {
            Storage::disk('public')->delete('empresas/' . $empresa->icone);
        }
        $empresa->delete();
        return redirect()->route('admin.empresas.index')->with('success', 'Empresa deletada com sucesso.');
    }
}
