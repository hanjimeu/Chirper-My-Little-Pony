<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $user->name = $request->name;
        $user->cutiemark = $request->cutiemark;

       if ($request->hasFile('photo')) {
    // 1. Deleta a foto antiga se ela existir para não encher o servidor de lixo
    if ($user->photo && \Storage::disk('public')->exists($user->photo)) {
        \Storage::disk('public')->delete($user->photo);
    }

    // 2. Salva a nova foto
    $path = $request->file('photo')->store('profiles', 'public');
    
    // 3. Salva no banco (o $path já será 'profiles/nome.jpg')
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