<?php

namespace App\Http\Controllers;

use App\Models\Irsa;
use Illuminate\Http\Request;

class IrsaController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function update(Request $request)
    {
        foreach (json_decode($request->irsaValues) as $irsa) {
            Irsa::find($irsa->id)->update([
                "base_min" => $irsa->base_min,
                "base_max" => $irsa->base_max,
                "taux" => $irsa->taux,
            ]);
        }

        return redirect()->route('rubrique.index');
    }
}
