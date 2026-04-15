<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Chirp;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Models\Notification;

// sobre
Route::get('/about', function () {
    return view('about');
})->name('about');

// perfil
Route::get('/profile/edit', [ProfileController::class, 'edit'])
    ->middleware('auth')
    ->name('profile.edit');

Route::post('/profile', [ProfileController::class, 'updateProfile'])
    ->middleware('auth')
    ->name('profile.update');

Route::delete('/profile/delete', [ProfileController::class, 'destroy'])
    ->middleware('auth')
    ->name('profile.destroy');


// --- NOTIFICAÇÕES ---

Route::get('/notifications', function () {
    $userId = Auth::id();

    \App\Models\Notification::where('user_id', $userId)
        ->where('read', false)
        ->update(['read' => true]);

    $notifications = \App\Models\Notification::with('fromUser')
        ->where('user_id', $userId)
        ->latest()
        ->get();

    return view('notifications', compact('notifications'));
})->middleware('auth');

Route::get('/notifications/{id}', function ($id) {

    $notification = \App\Models\Notification::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    $notification->update(['read' => true]);

    if ($notification->type === 'comment' && $notification->comment_id) {
        return redirect('/#comment-' . $notification->comment_id);
    }

    return redirect('/#chirp-' . $notification->chirp_id);

})->middleware('auth');

// comentário
Route::post('/chirps/{chirp}/comment', [CommentController::class, 'store'])
    ->middleware('auth');

// like
Route::post('/chirps/{chirp}/like', [LikeController::class, 'toggle'])
    ->middleware('auth');

// home
Route::get('/', function () {
    $chirps = Chirp::with(['user', 'likes', 'comments.user'])->latest()->get();
    return view('home', compact('chirps'));
})->name('chirps.index');


// --- CADASTRO ---

Route::get('/signup', function () {
    return view('signup');
})->name('signup');

Route::post('/signup', function (Request $request) {
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:4',
        'cutiemark' => 'required',
        'photo' => 'nullable|image|max:2048'
    ]);

    $path = null;
    if ($request->hasFile('photo')) {
        $path = $request->file('photo')->store('photos', 'public');
    }

    $user = \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        'photo' => $path,
        'cutiemark' => $request->cutiemark
    ]);

    \Illuminate\Support\Facades\Auth::login($user);

    return redirect('/');
});

// login
Route::get('/login', function () {
    return view('login');
});

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect('/');
    }

    return back()->withErrors([
        'email' => 'Email ou senha inválidos'
    ]);
});

// logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
});

// criar chirp
Route::post('/chirps', function (Request $request) {
    if (!Auth::check()) {
        return redirect('/login');
    }

    $validated = $request->validate([
        'message' => 'required|max:255',
        'image' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:20480',
    ]);

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('photos', 'public');
        $validated['image'] = $path;
    }

    $request->user()->chirps()->create($validated);
    return redirect('/');
});

// editar chirp
Route::patch('/chirps/{chirp}', [ChirpController::class, 'update'])
    ->name('chirps.update')
    ->middleware('auth');

// deletar chirp
Route::delete('/chirps/{chirp}', [ChirpController::class, 'destroy'])
    ->name('chirps.destroy')
    ->middleware('auth');