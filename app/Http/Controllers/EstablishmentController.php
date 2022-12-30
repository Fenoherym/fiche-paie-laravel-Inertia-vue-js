<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use App\Models\Societe;
use App\Models\Workplace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EstablishmentController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function create()
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('paie.index');
        }
        $services = Establishment::all();
        return inertia('Societe/Service/Create', compact('services'));
    }

    public function store(Request $request)
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('paie.index');
        }
        $societe = Societe::all()->first();
        $request->validate([
            "name" => ['required', 'unique:establishments'],
        ]);

        Establishment::create([
            "name" => $request->name,
            "societe_id" => $societe->id
        ]);

        return redirect()->back();
    }

    public function edit($id)
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('paie.index');
        }
        $establihsment = Establishment::findOrFail($id);
        $establihsment->load('workplace');

        return inertia('Societe/Edit', compact('estalishment'));
    }

    public function update(Request $request, $id)
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('paie.index');
        }
        $data = $request->validate([
            "name" => ['required']
        ]);

        $establihsment = Establishment::findOrFail($id);
        $establihsment->update($data);
        $workplaces = json_decode($request->workplaceForm);
        foreach ($workplaces as $workplace) {
            Workplace::find($workplace->id)->update([
                "name" => $workplace->name,
                "establishment_id" => $establihsment->id
            ]);
        }

        return redirect()->route('societe.index');
    }

    public function destroy($id)
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('paie.index');
        }

        Establishment::findOrFail($id)->delete();

        return redirect()->route('societe.index');
    }
}
