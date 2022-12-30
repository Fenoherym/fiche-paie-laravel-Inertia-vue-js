<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\UpdateProfilRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index()
    {
        return inertia('Profil/Index');
    }

    public function update(Request $request)
    {
        $user = User::findOrFail($request->id);

        $request->validate([
            'ancien_password' => ['required', new UpdateProfilRule($request->ancien_password, $user->password)],
            'new_password' => ['required'],
            'confirm_new_password' => ['required']
        ]);

        if (Hash::check($request->ancien_password, $user->password)) {
            $user->update([
                "name" => $request->name,
                "password" => Hash::make($request->new_password)
            ]);

            return redirect()->back()->with('success', "Modification(s) enregistrés");
        }
    }

    public function update_name(Request $request)
    {
        $user = User::findOrFail($request->id);
        $request->validate([
            'name' => ['required'],
            'email' => ['email']
        ]);

        $user->update([
            "name" => $request->name,
            "email" => $request->email
        ]);

        return redirect()->back()->with('success', "Modification(s) enregistrés");
    }
}
