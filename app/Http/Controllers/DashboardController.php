<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Bulletin;
use App\Models\Conge;
use App\Models\Establishment;
use App\Models\Personnel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index()
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('paie.index');
        }
        $bulletins = Bulletin::all();
        $absences = Absence::all();
        $services = Establishment::all();
        $conges = Conge::all();
        $personnels = Personnel::with(['workplace' => [
            'establishment'
        ]])->get();


        return inertia('Dashboard', [
            "bulletins" => $bulletins,
            "absences" => $absences,
            "personnels" => $personnels,
            "services" => $services,
            "conges" => $conges
        ]);
    }
}
