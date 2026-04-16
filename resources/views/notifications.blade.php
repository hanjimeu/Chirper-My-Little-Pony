<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Equestria Chirper</title>
    <link rel="icon" type="image/png" href="{{ asset('images/mlplogo.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>
  
    <audio id="music" preload="auto">
            <source src="audio/mlpabertura.mp3" type="audio/mpeg">
        </audio>

       <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Equestria</title>
    <link rel="icon" type="image/png" href="{{ asset('images/mlplogo.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>


    <!-- css básico -->
    <style>
        body {
            margin: 0;
            overflow-x: hidden;
        }
    </style>
</head>

<body class="flex flex-col min-h-screen">

    <main class="flex-1">

        <audio id="music" preload="auto">
            <source src="audio/mlpabertura.mp3" type="audio/mpeg">
        </audio>

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

    <script>

         // lógica dos aúdios sem repetir
                    const musicPlayer = document.getElementById("music");
                    const btn = document.getElementById("playBtn");

                    //  lista original com as músicas ou efeitos sonoros
                    const sonsOriginais = [
                        "{{ asset('audio/mlpabertura.mp3') }}",
                        "{{ asset('audio/smile.mp3') }}",
                        "{{ asset('audio/airplanes.mp3') }}",
                        "{{ asset('audio/cafeteria.mp3') }}",
                        "{{ asset('audio/cutiemark.mp3') }}",
                        "{{ asset('audio/thisday.mp3') }}",
                        
                    ];

                    // fila de reprodução
                    let filaDeSons = [];

                    // função para embaralhar a lista (Algoritmo Fisher-Yates)
                    function embaralhar(array) {
                        let lista = [...array];
                        for (let i = lista.length - 1; i > 0; i--) {
                            const j = Math.floor(Math.random() * (i + 1));
                            [lista[i], lista[j]] = [lista[j], lista[i]];
                        }
                        return lista;
                    }

                    // função para tocar a próxima música
                   function tocarProxima() {
                        if (filaDeSons.length === 0) {
                        filaDeSons = embaralhar(sonsOriginais);
                    }
                        const proximoSom = filaDeSons.pop();
                        musicPlayer.src = proximoSom;
                        musicPlayer.play();
                         btn.src = "/images/djpon3.png"; // <-- trocado
                    }

// 1 clique = Play/Pause
btn.addEventListener("click", () => {
    if (musicPlayer.src === "") {
        tocarProxima();
    } else {
        if (!musicPlayer.paused) {
            musicPlayer.pause();
            btn.src = "/images/djpon3.png"; // <-- trocado
        } else {
            musicPlayer.play();
            btn.src = "/images/djpon3.png"; // <-- trocado
        }
    }
});

// 2 cliques = Pular Música
btn.addEventListener("dblclick", () => {
    tocarProxima();
});

// reseta quando acaba
musicPlayer.onended = () => {
    btn.src = "/images/djpon3.png"; // <-- trocado
};
              
    </script>


    <div class="min-h-screen bg-cover bg-center flex items-start justify-center pt-28"
        style="background-image: url('/images/main6arcoiris.gif');">

        <div class="absolute inset-0 bg-black/40 z-0"></div>

        <!-- card principal -->
        <div class="relative z-10 w-full max-w-xl">

            <h2 class="text-3xl font-black text-white mb-4 drop-shadow-[2px_2px_6px_black]">
                🔔 Notificações
            </h2>

            <div class="bg-white/90 backdrop-blur border-4 border-black rounded-3xl shadow-[6px_6px_0px_black] p-5">

                @forelse($notifications as $n)
                    <a href="/notifications/{{ $n->id }}" class="block flex items-center gap-3 pb-3 mb-3 rounded-xl p-2 transition
                               {{ $n->read ? 'opacity-60' : 'bg-red-50 border border-red-400' }}">

                        <!-- avatar -->
                        <img src="{{ $n->fromUser->photo ? asset('storage/' . $n->fromUser->photo) : 'https://api.dicebear.com/7.x/adventurer/svg?seed=' . $n->fromUser->id }}"
                            class="w-10 h-10 border-2 border-black rounded-full bg-white object-cover">

                        <!-- texto -->
                        <div class="flex-1 text-sm">

                            <span class="font-bold">
                                {{ $n->fromUser->name }}
                            </span>

                            @if($n->type == 'like')
                                curtiu seu post ❤️
                            @else
                                comentou no seu post 💬
                            @endif

                            <div class="text-xs text-gray-500">
                                {{ $n->created_at->diffForHumans() }}
                            </div>

                        </div>

                    </a>
                @empty
                    <p class="text-center font-bold text-gray-500">
                        Nenhuma notificação ainda 😴
                    </p>
                @endforelse

            </div>

        </div>
        </a>

         <script>
    // lógica das opções do botão de assistir
    const assistirBtn = document.getElementById('assistir');
    const targetUrl = 'https://youtu.be/Vpxboxu-fU8?t=1';

    assistirBtn.addEventListener('click', () => {
        window.open(targetUrl, '_blank');
    });
      </script>

</body>

</html>