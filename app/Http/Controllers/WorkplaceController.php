<?php

namespace App\Http\Controllers;

use App\Models\Workplace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class WorkplaceController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function store(Request $request)
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('paie.index');
        }
        $data = $request->validate([
            "name" => ['required', 'unique:workplaces'],
            "establishment_id" => ['required']
        ]);
        Workplace::create($data);

        return redirect()->back();
    }

    public function destroy($id)
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('paie.index');
        }
        Workplace::findOrFail($id)->delete();

        return redirect()->back();
    }
}
