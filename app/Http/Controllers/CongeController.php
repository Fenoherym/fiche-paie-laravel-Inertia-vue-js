<?php

namespace App\Http\Controllers;

use App\Models\Conge;
use App\Models\Message;
use App\Models\Personnel;
use App\Models\User;
use App\Rules\CongeRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CongeController extends Controller
{
    public function index()
    {
        $conges = Conge::latest()->get();
        $conges->load('personnel');
        $conges->load('congestatut');
        $personnels = Personnel::all();
        $personnels->load('conges');
        return inertia('Conge/Index', [
            'conges' => $conges,
            'personnels' => $personnels
        ]);
    }

    public function edit(Request $request, $id)
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('paie.index');
        }
        $conge = Conge::findOrFail($id);
        $conge->load('personnel');
        return inertia('Conge/Edit', compact('conge'));
    }

    function update(Request $request, $id)
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('paie.index');
        }
        $data = $request->validate([
            'date_depart' => ['date', 'required'],
            'date_arrive' => ['date', 'required'],
            'year' => ['required'],
            'personnel_id' => ['required']
        ]);

        $date_depart = new \DateTime($request->date_depart);
        $date_arrive = new \DateTime($request->date_arrive);

        $date1 = $request->date_depart;
        $date2 = $request->date_arrive;

        $timestamp1    = strtotime($date1);
        $timestamp2    = strtotime($date2);

        $tot = 0; // total de jours entre les 2 dates

        // dates en jours de l'année ( depuis le 1er jan )
        $date1 = date("z", $timestamp1); // date de depart
        $date2 = date("z", $timestamp2); //date d'arrivée

        $day_stamp = 86400; //(3600 * 24 ); // un journée en timestamp

        // années des deux dates
        $year1 = date("Y", $timestamp1);
        $year2 = date("Y", $timestamp2);

        $num = 0; // nombre de jours feries a compter sur la duree totale
        $counter = 0; // la durée entre deux date par année

        $year = $year1; // l'année en cours ( defaut : $year1 )


        // on calcule le nombre de jours de différence entre les deux dates, en tenant
        // compte des années
        while ($year <= $year2) {
            $date3         = date("d-n-Y", mktime(0, 0, 0, 1,  1,  $year));
            $timestamp3 = strtotime($date3);
            // date de référence pour l'année en cours
            $counter = 0; // compteur de jours pour chaque année

            //on récupère la date de pâques
            $easterDate   = easter_date($year);
            $easterDay    = date('j', $easterDate);
            $easterMonth  = date('n', $easterDate);
            $easterYear   = date('Y', $easterDate);



            // le tableau sort les jours fériés de l'année depuis le premier janvier
            $closed = array(
                // dates fixes
                date("z", mktime(0, 0, 0, 1,  1,  $year)),  // 1er janvier
                date("z", mktime(0, 0, 0, 5,  1,  $year)),  // Fête du travail
                date("z", mktime(0, 0, 0, 5,  8,  $year)),  // Victoire des alliés
                date("z", mktime(0, 0, 0, 6,  26, $year)),  // Fête nationale
                date("z", mktime(0, 0, 0, 8,  15, $year)),  // Assomption
                date("z", mktime(0, 0, 0, 11, 1,  $year)),  // Toussaint
                date("z", mktime(0, 0, 0, 11, 11, $year)),  // Armistice
                date("z", mktime(0, 0, 0, 12, 25, $year)),  // Noel

                // Dates basées sur Paques
                date(
                    "z",
                    mktime(0, 0, 0, $easterMonth, $easterDay + 1, $easterYear)

                ),  // Lundi de Paques
                date("z", mktime(
                    0,
                    0,
                    0,
                    $easterMonth,
                    $easterDay + 39,
                    $easterYear

                )), // Ascension
                date("z", mktime(
                    0,
                    0,
                    0,
                    $easterMonth,
                    $easterDay + 50,
                    $easterYear

                ))  // Lundi de Pentecote

            );

            // si c'est la première année -> on commence par la date de depart;
            // le compteur compte les jours jusqu'au 31dec
            if ($year == $year1 && $year < $year2) {
                $i = $date1;
                $counter +=  (364 + date("L", mktime(0, 0, 0, 1, 1, $year)));
            }


            // si c'est ni la première ni la dernière année -> on commence au premier
            // janvier;
            //le compteur compte tous les jours de l'année
            if ($year > $year1 && $year < $year2) {
                $i = date("z", mktime(0, 0, 0, 1,  1,  $year));
                $counter += 364 + date("L", mktime(0, 0, 0, 1, 1, $year));
            }

            // si c'est la dernière année -> on commence au premier janvier;
            // le compteur va jusqu'a la date d'arrivée
            if ($year == $year2 && $year > $year1) {
                $i = date("z", mktime(0, 0, 0, 1,  1,  $year));
                $counter += $date2;
            }

            // si les deux dates sont dans la même année
            if ($year == $year1 && $year == $year2) {
                $i = $date1;
                $counter += $date2;
            }

            // on boucle les jours sur la période donnée
            while ($i <= $counter) {
                $tot = $tot + 1; // on ajoute 1 pour chaque jour passé en revue

                if (in_array($i, $closed)) {
                    $num++; // on ajoute 1 pour chaque jour férié rencontré
                }

                // on compte chaque samedi et chaque dimanche
                if (((date("w", $timestamp3 + $i * $day_stamp) == 6) or (date(
                    "w",
                    $timestamp3 + $i * $day_stamp
                ) == 0)) and !in_array($i, $closed)) {
                    $num++;
                }
                $i++;
            }
            $year++; // on incremente l'année
        }
        $res = $tot - $num;
        // nombre de jours entre les 2 dates fournies - nombre de jours non ouvrés
        $diff = $res + 1;

        $data['pris'] = $diff;

        Conge::findOrFail($id)->update($data);

        return redirect()->route('conge.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date_depart' => ['date', 'required'],
            'date_arrive' => ['date', 'required'],
            'year' => ['required'],
            'personnel_id' => ['required', new CongeRule($request->personnel_id, $request->year, $request->nbr_conge)]
        ]);


        if ($request->isAdmin == "false") {
            $statut_id = 1;
        } else {
            $statut_id = 3;
        }
        $date_depart = new \DateTime($request->date_depart);
        $date_arrive = new \DateTime($request->date_arrive);

        $date1 = $request->date_depart;
        $date2 = $request->date_arrive;

        $timestamp1    = strtotime($date1);
        $timestamp2    = strtotime($date2);

        $tot = 0; // total de jours entre les 2 dates

        // dates en jours de l'année ( depuis le 1er jan )
        $date1 = date("z", $timestamp1); // date de depart
        $date2 = date("z", $timestamp2); //date d'arrivée

        $day_stamp = 86400; //(3600 * 24 ); // un journée en timestamp

        // années des deux dates
        $year1 = date("Y", $timestamp1);
        $year2 = date("Y", $timestamp2);

        $num = 0; // nombre de jours feries a compter sur la duree totale
        $counter = 0; // la durée entre deux date par année

        $year = $year1; // l'année en cours ( defaut : $year1 )


        // on calcule le nombre de jours de différence entre les deux dates, en tenant
        // compte des années
        while ($year <= $year2) {
            $date3         = date("d-n-Y", mktime(0, 0, 0, 1,  1,  $year));
            $timestamp3 = strtotime($date3);
            // date de référence pour l'année en cours
            $counter = 0; // compteur de jours pour chaque année

            //on récupère la date de pâques
            $easterDate   = easter_date($year);
            $easterDay    = date('j', $easterDate);
            $easterMonth  = date('n', $easterDate);
            $easterYear   = date('Y', $easterDate);



            // le tableau sort les jours fériés de l'année depuis le premier janvier
            $closed = array(
                // dates fixes
                date("z", mktime(0, 0, 0, 1,  1,  $year)),  // 1er janvier
                date("z", mktime(0, 0, 0, 5,  1,  $year)),  // Fête du travail
                date("z", mktime(0, 0, 0, 5,  8,  $year)),  // Victoire des alliés
                date("z", mktime(0, 0, 0, 7,  14, $year)),  // Fête nationale
                date("z", mktime(0, 0, 0, 8,  15, $year)),  // Assomption
                date("z", mktime(0, 0, 0, 11, 1,  $year)),  // Toussaint
                date("z", mktime(0, 0, 0, 11, 11, $year)),  // Armistice
                date("z", mktime(0, 0, 0, 12, 25, $year)),  // Noel

                // Dates basées sur Paques
                date(
                    "z",
                    mktime(0, 0, 0, $easterMonth, $easterDay + 1, $easterYear)

                ),  // Lundi de Paques
                date("z", mktime(
                    0,
                    0,
                    0,
                    $easterMonth,
                    $easterDay + 39,
                    $easterYear

                )), // Ascension
                date("z", mktime(
                    0,
                    0,
                    0,
                    $easterMonth,
                    $easterDay + 50,
                    $easterYear

                ))  // Lundi de Pentecote

            );

            // si c'est la première année -> on commence par la date de depart;
            // le compteur compte les jours jusqu'au 31dec
            if ($year == $year1 && $year < $year2) {
                $i = $date1;
                $counter +=  (364 + date("L", mktime(0, 0, 0, 1, 1, $year)));
            }


            // si c'est ni la première ni la dernière année -> on commence au premier
            // janvier;
            //le compteur compte tous les jours de l'année
            if ($year > $year1 && $year < $year2) {
                $i = date("z", mktime(0, 0, 0, 1,  1,  $year));
                $counter += 364 + date("L", mktime(0, 0, 0, 1, 1, $year));
            }

            // si c'est la dernière année -> on commence au premier janvier;
            // le compteur va jusqu'a la date d'arrivée
            if ($year == $year2 && $year > $year1) {
                $i = date("z", mktime(0, 0, 0, 1,  1,  $year));
                $counter += $date2;
            }

            // si les deux dates sont dans la même année
            if ($year == $year1 && $year == $year2) {
                $i = $date1;
                $counter += $date2;
            }

            // on boucle les jours sur la période donnée
            while ($i <= $counter) {
                $tot = $tot + 1; // on ajoute 1 pour chaque jour passé en revue

                if (in_array($i, $closed)) {
                    $num++; // on ajoute 1 pour chaque jour férié rencontré
                }

                // on compte chaque samedi et chaque dimanche
                if (((date("w", $timestamp3 + $i * $day_stamp) == 6) or (date(
                    "w",
                    $timestamp3 + $i * $day_stamp
                ) == 0)) and !in_array($i, $closed)) {
                    $num++;
                }
                $i++;
            }
            $year++; // on incremente l'année
        }
        $res = $tot - $num;
        // nombre de jours entre les 2 dates fournies - nombre de jours non ouvrés
        $diff = $res + 1;

        $data['pris'] = $diff;
        $data['congestatut_id'] = $statut_id;

        Conge::create($data);

        return redirect()->route('conge.index');
    }

    public function destroy($id)
    {
        $conge =  Conge::findOrFail($id);
        if ($conge->congestatut->statut === "en attente") {
        } else {
            if (!Gate::allows('admin')) {
                return abort(403, "Autorisation refusé");
            }
        }
        $conge->delete();

        return redirect()->route('conge.index');
    }

    public function ask()
    {
        $personnel = Personnel::where("email", auth()->user()->email)->first();

        return inertia('Conge/Employe/Ask', compact('personnel'));
    }

    public function agree($id)
    {
        $conge = Conge::findOrFail($id);
        $user = User::where("email", $conge->personnel->email)->first();
        $message = "Votre demande de congé été accordé";
        Message::create([
            "content" => $message,
            "user_id" => $user->id,
            "conge_id" => $conge->id
        ]);
        $conge->update([
            "congestatut_id" => 3,
        ]);
    }
}
