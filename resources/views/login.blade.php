<!DOCTYPE html>
<html lang="pt-br">

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

    {{-- O elemento de áudio deve aparecer apenas UMA vez --}}
    <audio id="music" preload="auto"></audio>

    <main class="flex-1">

        <!-- navbar -->
        <nav class="fixed top-0 left-0 w-full z-50 bg-pink-100 backdrop-blur border-b-4 border-black shadow">
    <div class="flex justify-between items-center px-6 py-4">

        @php
            $countNotifications = \App\Models\Notification::where('user_id', auth()->id())
                ->where('read', false)
                ->count();
        @endphp
        
        <a href="/" class="flex items-center gap-2 text-xl font-black hover:scale-105 transition">
            <img src="/images/mlplogo.png" class="h-12 w-auto object-contain">
            Equestria Chirper
        </a>

        <div class="flex gap-3 items-center">

            <div class="flex gap-4 items-center">

    <div class="relative group">
        <img id="assistir" src="/images/main6s.png" class="w-12 h-12 cursor-pointer select-none">
        <span class="absolute -bottom-10 left-1/2 -translate-x-1/2 bg-black text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">
            Assistir
        </span>
    </div>

    <div class="relative group">
        <img id="playBtn" src="/images/djpon3.png" class="w-12 h-12 cursor-pointer select-none">
        <span class="absolute -bottom-10 left-1/2 -translate-x-1/2 bg-black text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">
            Tocar Música
        </span>
    </div>

    <div class="relative group">
        <a href="{{ route('about') }}">
            <img src="/images/princesslunaecelestia.png" class="w-12 h-12 cursor-pointer select-none">
        </a>
        <span class="absolute -bottom-10 left-1/2 -translate-x-1/2 bg-black text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">
            Sobre Equestria
        </span>
    </div>

    @guest
        <div class="relative group">
            <a href="/login">
                <img src="/images/princessluna.png" class="w-12 h-12 cursor-pointer select-none">
            </a>
            <span class="absolute -bottom-10 left-1/2 -translate-x-1/2 bg-black text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">
                Entrar
            </span>
        </div>

        <div class="relative group">
            <a href="/signup">
                <img src="/images/princesscelestia.png" class="w-12 h-12 cursor-pointer select-none">
            </a>
            <span class="absolute -bottom-10 left-1/2 -translate-x-1/2 bg-black text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">
                Cadastrar-se
            </span>
        </div>
    @endguest

</div>

            {{-- EXIBE APENAS SE ESTIVER LOGADO --}}
            @auth
    <div class="flex items-center gap-3 ml-2 pl-3 border-l-2 border-black/20">
        
        <a href="/notifications" class="relative">
             <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            @if($countNotifications > 0)
                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] px-1.5 rounded-full font-bold animate-pulse">{{ $countNotifications }}</span>
            @endif
        </a>

        <div class="flex items-center gap-1.5 ">
            <div class="relative group cursor-pointer">
                <a href="/profile/edit">
                    <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : 'https://api.dicebear.com/7.x/adventurer/svg?seed=' . auth()->user()->id }}"
                        class="w-10 h-10 border-2 border-black rounded-full bg-white object-cover shadow-[2px_2px_0px_black]">
                </a>
            </div>

            @if(auth()->user()->cutiemark)
                <img src="/images/cutiemarks/{{ auth()->user()->cutiemark }}" 
                     class="w-8 h-8 object-contain drop-shadow-[1px_1px_0px_white]" 
                     title="Sua Cutie Mark">
            @endif

            <div class="flex flex-col ml-1">
                <span class="text-[9px] font-black uppercase leading-none text-black/40">Pônei:</span>
                <span class="text-sm font-black uppercase leading-none">{{ auth()->user()->name }}</span>
            </div>
        </div>

        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="text-[10px] font-bold bg-red-500 text-white border border-black px-2 py-1 rounded-md hover:bg-red-600 transition shadow-[2px_2px_0px_black] active:shadow-none">
                SAIR
            </button>
        </form>
    </div>
@endauth

        </div>
    </div>
</nav>

        <div class="min-h-screen bg-cover bg-center flex items-center justify-center pt-24"
            style="background-image: url('/images/main6arcoiris.gif');">
            <div class="absolute inset-0 bg-black/40 z-0"></div>

            <div class="bg-white/90 backdrop-blur border-4 border-black rounded-3xl shadow-[6px_6px_0px_black] p-6 w-96 z-10">
                <h2 class="text-2xl font-bold text-center text-pink-500 mb-4">Login</h2>
                {{-- Seu formulário de login aqui --}}
                <form method="POST" action="/login">
                    @csrf
                    <input type="email" name="email" placeholder="Email" class="w-full mb-3 border-2 border-black rounded-xl p-2">
                    <input type="password" name="password" placeholder="Senha" class="w-full mb-4 border-2 border-black rounded-xl p-2">
                    <button class="w-full bg-pink-300 text-white border-2 border-black rounded-full py-2 font-bold uppercase">Entrar</button>
                </form>
            </div>
        </div>
    </main>

    <script>
        const musicPlayer = document.getElementById("music");
        const btn = document.getElementById("playBtn");
        const assistirBtn = document.getElementById('assistir');

        // Assistir YouTube
        assistirBtn.addEventListener('click', () => {
            window.open('https://youtu.be/Vpxboxu-fU8?t=1', '_blank');
        });

        // Lista de sons usando asset() corretamente
        const sonsOriginais = [
            "{{ asset('audio/mlpabertura.mp3') }}",
            "{{ asset('audio/smile.mp3') }}",
            "{{ asset('audio/airplanes.mp3') }}",
            "{{ asset('audio/cafeteria.mp3') }}",
            "{{ asset('audio/cutiemark.mp3') }}",
            "{{ asset('audio/thisday.mp3') }}"
        ];

        let filaDeSons = [];

        function embaralhar(array) {
            let lista = [...array];
            for (let i = lista.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [lista[i], lista[j]] = [lista[j], lista[i]];
            }
            return lista;
        }

        function tocarProxima() {
            if (filaDeSons.length === 0) {
                filaDeSons = embaralhar(sonsOriginais);
            }
            const proximoSom = filaDeSons.pop();
            musicPlayer.src = proximoSom;
            musicPlayer.play().catch(e => console.log("Erro ao tocar: ", e));
        }

        btn.addEventListener("click", () => {
            if (!musicPlayer.src || musicPlayer.src === window.location.href) {
                tocarProxima();
            } else {
                if (!musicPlayer.paused) {
                    musicPlayer.pause();
                } else {
                    musicPlayer.play();
                }
            }
        });

        btn.addEventListener("dblclick", () => {
            tocarProxima();
        });
    </script>
</body>
</html>