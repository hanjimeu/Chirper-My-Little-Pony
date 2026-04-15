<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

   
public function updateProfile(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'name' => 'required|string|max:255',
        'cutiemark' => 'nullable|string|max:255',
        'photo' => 'nullable|image|max:2048'
    ]);

    $user->name = $request->name;
    $user->cutiemark = $request->cutiemark;

    if ($request->hasFile('photo')) {
        $path = $request->file('photo')->store('profiles', 'public');
        $user->photo = $path;
    }

    $user->save();

    auth()->setUser($user);

    return redirect('/')->with('success', 'Perfil atualizado com sucesso!');
}
    public function destroy(Request $request)
    {
        $user = Auth::user();

        $user->chirps()->delete();
        $user->comments()->delete();
        $user->delete();

        Auth::logout();

        return redirect('/')->with('success', 'Conta deletada com sucesso');
    }
}