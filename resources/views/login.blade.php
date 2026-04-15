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
                        </div>
                        <div class="relative group">
                            {{-- ID playBtn para o Script --}}
                            <img id="playBtn" src="/images/djpon3.png" class="w-12 h-12 cursor-pointer select-none">
                        </div>
                        <div class="relative group">
                            <a href="{{ route('about') }}">
                                <img src="/images/princesslunaecelestia.png" class="w-12 h-12 cursor-pointer select-none">
                            </a>
                        </div>
                         <div class="relative group">
            <a href="/signup">
                <img src="/images/princesscelestia.png" class="w-12 h-12 cursor-pointer select-none">
            </a>
            <span class="absolute -bottom-10 left-1/2 -translate-x-1/2 bg-black text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">
                Cadastrar-se
            </span>
        </div>
                    </div>

                    @auth
                        <div class="flex items-center gap-3 ml-2 pl-3 border-l-2 border-black/20">
                            {{-- Perfil e Sair (seu código de auth aqui) --}}
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