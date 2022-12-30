<?php

use App\Models\Message;
use App\Models\Rubrique;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Expr\Cast\Object_;

function getCurrentRouteName()
{
    return Route::currentRouteName();
}

function getMessagesCount($user_id)
{
    $count = Message::where('user_id', $user_id)->count();

    return $count;
}

function calculGainBrute(Object $rubrique)
{
    if (!$rubrique->isRetenue) {
        if ($rubrique->nombre != null) {

            if ($rubrique->taux_part_salarial === null || $rubrique->taux_part_salarial === 0) {
                return ($rubrique->nombre * $rubrique->base);
            } else {
                return (($rubrique->nombre * $rubrique->base * $rubrique->taux_part_salarial) / 100);
            }
        } else {
            if ($rubrique->taux_part_salarial === null || $rubrique->taux_part_salarial === 0) {
                return ($rubrique->base);
            } else {
                return ($rubrique->base * $rubrique->taux_part_salarial) / 100;
            }
        }
    } else {
        return 0;
    }
}

function calculIRSA($gain_imposable, Object $irsas)
{
    $valeur_irsa = 0;
    for ($i = 0; $i < count($irsas); $i++) {
        if ($gain_imposable > $irsas[$i]->base_min && $gain_imposable <= $irsas[$i]->base_max) {
            if ($i === 1) {
                $valeur_irsa = ($gain_imposable - $irsas[$i]->base_min) * ($irsas[$i]->taux / 100);
            }
            if ($i === 2) {
                $valeur_irsa = ($irsas[$i - 1]->base_max - $irsas[$i - 1]->base_min) * ($irsas[$i - 1]->taux / 100) + ($gain_imposable - $irsas[$i]->base_min) * ($irsas[$i]->taux / 100);
            }
            if ($i === 3) {
                $valeur_irsa = ($irsas[$i - 2]->base_max - $irsas[$i - 2]->base_min) * ($irsas[$i - 2]->taux / 100) + ($irsas[$i - 1]->base_max - $irsas[$i - 1]->base_min) * ($irsas[$i - 1]->taux / 100) + ($gain_imposable - $irsas[$i]->base_min) * ($irsas[$i]->taux / 100);
            }
        }
        if ($i === (count($irsas) - 1)) {
            if ($gain_imposable > $irsas[$i]->base_min) {
                $valeur_irsa = ($irsas[$i - 3]->base_max - $irsas[$i - 3]->base_min) * ($irsas[$i - 3]->taux / 100) + ($irsas[$i - 2]->base_max - $irsas[$i - 2]->base_min) * ($irsas[$i - 2]->taux / 100) + ($irsas[$i - 1]->base_max - $irsas[$i - 1]->base_min) * ($irsas[$i - 1]->taux / 100) + ($gain_imposable - $irsas[$i]->base_min) * ($irsas[$i]->taux / 100);
            }
        }
    }

    return $valeur_irsa;
}
