<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Bulletin;
use App\Models\Indemnity;
use App\Models\Irsa;
use App\Models\Personnel;
use App\Models\Rubrique;
use App\Rules\BulletinRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redis;

class PaieController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index()
    {
        $bulletins = Bulletin::latest()->get();
        $bulletins->load('personnel');
        $bulletins->load('rubriques');
        $bulletins->load('indemnities');
        return inertia('Paie/Index', [
            "bulletins" => $bulletins
        ]);
    }

    public function show($id)
    {
        $bulletin = Bulletin::where('id', $id)->with([
            'personnel' => [
                'workplace' => [
                    'establishment' => [
                        'societe'
                    ]
                ],
                'absences', 'conges', 'statut'
            ], 'rubriques', 'indemnities'
        ])->first();
        return inertia('Paie/Show', [
            "bulletin" => $bulletin
        ]);
    }

    public function create()
    {
        if (!Gate::allows('admin')) {
            abort(403);
        }
        $rubriques = Rubrique::all();
        $personnels = Personnel::with(['absences', 'conges', 'workplace' => [
            'establishment' => [
                'societe'
            ]
        ], 'contrat', 'statut'])->get();
        $irsas = Irsa::all();
        return inertia('Paie/Create', [
            "personnels" => $personnels,
            "rubriques" => $rubriques,
            "irsas" => $irsas
        ]);
    }


    public function store(Request $request)
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('paie.index');
        }
        $data = $request->validate([
            "debut_periode" => ['required'],
            "fin_periode" => ['required'],
            "date_payement" => ['required'],
            "mois" => ['required'],
            "total_gain_brut" => ['required'],
            "retenue_irsa" => ['required'],
            "total_brut_salarial" => ['required'],
            "total_cotisations_salarial" => ['required'],
            "total_cotisations_patronal" => ['required'],
            "gain_enfant_charge" => ['required'],
            "valeur_irsa" => ['required'],
            "gain_total" => ['required'],
            "retenue_salarial_total" => ['required'],
            "retenue_patronal_total" => ['required'],
            "personnel_id" => ['required'],
            "id_payement" => ['required', new BulletinRule($request->mois, $request->personnel_id)],

        ]);
        $rubriques = Rubrique::all();

        $bulletin = Bulletin::create($data);

        foreach ($rubriques as $rubrique) {
            $rubrique->bulletins()->attach($bulletin->id);
        }

        if ($request->indemnityForm) {
            $indemnities = json_decode($request->indemnityForm);
            foreach ($indemnities as $indemnity) {
                if ($indemnity->designation != null || $indemnity->designation != null) {
                    Indemnity::create([
                        "designation" => $indemnity->designation,
                        "montant" => $indemnity->montant,
                        "isImposable" => $indemnity->isImposable,
                        "bulletin_id" => $bulletin->id
                    ]);
                }
            }
        }

        if ($request->formDataIndemnityNonImposabe) {
            $indemnities = json_decode($request->formDataIndemnityNonImposabe);
            foreach ($indemnities as $indemnity) {
                if ($indemnity->designation != null || $indemnity->designation != null) {
                    Indemnity::create([
                        "designation" => $indemnity->designation,
                        "montant" => $indemnity->montant,
                        "isImposable" => $indemnity->isImposable,
                        "bulletin_id" => $bulletin->id
                    ]);
                }
            }
        }


        return redirect()->route('paie.index');
    }

    public function edit($id)
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('paie.index');
        }
        $rubriques = Rubrique::all();
        $bulletin = Bulletin::where('id', $id)->with([
            'personnel' => ['absences', 'conges', 'workplace' => [
                'establishment' => [
                    'societe'
                ]
            ], 'contrat', 'statut'], 'indemnities'
        ])->first();
        $personnels = Personnel::with(['absences', 'conges', 'workplace' => [
            'establishment' => [
                'societe'
            ]
        ], 'contrat'])->get();
        $irsas = Irsa::all();
        return inertia('Paie/Edit', [
            "personnels" => $personnels,
            "rubriques" => $rubriques,
            "irsas" => $irsas,
            "bulletin" => $bulletin
        ]);
    }

    public function update(Request $request, $id)
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('paie.index');
        }
        $data = $request->validate([
            "debut_periode" => ['required'],
            "fin_periode" => ['required'],
            "date_payement" => ['required'],
            "mois" => ['required'],
            "total_gain_brut" => ['required'],
            "retenue_irsa" => ['required'],
            "total_brut_salarial" => ['required'],
            "total_cotisations_salarial" => ['required'],
            "total_cotisations_patronal" => ['required'],
            "gain_enfant_charge" => ['required'],
            "valeur_irsa" => ['required'],
            "gain_total" => ['required'],
            "retenue_salarial_total" => ['required'],
            "retenue_patronal_total" => ['required'],
            "personnel_id" => ['required'],
            "id_payement" => ['required', new BulletinRule($request->mois, $request->personnel_id)],

        ]);

        $bulletin =  Bulletin::findOrFail($id);
        $bulletin->update($data);
        // dd($request->indemnityForm, $request->formDataIndemnityNonImposabe);
        if ($request->indemnityForm) {
            $indemnities = json_decode($request->indemnityForm);
            foreach ($indemnities as $indemnity) {

                if ($indemnity->designation != null || $indemnity->designation != null) {
                    if (isset($indemnity->id)) {
                        Indemnity::findOrFail($indemnity->id)->update([
                            "designation" => $indemnity->designation,
                            "montant" => $indemnity->montant,
                            "isImposable" => $indemnity->isImposable,
                            "bulletin_id" => $bulletin->id
                        ]);
                    } else {
                        Indemnity::create([
                            "designation" => $indemnity->designation,
                            "montant" => $indemnity->montant,
                            "isImposable" => $indemnity->isImposable,
                            "bulletin_id" => $bulletin->id
                        ]);
                    }
                } else {
                    if (isset($indemnity->id)) {
                        Indemnity::findOrFail($indemnity->id)->delete();
                    }
                }
            }
        }

        if ($request->formDataIndemnityNonImposabe) {
            $indemnities = json_decode($request->formDataIndemnityNonImposabe);
            foreach ($indemnities as $indemnity) {
                if ($indemnity->designation != null || $indemnity->designation != null) {
                    if (isset($indemnity->id)) {
                        Indemnity::findOrFail($indemnity->id)->update([
                            "designation" => $indemnity->designation,
                            "montant" => $indemnity->montant,
                            "isImposable" => $indemnity->isImposable,
                            "bulletin_id" => $bulletin->id
                        ]);
                    } else {

                        Indemnity::create([
                            "designation" => $indemnity->designation,
                            "montant" => $indemnity->montant,
                            "isImposable" => $indemnity->isImposable,
                            "bulletin_id" => $bulletin->id
                        ]);
                    }
                } else {
                    if (isset($indemnity->id)) {
                        Indemnity::findOrFail($indemnity->id)->delete();
                    }
                }
            }
        }
        return redirect()->route('paie.index');
    }

    public function destroy($id)
    {
        Bulletin::findOrFail($id)->delete();

        return redirect()->route('paie.index');
    }

    public function generatePaie()
    {

        if (!Gate::allows('admin')) {
            abort(403);
        }

        $personnels = Personnel::all();
        $date = new \DateTime(date("Y-m"));
        $mois = $date->format("Y-m");
        $debut_periode = $date->format('Y-m-01');
        $fin_periode = $date->format('Y-m-01');
        $date_payment = $fin_periode;
        $irsas = Irsa::all();
        $rubriques = Rubrique::all();
        foreach ($personnels as $personnel) {
            $total_gain_brut = 0;
            $gain_total = 0;
            $total_cotisations_patronal = 0;
            $total_cotisations_salarial = 0;
            $total_brute_salarial = 0;
            $total_gain_imposable = 0;
            $base_absence = 0;
            $gain_non_imp = 0;
            $nbr_absence = 0;
            $absence = Absence::where('personnel_id', $personnel->id)
                ->where('mois', $debut_periode)->first();
            if ($absence !== null) {
                $nbr_absence = $absence->nbr_absence;
            }

            foreach ($rubriques as $rubrique) {
                if (strtolower($rubrique->type) === strtolower('cotisations')) {
                    $total_cotisations_salarial =  $total_cotisations_salarial + ($rubrique->taux_part_salarial * $personnel->base_salary) / 100;
                    $total_cotisations_patronal =  $total_cotisations_patronal + ($rubrique->taux_part_patronal * $personnel->base_salary) / 100;
                }
                if (strtolower($rubrique->type) === strtolower('brut')) {
                    $total_gain_brut = $total_gain_brut + calculGainBrute($rubrique);
                    if ($rubrique->nombre === null) {
                        $nombre = 1;
                    } else {
                        $nombre = $rubrique->nombre;
                    }
                    if (!$rubrique->isRetenue && !$rubrique->isImposable) {
                        if ($rubrique->taux_part_salarial === null) {
                            $gain_non_imp = $gain_non_imp + $nombre * $rubrique->base;
                        } else {
                            $gain_non_imp =  $gain_non_imp + ($nombre * $rubrique->base * $rubrique->taux_part_salarial) / 100;
                        }
                    }
                }
                if (strtolower($rubrique->type) === strtolower('charge familiale')) {
                    $gain_enfant_charge = $rubrique->base * $personnel->number_children;
                }
                if (strtolower($rubrique->designation) === strtolower('absence')) {
                    $base_absence = $rubrique->base;
                }
            }
            // dd($gain_non_imp);
            $total_gain_brut += $personnel->base_salary;
            $total_brute_salarial = $base_absence * $nbr_absence;
            $gain_total = $total_gain_brut * $personnel->nombre + $gain_enfant_charge;
            $total_gain_imposable = $total_gain_imposable + $total_gain_brut - $gain_non_imp;
            // dd($total_gain_imposable, $total_gain_brut);
            $valeur_irsa = calculIRSA($total_gain_imposable, $irsas);
            $retenu_salarial_total = $total_brute_salarial + $total_cotisations_salarial + $valeur_irsa;
            $retenu_patronal_total = $total_cotisations_patronal;
            $data = [
                "debut_periode" => $debut_periode,
                "fin_periode" => $fin_periode,
                "date_payement" => $date_payment,
                "mois" => $mois,
                "total_gain_brut" => $total_gain_brut,
                "retenue_irsa" => $valeur_irsa,
                "total_brut_salarial" => $total_brute_salarial,
                "total_cotisations_salarial" => $total_cotisations_salarial,
                "total_cotisations_patronal" => $total_cotisations_patronal,
                "gain_enfant_charge" => $gain_enfant_charge,
                "valeur_irsa" => $valeur_irsa,
                "gain_total" => $gain_total,
                "retenue_salarial_total" => $retenu_salarial_total,
                "retenue_patronal_total" => $retenu_patronal_total,
                "personnel_id" => $personnel->id,
                "id_payement" => 1,

            ];

            $bulletin = Bulletin::create($data);

            foreach ($rubriques as $rubrique) {
                $rubrique->bulletins()->attach($bulletin->id);
            }
        }
        return redirect()->back();
    }

    public function deletePaiesMonth()
    {
        $date = new \DateTime(date("Y-m"));
        $mois = $date->format("Y-m");

        $bulletins = Bulletin::where("mois", $mois)->get();

        foreach ($bulletins as $bulletin) {
            $bulletin->delete();
        }

        return redirect()->back();
    }
}
