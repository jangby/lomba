<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAYAR TAMPIL - Haflah Assa'adah 2026</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* TEMA HIJAU ZAMRUD (EMERALD) */
        body { 
            background: radial-gradient(circle at 50% 0%, #064e3b 0%, #022c22 40%, #000000 100%); 
            color: white; 
            min-height: 100vh; overflow: hidden; 
            font-family: 'Times New Roman', Times, serif;
            user-select: none; -webkit-user-select: none;
        }
        
        .ambient-light {
            position: absolute; top: -20%; left: 50%; transform: translateX(-50%);
            width: 80vw; height: 50vh;
            background: radial-gradient(ellipse, rgba(217, 119, 6, 0.15) 0%, transparent 70%);
            pointer-events: none; z-index: 0;
        }

        .gold-glow { text-shadow: 0 0 20px rgba(234, 179, 8, 0.5), 0 0 40px rgba(234, 179, 8, 0.2); }
        .timer-glow { text-shadow: 0 0 30px rgba(255, 255, 255, 0.15); }
        .timer-warning { color: #ef4444 !important; animation: heartbeat 1.2s infinite; }
        .timer-final-countdown {
            color: #ff1f1f !important;
            text-shadow: 0 0 50px rgba(255, 0, 0, 0.8), 0 0 100px rgba(255, 0, 0, 0.4) !important;
            animation: heartbeat-fast 1s infinite;
        }

        @keyframes heartbeat {
            0%, 30%, 60%, 100% { transform: scale(1); text-shadow: 0 0 30px rgba(239, 68, 68, 0.5); }
            15%, 45% { transform: scale(1.03); text-shadow: 0 0 60px rgba(239, 68, 68, 0.9); }
        }
        @keyframes heartbeat-fast {
            0%, 100% { transform: scale(1.1); text-shadow: 0 0 50px rgba(255, 0, 0, 0.8); }
            50% { transform: scale(1); text-shadow: 0 0 20px rgba(255, 0, 0, 0.4); }
        }
    </style>
</head>
<body class="flex flex-col justify-between items-center p-8 md:p-12 cursor-pointer relative">

    <div class="ambient-light"></div>

    <!-- HEADER LOGO / IDENTITAS ACARA -->
    <header class="text-center w-full max-w-6xl border-b border-amber-500/30 pb-6 relative z-10 pointer-events-none mt-2">
        
        <!-- TEMPAT LOGO AKHIRUSSANAH (.jpeg) DENGAN FRAME EMERALD -->
        <div class="flex justify-center mb-4">
            <img src="/images/logo-akhirussanah.png" alt="Logo Haflah" class="h-20 md:h-28 object-cover rounded-2xl border-2 border-emerald-500/30 shadow-[0_0_25px_rgba(52,211,153,0.15)]">
        </div>

        <p class="text-amber-400 tracking-[0.3em] md:tracking-[0.5em] text-xs md:text-sm uppercase font-black mb-3 drop-shadow-md flex items-center justify-center gap-4">
            <span class="w-12 h-[1px] bg-amber-500/50 hidden md:block"></span>
            ✨ HAFLAH AKHIRUSSANAH PONDOK PESANTREN ASSA'ADAH 2026 ✨
            <span class="w-12 h-[1px] bg-amber-500/50 hidden md:block"></span>
        </p>
        
        <!-- JUDUL DINAMIS (UMUM) -->
        <h1 class="text-4xl md:text-5xl font-serif font-black text-emerald-50 uppercase tracking-widest gold-glow">
            DAKWAH MUSTAWA
        </h1>
    </header>

    <!-- AREA UTAMA: NAMA & HITUNG MUNDUR -->
    <main class="w-full max-w-6xl text-center my-auto flex flex-col items-center justify-center gap-4 md:gap-8 relative z-10 pointer-events-none">
        
        <div class="bg-gradient-to-b from-emerald-950/60 to-black/80 border border-amber-500/40 rounded-3xl px-12 py-6 md:px-20 md:py-8 shadow-[0_0_60px_rgba(234,179,8,0.08)] backdrop-blur-md max-w-4xl min-w-[60%] transition-all duration-500 relative overflow-hidden">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-1/2 h-1 bg-gradient-to-r from-transparent via-amber-400 to-transparent"></div>
            
            <!-- LABEL UNIVERSAL -->
            <p class="text-xs md:text-sm text-amber-400/80 uppercase tracking-[0.4em] mb-3 font-sans font-bold">Peserta Sedang Tampil</p>
            <h2 id="display-nama" class="text-5xl md:text-6xl font-serif font-black text-amber-300 uppercase tracking-wide gold-glow italic leading-tight">
                - MENUNGGU PESERTA -
            </h2>
        </div>

        <!-- DISPLAY JAM DIGITAL RAKSASA -->
        <div class="relative mt-0">
            <div id="display-timer" class="font-mono font-black leading-none text-slate-50 tracking-tighter timer-glow transition-all duration-150 text-[9rem] md:text-[14rem]">
                00:00
            </div>
        </div>

    </main>

    <!-- FOOTER -->
    <footer class="w-full text-center pt-4 relative z-10 pointer-events-none opacity-50">
        <p class="text-emerald-400 font-sans text-[10px] md:text-xs tracking-[0.3em] uppercase font-bold">© Timer Universal • Ketuk Dua Kali Layar Untuk Fullscreen</p>
    </footer>

    <!-- LOGIKA JAVASCRIPT TIMER, AUDIO & WEBSOCKET -->
    <script>
        let waktuSisa = 0;
        let intervalTimer = null;

        const sndBeep = new Audio('/sounds/beep.mp3'); 
        const sndBuzzer = new Audio('/sounds/buzzer.mp3');
        sndBeep.volume = 0.7; 
        sndBuzzer.volume = 1.0;

        function formatWaktu(totalDetik) {
            let menit = Math.floor(totalDetik / 60);
            let detik = totalDetik % 60;
            return (menit < 10 ? '0' : '') + menit + ':' + (detik < 10 ? '0' : '') + detik;
        }

        function jalankanVisualTimer() {
            const timerEl = document.getElementById('display-timer');

            timerEl.classList.remove('timer-warning', 'timer-final-countdown', 'text-[9rem]', 'md:text-[14rem]', 'text-[22rem]', 'md:text-[30rem]');

            if (waktuSisa > 10) {
                timerEl.innerText = formatWaktu(waktuSisa);
                timerEl.classList.add('text-[9rem]', 'md:text-[14rem]');
                if (waktuSisa <= 120) {
                    timerEl.classList.add('timer-warning');
                }
            } 
            else if (waktuSisa > 0) {
                timerEl.innerText = waktuSisa; 
                timerEl.classList.add('text-[22rem]', 'md:text-[30rem]', 'timer-final-countdown'); 
                sndBeep.play().catch(e => console.log("Audio diblokir browser"));
            } 
            else {
                timerEl.innerText = "0";
                timerEl.classList.add('text-[22rem]', 'md:text-[30rem]', 'timer-final-countdown');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const lombaId = "{{ $lomba->id }}";

            window.Echo.channel('lomba.' + lombaId)
                .listen('.dakwah.updated', (data) => {
                    
                    if(data.namaPeserta) {
                        document.getElementById('display-nama').innerText = data.namaPeserta;
                    }

                    if (data.status === 'reset') {
                        clearInterval(intervalTimer);
                        waktuSisa = data.waktu;
                        jalankanVisualTimer();
                    } 
                    else if (data.status === 'start') {
                        clearInterval(intervalTimer);
                        if(waktuSisa <= 0) waktuSisa = data.waktu; 
                        if(waktuSisa === 0) { jalankanVisualTimer(); } 
                        
                        intervalTimer = setInterval(() => {
                            if (waktuSisa > 0) {
                                waktuSisa--;
                                jalankanVisualTimer();

                                if (waktuSisa === 0) {
                                    clearInterval(intervalTimer);
                                    sndBuzzer.play().catch(e => console.log("Audio diblokir browser"));
                                }
                            } else {
                                clearInterval(intervalTimer);
                            }
                        }, 1000);
                    } 
                    else if (data.status === 'pause') {
                        clearInterval(intervalTimer);
                    }
                    else if (data.status === 'sync') {
                        jalankanVisualTimer();
                    }
                });
        });

        function toggleFullScreen() {
            let elem = document.documentElement;
            if (!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) {
                if (elem.requestFullscreen) { elem.requestFullscreen(); }
                else if (elem.webkitRequestFullscreen) { elem.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT); }
            } else {
                if (document.exitFullscreen) { document.exitFullscreen(); }
            }
        }

        window.addEventListener('dblclick', function() {
            toggleFullScreen();
        });
    </script>
</body>
</html>