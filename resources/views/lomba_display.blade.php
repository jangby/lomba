<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DISPLAY LOMBA - {{ $lomba->nama_lomba }}</title>
    
    <!-- Memanggil Tailwind & Laravel Echo (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Animasi kedip saat nilai berubah */
        @keyframes pop {
            0% { transform: scale(1); color: #fff; }
            50% { transform: scale(1.3); color: #4ade80; text-shadow: 0 0 20px #4ade80; }
            100% { transform: scale(1); color: #fff; }
        }
        .skor-update {
            animation: pop 0.6s ease-out;
        }
    </style>
</head>
<body class="bg-slate-900 text-white h-screen w-screen overflow-hidden flex flex-col font-sans selection:bg-indigo-500 relative selection:text-white transition-all duration-300" id="board-container">

    <!-- TOMBOL FULLSCREEN MELAYANG -->
    <button onclick="toggleFullScreen()" id="btn-fullscreen" class="absolute top-4 right-4 z-50 bg-white/10 hover:bg-white/20 text-white/50 hover:text-white border border-white/10 p-3 rounded-full backdrop-blur-sm transition-all duration-300 opacity-30 hover:opacity-100 group shadow-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
        </svg>
        <span class="absolute right-full mr-3 top-1/2 -translate-y-1/2 bg-black/80 text-xs font-bold px-3 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
            Masuk / Keluar Fullscreen
        </span>
    </button>

    <!-- HEADER SMART BOARD -->
    <header class="py-8 text-center border-b border-slate-800 bg-slate-900/50 shadow-2xl relative z-10">
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/20 via-purple-500/20 to-pink-500/20 blur-xl opacity-50"></div>
        <h1 class="relative text-4xl md:text-5xl font-black uppercase tracking-[0.2em] text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 drop-shadow-sm">
            {{ $lomba->nama_lomba }}
        </h1>
        <div class="relative mt-3 flex items-center justify-center gap-2">
            <span class="flex h-3 w-3 relative">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
            </span>
            <span class="text-slate-400 font-bold tracking-widest text-sm uppercase">Live System Connected</span>
        </div>
    </header>

    <!-- AREA SKOR UTAMA -->
    <main class="flex-1 p-8 flex items-center justify-center bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-slate-800 via-slate-900 to-black">
        <div class="w-full max-w-7xl grid grid-cols-1 md:grid-cols-{{ min($lomba->tims->count(), 4) }} gap-6 md:gap-10">
            
            @foreach ($lomba->tims as $tim)
                <div class="bg-slate-800/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-8 flex flex-col items-center justify-center shadow-[0_0_50px_-12px_rgba(0,0,0,0.5)] transform transition hover:scale-105 duration-300 group">
                    
                    <!-- Nama Tim -->
                    <h2 class="text-2xl md:text-3xl font-black text-slate-300 uppercase tracking-widest text-center mb-2 group-hover:text-indigo-300 transition-colors">
                        {{ $tim->nama_tim }}
                    </h2>
                    
                    <!-- Garis Pemisah Estetik -->
                    <div class="w-16 h-1.5 bg-gradient-to-r from-transparent via-indigo-500 to-transparent rounded-full mb-8 opacity-50 group-hover:opacity-100 transition-opacity"></div>
                    
                    <!-- Skor Angka Besar -->
                    <div class="relative">
                        <div class="absolute inset-0 bg-indigo-500/20 blur-3xl rounded-full"></div>
                        <span id="skor-{{ $tim->id }}" class="relative text-7xl md:text-[8rem] leading-none font-black text-white font-mono drop-shadow-[0_0_15px_rgba(255,255,255,0.2)]">
                            {{ $tim->skor }}
                        </span>
                    </div>

                </div>
            @endforeach

        </div>
    </main>

    <!-- JAVASCRIPT: FULLSCREEN & WEBSOCKET -->
    <script>
        // --- 1. FITUR FULLSCREEN OTOMATIS/MANUAL ---
        function toggleFullScreen() {
            var doc = window.document;
            var docEl = doc.documentElement;

            var requestFullScreen = docEl.requestFullscreen || docEl.mozRequestFullScreen || docEl.webkitRequestFullScreen || docEl.msRequestFullscreen;
            var cancelFullScreen = doc.exitFullscreen || doc.mozCancelFullScreen || doc.webkitExitFullscreen || doc.msExitFullscreen;

            if(!doc.fullscreenElement && !doc.mozFullScreenElement && !doc.webkitFullscreenElement && !doc.msFullscreenElement) {
                // Masuk Fullscreen
                requestFullScreen.call(docEl).catch(err => {
                    console.log(`Error attempting to enable fullscreen: ${err.message}`);
                });
            } else {
                // Keluar Fullscreen
                cancelFullScreen.call(doc);
            }
        }

        // Trik Opsional: Double-click dimanapun di layar untuk Fullscreen
        document.addEventListener('dblclick', function() {
            toggleFullScreen();
        });

        // --- 2. FITUR WEBSOCKET (LARAVEL ECHO REAL-TIME) ---
        // Menunggu sampai Echo berhasil dimuat oleh Vite
        document.addEventListener('DOMContentLoaded', () => {
            if (window.Echo) {
                window.Echo.channel(`lomba.{{ $lomba->id }}`)
                    .listen('SkorDiupdate', (e) => {
                        
                        // Tangkap elemen skor yang harus diupdate
                        const elemenSkor = document.getElementById('skor-' + e.tim_id);
                        
                        if(elemenSkor) {
                            // Update angkanya
                            elemenSkor.innerText = e.skor;
                            
                            // Hapus animasi lama (jika ada) lalu jalankan ulang agar kedip
                            elemenSkor.classList.remove('skor-update');
                            void elemenSkor.offsetWidth; // Trigger reflow (Trik rahasia CSS)
                            elemenSkor.classList.add('skor-update');
                        }
                    });
            } else {
                console.error("Laravel Echo belum dimuat! Pastikan npm run build sudah dijalankan.");
            }
        });
    </script>

</body>
</html>