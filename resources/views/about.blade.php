<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equestria Chirper</title>
    <link rel="icon" type="image/png" href="{{ asset('images/mlplogo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            margin: 0;
            overflow-x: hidden;
            font-family: 'Arial', sans-serif;
        }

        @keyframes fall {
            to {
                transform: translateY(100vh);
            }
        }
    </style>
</head>

<body class="flex flex-col min-h-screen text-gray-800">

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




    <div class="relative min-h-screen bg-cover bg-center bg-fixed pt-32 pb-20 flex justify-center items-start"
        style="background-image: url('/images/main6arcoiris.gif');">

        <div class="absolute inset-0 bg-black/60 z-0"></div>

        <div class="relative z-20 w-full max-w-5xl px-6">

    <!-- header -->
    <div class="bg-white border-4 border-black rounded-3xl p-3 mb-5 shadow-[8px_8px_0px_black] text-center">
        <h1 class="text-3xl font-black uppercase mb-1">Sobre o Equestria Chirper</h1>
    </div>

    <div class="grid grid-cols-3 gap-5" style="height: calc(100vh - 300px);">

    <!-- DESENVOLVEDORA — coluna 1 -->
    <div class="bg-white border-4 border-black rounded-3xl p-4 shadow-[6px_6px_0px_black] overflow-auto">
        <img src="{{ asset('images/marimari.jpeg') }}"
            class="mx-auto w-20 h-20 border-4 border-black rounded-full mb-2 bg-white shadow-[4px_4px_0px_black] object-cover">
        <h2 class="text-base font-black uppercase text-pink-400 text-center">Mariana Moreira</h2>
        <p class="text-xs uppercase mb-2 text-black/50 text-center">Estudante e Artista</p>
        <p class="text-sm text-justify">
            Tenho 17 anos e atualmente estou estudando Desenvolvimento de Sistemas na Etec da Zona Leste. Gosto de ler, desenhar, 
            pintar, assistir séries e principalmente ouvir músicas. 
    </div>

    <!-- TRABALHO + REFERÊNCIA — coluna 2 -->
    <div class="bg-white border-4 border-black rounded-3xl p-4 shadow-[6px_6px_0px_black] overflow-auto">
        <h2 class="text-lg font-black mb-2 text-pink-400 uppercase "> Trabalho</h2>
        <p class="text-xs text-gray-800 leading-tight mb-2">
            Projeto desenvolvido para a disciplina de Programação Web III sob orientação do
            <a href="https://github.com/prosalomaon" target="_blank" class="underline hover:text-blue-800">Professor Salomão</a>.
        </p>
        <div class="p-2 bg-pink-100 border-2 border-black rounded-xl text-xs italic mb-3">
            A proposta foi criar uma rede social funcional (CRUD) utilizando o framework Laravel.
        </div>
        <div class="border-t-2 border-black/10 pt-3">
            <p class="text-xs mb-1">
                Tutorial oficial do Laravel:
                <a href="https://laravel.com/learn/getting-started-with-laravel/what-are-we-building" target="_blank" class="underline hover:text-blue-800">What are we building?</a>
            </p>
        </div>
        <div class="flex justify-between items-center mt-3">
            <img src="/images/main6fofas.png" class="w-64 h-32 object-contain">
        </div>
    </div>

    <div class="bg-white border-4 border-black rounded-3xl p-4 shadow-[6px_6px_0px_black] relative overflow-hidden text-center">
    
    <h2 class="text-lg font-black uppercase italic mb-3 text-pink-400 relative z-10">Meus Contatos</h2>
    
    <div class="flex flex-col items-center gap-3 relative z-10">
        
        <div class="flex justify-center gap-2 w-full">
            <a href="https://instagram.com/hanjiimeu" target="_blank">
                <img src="https://img.shields.io/badge/Instagram-%23E4405F.svg?logo=Instagram&logoColor=white" class="h-7 object-contain hover:scale-110 transition">
            </a>
            <a href="https://www.tiktok.com/@hanjiimeu" target="_blank">
                <img src="https://img.shields.io/badge/TikTok-black?logo=tiktok&logoColor=white" class="h-7 object-contain hover:scale-110 transition">
            </a>
        </div>

        <img src="{{ asset('images/main6s.png') }}" class="h-26 object-contain my-1">

        <div class="flex justify-center gap-2 w-full">
            <a href="https://www.pinterest.com/hanjiflect" target="_blank">
    <img src="https://img.shields.io/badge/Pinterest-E60023?logo=pinterest&logoColor=white" 
         class="h-7 object-contain hover:scale-110 transition">
</a>
            <a href="https://github.com/hanjimeu" target="_blank">
                <img src="https://img.shields.io/badge/GitHub-000000?logo=github&logoColor=white" class="h-7 object-contain hover:scale-110 transition">
            </a>
        </div>

    </div>
</div>

</div>

    <!-- footer -->
    <div class="mt-6 text-center bg-white border-4 border-black rounded-2xl p-3 shadow-[4px_4px_0px_black]">
        <p class="uppercase text-xs font-black">© 2026 Equestria Chirper Inc. - Mariana dos Santos Moreira</p>
    </div>

</div>
<script>
    // lógica das opções do botão de assistir
    const assistirBtn = document.getElementById('assistir');
    const targetUrl = 'https://youtu.be/Vpxboxu-fU8?t=1';

    assistirBtn.addEventListener('click', () => {
        window.open(targetUrl, '_blank');
    });

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

        </div>
    </div>

</body>

</html>