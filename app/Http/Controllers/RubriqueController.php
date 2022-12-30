<?php

namespace App\Http\Controllers;

use App\Models\Irsa;
use App\Models\Role;
use App\Models\Rubrique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RubriqueController extends Controller
{
    public function index()
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('paie.index');
        }
        $rubriques = Rubrique::all();
        $irsas = Irsa::all();

        return inertia('Rubrique/Index', [
            "rubriques" => $rubriques,
            "irsas" => $irsas
        ]);
    }

    public function create()
    {
        return inertia('Rubrique/Create');
    }

    public function store(Request $request)
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('paie.index');
        }
        $data = $request->validate([
            'numero' => ['required', 'numeric'],
            "designation" => ['required', 'unique:rubriques'],
            "base" => ['numeric'],
            "taux_part_salarial" => ['nullable'],
            "taux_part_salarial" => ['nullable'],
            "taux_part_patronal" => ['nullable'],
            "type" => ['required'],
            "isRetenue" => ['required'],
            "isImposable" => ['required']
        ]);

        Rubrique::create($data);

        return redirect()->route('rubrique.index');
    }

    public function edit($id)
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('paie.index');
        }
        $rubrique = Rubrique::findOrFail($id);

        return inertia('Rubrique/Edit', compact('rubrique'));
    }

    public function update(Request $request, $id)
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('paie.index');
        }
        $data = $request->validate([
            'numero' => ['required', 'numeric'],
            "designation" => ['required'],
            "base" => ['nullable'],
            "taux_part_salarial" => ['nullable'],
            "taux_part_salarial" => ['nullable'],
            "taux_part_patronal" => ['nullable'],
            "type" => ['required'],
            "isRetenue" => ['required'],
            "isImposable" => ['required']
        ]);

        Rubrique::findOrFail($id)->update($data);

        return redirect()->route('rubrique.index');
    }

    public function destroy($id)
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('paie.index');
        }
        Rubrique::findOrFail($id)->delete();
        return redirect()->route('rubrique.index');
    }
}
