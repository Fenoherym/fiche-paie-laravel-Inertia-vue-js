<?php

namespace App\Http\Controllers;

use App\Models\Contrat;
use App\Models\Establishment;
use App\Models\Personnel;
use App\Models\Role;
use App\Models\Statut;
use App\Models\User;
use App\Models\Workplace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class PersonnelController extends Controller
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
        $personnels = Personnel::all();
        $workplaces = Workplace::all();
        $personnels->load("workplace");
        $personnels->load("statut");
        $personnels->load("contrat");
        return inertia('Personnel/Index', [
            "personnels" => $personnels,
            "workplaces" => $workplaces
        ]);
    }

    public function create()
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('paie.index');
        }
        $contrats = Contrat::all();
        $status = Statut::all();
        $establishments = Establishment::all();
        $workplaces = Workplace::all();
        return inertia('Personnel/Create', [
            'contrats' => $contrats,
            'statuts' => $status,
            'establishments' => $establishments,
            'workplaces' => $workplaces
        ]);
    }

    public function store(Request $request)
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('paie.index');
        }
        if (isset($request->password)) {
            $request->validate([
                "email" => ['required', 'unique:users']
            ]);
            User::create([
                "name" => $request->name . ' ' . $request->first_name,
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "role_id" => Role::where('name', 'employee')->first()->id
            ]);
        }
        $request->validate([
            "name" => ['required', 'min:3'],
            "first_name" => ['required', 'min:3'],
            "num_matricule" => ['required', 'unique:personnels'],
            "sexe" => ['required'],
            "birthday" => ['required'],
            "address" => ['required'],
            "email" => ['unique:personnels'],
            "base_salary" => ['required', 'numeric'],
            "CIN" => ['required', 'unique:personnels'],
            "hiring_date" => ['required'],
            "contrat_id" => ['required'],
            "statut_id" => ['required'],
            "workplace_id" => ['required'],
            "num_cnaps" => ['required', 'unique:personnels'],
            "type_renumeration" => ['required', 'min:5'],
            "nombre" => ['numeric', 'required'],
            "nbr_conge" => ['numeric', 'required'],
        ]);
        if ($request->date_of_departure == "null") {
            Personnel::create([
                "name" => $request->name,
                "first_name" => $request->first_name,
                "num_matricule" => $request->num_matricule,
                "sexe" => $request->sexe,
                "birthday" => $request->birthday,
                "telephone" => $request->telephone,
                "email" => $request->email,
                "number_children" => $request->number_children,
                "address" => $request->address,
                "base_salary" => $request->base_salary,
                "CIN" => $request->CIN,
                "num_cnaps" => $request->num_cnaps,
                "hiring_date" => $request->hiring_date,
                "contrat_id" => $request->contrat_id,
                "statut_id" => $request->statut_id,
                "workplace_id" => $request->workplace_id,
                "type_renumeration" => $request->type_renumeration,
                "nombre" => $request->nombre,
                "nbr_conge" => $request->nbr_conge,
            ]);
        } else {
            Personnel::create([
                "name" => $request->name,
                "first_name" => $request->first_name,
                "num_matricule" => $request->num_matricule,
                "sexe" => $request->sexe,
                "birthday" => $request->birthday,
                "telephone" => $request->telephone,
                "email" => $request->email,
                "number_children" => $request->number_children,
                "address" => $request->address,
                "base_salary" => $request->base_salary,
                "CIN" => $request->CIN,
                "num_cnaps" => $request->num_cnaps,
                "hiring_date" => $request->hiring_date,
                "date_of_departure" => $request->date_of_departure,
                "contrat_id" => $request->contrat_id,
                "statut_id" => $request->statut_id,
                "workplace_id" => $request->workplace_id,
                "type_renumeration" => $request->type_renumeration,
                "nombre" => $request->nombre,
                "nbr_conge" => $request->nbr_conge,
            ]);
        }


        return redirect()->route('personnel.index');
    }

    public function edit($id)
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('paie.index');
        }
        $personnel = Personnel::findOrFail($id);
        $contrats = Contrat::all();
        $status = Statut::all();
        $personnel->load('workplace');
        $workplaces = Workplace::all();
        return inertia('Personnel/Edit', [
            'personnel' => $personnel,
            'contrats' => $contrats,
            'statuts' => $status,
            'workplaces' => $workplaces,
        ]);
    }

    public function destroy($id)
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('paie.index');
        }
        $personnel = Personnel::findOrFail($id);

        $personnel->delete();
        if ($personnel->email != null) {
            $user = User::where("email", $personnel->email)->first();
            if (isset($user->id)) {
                $user->delete();
            }
        }

        return Redirect::route('personnel.index');
    }

    public function update(Request $request, $id)
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('paie.index');
        }
        if ($request->date_of_departure == "null") {

            $data = $request->validate([
                "name" => ['required', 'min:3'],
                "first_name" => ['required', 'min:3'],
                "num_matricule" => ['required'],
                "sexe" => ['required'],
                "birthday" => ['required'],
                "telephone" => ['min:10'],
                "number_children" => ['min:0'],
                "address" => ['required'],
                "base_salary" => ['required', 'numeric'],
                "CIN" => ['required', 'min:12'],
                "num_cnaps" => ['numeric'],
                "hiring_date" => ['required', 'date'],
                "contrat_id" => ['required'],
                "statut_id" => ['required'],
                "workplace_id" => ['required'],
                "type_renumeration" => ['required'],
                "nombre" => ['required', 'numeric'],
                "nbr_conge" => ['required', 'numeric'],
            ]);
        } else {
            $data = $request->validate([
                "name" => ['required', 'min:3'],
                "first_name" => ['required', 'min:3'],
                "num_matricule" => ['required'],
                "sexe" => ['required'],
                "birthday" => ['required'],
                "telephone" => ['min:10'],
                "number_children" => ['min:0'],
                "address" => ['required'],
                "base_salary" => ['required', 'numeric'],
                "CIN" => ['required', 'min:12'],
                "num_cnaps" => ['numeric'],
                "hiring_date" => ['required', 'date'],
                "contrat_id" => ['required'],
                "statut_id" => ['required'],
                "workplace_id" => ['required'],
                "type_renumeration" => ['required'],
                "nombre" => ['required', 'numeric'],
                "nbr_conge" => ['required', 'numeric'],
                "date_of_departure" => ['date']
            ]);
        }


        Personnel::findOrFail($id)->update($data);

        return Redirect::route('personnel.index');
    }
}
