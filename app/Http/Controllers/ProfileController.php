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

    public function update(Request $request) {
    $user = auth()->user();
    
    // ... lógica de validação ...
    
    $user->name = $request->name;
    $user->cutiemark = $request->cutiemark; 
    
    if ($request->hasFile('photo')) {
        // ... lógica da foto ...
    }

    $user->save();

    // Atualiza os dados na sessão
    auth()->setUser($user); 

    // REDIRECIONAMENTO PARA A HOME
    // Você pode usar '/' ou route('home') se sua rota tiver nome
    return redirect('/')->with('success', 'Perfil atualizado com sucesso!');
}public function update(Request $request)
{
    $user = auth()->user();

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