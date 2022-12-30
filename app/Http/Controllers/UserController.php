<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index()
    {
        if (!Gate::allows('admin')) {
            abort(403);
        }

        $users = User::all();
        $users->load('role');
        return inertia('User/Index', compact('users'));
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return redirect()->back();
    }
}
