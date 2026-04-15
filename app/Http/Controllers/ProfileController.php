<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

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

        return redirect('/')->with('success', 'Perfil atualizado com sucesso!');
    }

    public function destroy()
    {
        $user = Auth::user();

        $user->chirps()->delete();
        $user->comments()->delete();
        $user->delete();

        Auth::logout();

        return redirect('/')->with('success', 'Conta deletada com sucesso');
    }
}