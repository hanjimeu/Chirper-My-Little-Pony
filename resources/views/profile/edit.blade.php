<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Equestria Chirper</title>
    <link rel="icon" type="image/png" href="{{ asset('images/mlplogo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { margin: 0; overflow-x: hidden; }
    </style>
</head>

<body class="flex flex-col min-h-screen">

    @php
        $countNotifications = \App\Models\Notification::where('user_id', auth()->id())
            ->where('read', false)
            ->count();
    @endphp

    <audio id="music" preload="auto">
        <source src="audio/mlpabertura.mp3" type="audio/mpeg">
    </audio>

    <main class="flex-1">
        <nav class="fixed top-0 left-0 w-full z-50 bg-white border-b-4 border-black shadow">
            <div class="flex justify-between items-center px-6 py-4">
                <a href="/" class="flex items-center gap-2 text-xl font-black hover:scale-105 transition">
                    <img src="/images/mlplogo.png" class="h-12 w-auto object-contain">
                    Equestria Chirper
                </a>

                <div class="flex gap-3 items-center">
                    <div class="flex gap-4 items-center">
                        <div class="relative group">
                            <img id="assistir" src="/images/main6s.png" class="w-12 h-12 cursor-pointer select-none">
                        </div>
                        <div class="relative group">
                            <img id="playBtn" src="/images/djpon3.png" class="w-12 h-12 cursor-pointer select-none">
                        </div>
                        <div class="relative group">
                            <a href="{{ route('about') }}">
                                <img src="/images/princesslunaecelestia.png" class="w-12 h-12 cursor-pointer select-none">
                            </a>
                        </div>
                    </div>

                    @auth
                        <div class="flex items-center gap-3 ml-2 pl-3 border-l-2 border-black/20">
                            <a href="/notifications" class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-black hover:scale-110 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                @if($countNotifications > 0)
                                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs px-2 rounded-full font-bold animate-pulse">
                                        {{ $countNotifications }}
                                    </span>
                                @endif
                            </a>

                            @if(auth()->user()->cutiemark)
                                <img src="/images/cutiemarks/{{ auth()->user()->cutiemark }}" class="w-8 h-8 object-contain">
                            @endif

                            <div class="flex flex-col">
                                <span class="text-[10px] font-black uppercase leading-none text-black/50">Logado como:</span>
                                <span class="text-sm font-black uppercase leading-none">{{ auth()->user()->name }}</span>
                            </div>

                            <form method="POST" action="/logout" class="ml-1">
                                @csrf
                                <button type="submit" class="text-[10px] font-bold bg-red-500 text-white border border-black px-2 py-0.5 rounded-md hover:bg-red-600 transition">
                                    SAIR
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>

        <div class="relative min-h-screen bg-cover bg-center pt-28 pb-10 flex justify-center items-center" style="background-image: url('/images/main6arcoiris.png');">
            <div class="absolute inset-0 bg-black/60 z-0"></div>

            <div class="relative z-20 w-full max-w-[420px]">
                <div class="bg-white border-4 border-black rounded-3xl p-6 shadow-[8px_8px_0px_black]">
                    <h2 class="text-xl font-black mb-5 text-center uppercase tracking-tight text-pink-500">Editar Perfil</h2>

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf

                        
                        <div class="mb-4">
                            <label class="text-[10px] font-black uppercase text-black/40 ml-1">Seu Nome</label>
                            <input type="text" name="name" value="{{ auth()->user()->name }}" class="w-full border-2 border-black p-2 rounded-xl font-bold outline-none focus:bg-gray-50">
                        </div>

                        <div class="flex flex-col items-center mb-6">
                            <img id="preview" src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : 'https://api.dicebear.com/7.x/adventurer/svg?seed=' . auth()->user()->id }}"
                                 class="w-24 h-24 border-4 border-black rounded-full object-cover mb-2 bg-white shadow-[4px_4px_0px_black]">

                            <label class="bg-pink-300 border-2 border-black px-4 py-1 rounded-full cursor-pointer hover:scale-105 transition font-bold text-xs uppercase">
                                Trocar foto
                                <input type="file" name="photo" id="photoInput" class="hidden" accept="image/*">
                            </label>
                        </div>

                        <div class="mb-6">
                            <p class="text-center text-[10px] font-black uppercase tracking-widest text-pink-400 mb-2">Atualizar sua Cutie Mark</p>
                            <div class="grid grid-cols-6 gap-2 p-2 bg-gray-50 border-2 border-black rounded-2xl">
                                @php
                                    $marks = ['twilight.png', 'fluttershy.webp', 'rarity.png', 'pinkiepie.png', 'applejack.png', 'rainbowdash.png'];
                                @endphp

                                @foreach($marks as $mark)
                                <label class="cursor-pointer group">
                                    <input type="radio" name="cutiemark" value="{{ $mark }}" class="hidden peer" {{ auth()->user()->cutiemark == $mark ? 'checked' : '' }}>
                                    <img src="{{ asset('images/cutiemarks/' . $mark) }}" 
                                        class="w-9 h-9 object-contain grayscale peer-checked:grayscale-0 peer-checked:scale-110 peer-checked:drop-shadow-[0_0_5px_rgba(236,72,153,0.5)] transition hover:scale-105"
                                        title="{{ str_replace('.png', '', $mark) }}">
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-pink-300 border-2 border-black py-3 rounded-xl font-black uppercase tracking-widest hover:translate-y-0.5 hover:shadow-none transition shadow-[4px_4px_0px_black]">
                            Salvar Alterações
                        </button>
                    </form>

                    <div class="mt-8 border-t-2 border-black/10 pt-4 text-center">
                        <h3 class="text-red-600 font-black mb-2 text-xs uppercase">Zona de perigo ⚠️</h3>
                        <button onclick="openDeleteAccountModal()" class="bg-red-600 text-white border-2 border-black px-4 py-2 rounded-xl font-bold text-xs hover:bg-red-800 transition">
                            Excluir conta permanentemente
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="delete-account-modal" class="fixed inset-0 bg-black/80 hidden flex items-center justify-center z-[100]">
        <div class="bg-white border-4 border-black rounded-3xl p-6 text-center max-w-xs mx-4">
            <h2 class="text-2xl font-black text-red-600 mb-3 uppercase">Cuidado!</h2>
            <p class="mb-4 font-bold text-sm">Não que eu me importe, mas essa ação é irreversível! 💀</p>
            <div class="flex gap-4 justify-center">
                <button onclick="closeDeleteAccountModal()" class="bg-green-500 text-white border-2 border-black px-6 py-2 rounded-xl font-bold hover:scale-105 transition shadow-[4px_4px_0px_black]">Não</button>
                <form method="POST" action="/profile/delete">
                    @csrf @method('DELETE')
                    <button class="bg-red-600 text-white border-2 border-black px-6 py-2 rounded-xl font-bold hover:scale-105 transition shadow-[4px_4px_0px_black]">Sim</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openDeleteAccountModal() { document.getElementById('delete-account-modal').classList.remove('hidden'); }
        function closeDeleteAccountModal() { document.getElementById('delete-account-modal').classList.add('hidden'); }

        // Preview da foto ao selecionar
        document.getElementById('photoInput').onchange = evt => {
            const [file] = evt.target.files;
            if (file) { document.getElementById('preview').src = URL.createObjectURL(file); }
        }
    </script>
</body>
</html>