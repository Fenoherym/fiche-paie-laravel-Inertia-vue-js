<?php

namespace App\Http\Controllers;

use App\Models\Contrat;
use App\Models\Societe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class SocieteController extends Controller
{
    public function index()
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('paie.index');
        }
        $societe = Societe::with([
            'establishments' => [
                'workplaces'
            ]
        ])->first();
        $contrats = Contrat::all();

        return inertia('Societe/Index', [
            "societe" => $societe,
            "contrats" => $contrats
        ]);
    }

    public function update(Request $request, $id)
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('paie.index');
        }
        $data = $request->validate([
            "name" => ['required'],
            "about" => ['nullable'],
            "adresse" => ['required'],
            "NIF" => ['required', 'numeric'],
            "STAT" => ['required', 'numeric'],
            "tel" => ['required'],
            "email" => ['required'],

        ]);

        Societe::findOrFail($id)->update($data);

        return redirect()->route('societe.index');
    }

    public function changeLogo(Request $request)
    {

        $request->validate([
            "logoUrl" => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048'
        ]);

        $file_name = time() . '.' . $request->logoUrl->extension();
        $path = $request->logoUrl->storeAs(
            'logo',
            $file_name,
            'public'
        );
        $societe = Societe::all()->first();
        if ($societe->logoUrl != null) {
            Storage::disk('public')->delete($societe->logoUrl);
        }

        $societe->update([
            "logoUrl" => $path
        ]);


        return redirect()->back();
    }
}
