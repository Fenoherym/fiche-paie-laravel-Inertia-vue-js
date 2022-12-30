<?php

namespace App\Http\Controllers;

use App\Models\Contrat;
use Illuminate\Http\Request;

class ContratController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            "id" => ['required'],
            "name" => ['required'],
        ]);

        Contrat::findOrFail($request->id)->update($data);

        return redirect()->back();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => ['required'],
        ]);

        Contrat::create($data);

        return redirect()->back();
    }

    public function destroy($id)
    {
        Contrat::findOrFail($id)->delete();

        return redirect()->back();
    }
}
