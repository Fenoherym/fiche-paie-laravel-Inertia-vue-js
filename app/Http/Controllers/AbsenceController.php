<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Personnel;
use App\Rules\AbsenceValidation;
use DateTime;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

class AbsenceController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth', ['except' => 'show']);
    }

    public function index()
    {
        $absences = Absence::all();
        $absences->load('personnel');
        $personnels = Personnel::all();
        return Inertia('Absence/Index.vue', [
            'absences' => $absences,
            'personnels' => $personnels
        ]);
    }

    public function show($id)
    {
        $absence = Absence::findOrFail($id);
        return response()->json([
            'absence' => $absence
        ]);
    }

    public function store(Request $request)
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('paie.index');
        }
        $date = new DateTime($request->mois);
        $date->format('Y-m-01');
        $request->validate([
            'nbr_absence' => ['required', 'numeric', 'max:30'],
            'mois' => ['required'],
            'personnel_id' => new AbsenceValidation($date->format('Y-m-d'), $request->personnel_id)
        ]);


        Absence::create([
            "nbr_absence" => $request->nbr_absence,
            "mois" => $date->format('Y-m-d'),
            "personnel_id" => $request->personnel_id,
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('paie.index');
        }
        $date = new DateTime($request->mois);
        $date->modify('+1 day');
        $request->validate([
            'nbr_absence' => ['required', 'numeric', 'max:30'],
            'mois' => ['required'],
            'personnel_id' => new AbsenceValidation($date->format('Y-m-d'), $request->personnel_id)
        ]);

        Absence::findOrFail($id)->update([
            "nbr_absence" => $request->nbr_absence,
            "mois" => $date->format('Y-m-d'),
            "personnel_id" => $request->personnel_id,
        ]);

        return Redirect::route('absence.index');
    }

    public function destroy($id)
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('paie.index');
        }

        Absence::findOrFail($id)->delete();

        return Redirect::route('absence.index');
    }
}
