<?php

namespace App\Http\Controllers;

use App\Models\Conge;
use App\Models\Message;
use App\Models\Personnel;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::where('user_id', auth()->user()->id)->latest()->get();
        $messages->load('conge');
        return inertia('Message/Index', compact('messages'));
    }
    public function store(Request $request)
    {
        $request->validate([
            "content" => ["required"]
        ]);
        $personnel = Personnel::findOrFail($request->personnel_id);
        $user = User::where('email', $personnel->email)->first();
        Conge::findOrFail($request->conge_id)->update([
            "congestatut_id" => 2
        ]);

        Message::create([
            "content" => $request->content,
            "conge_id" => $request->conge_id,
            "user_id" => $user->id
        ]);

        return redirect()->back();
    }
    public function destroy($id)
    {
        Message::findOrFail($id)->delete();

        return redirect()->back();
    }
}
