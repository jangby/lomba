<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KLASEMEN: {{ $lomba->nama_lomba }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background: radial-gradient(circle at 50% 0%, #065f46, #022c22); color: white; min-height: 100vh; overflow: hidden; font-family: 'Segoe UI', sans-serif; }
        #papan-skor { position: relative; width: 100%; }
        .kartu-wrapper { position: absolute; width: 100%; transition: transform 1.5s ease-in-out; will-change: transform; }
        .kartu-inner { transition: border-color 0.5s, background-color 0.5s; }
        
        @keyframes kedipPoin { 
            0% { transform: scale(1); background-color: #064e3b; } 
            50% { transform: scale(1.02); background-color: #059669; box-shadow: 0 0 30px rgba(52, 211, 153, 0.8); z-index: 50; } 
            100% { transform: scale(1); background-color: #064e3b; z-index: 1;} 
        }
        .poin-masuk .kartu-inner { animation: kedipPoin 1s ease-out; }
    </style>
</head>
<body class="flex flex-col p-8">

    <header class="text-center mb-12 relative z-10">
        <div class="inline-block border-b-4 border-yellow-500 pb-4 px-12">
            <h1 class="text-4xl md:text-6xl font-black tracking-widest text-emerald-100 uppercase drop-shadow-[0_0_15px_rgba(52,211,153,0.5)]">
                {{ $lomba->nama_lomba }}
            </h1>
            <p class="text-xl text-yellow-400 mt-2 tracking-[0.4em] uppercase font-bold drop-shadow-md">
                PAPAN SKOR UTAMA
            </p>
        </div>
    </header>

    <main class="w-full max-w-4xl mx-auto flex-1 relative z-10">
        <div id="papan-skor">
            @foreach ($lomba->tims as $tim)
                <div id="card-tim-{{ $tim->id }}" class="kartu-wrapper" data-id="{{ $tim->id }}" data-skor="{{ $tim->skor }}">
                    <div class="kartu-inner bg-emerald-900 border-2 border-emerald-700 rounded-2xl p-6 flex justify-between items-center shadow-[0_10px_20px_rgba(0,0,0,0.3)] backdrop-blur-sm bg-opacity-90">
                        <div class="flex items-center gap-6">
                            <div class="rank-badge text-4xl font-black text-yellow-500 w-16 text-center drop-shadow-md"></div>
                            <div>
                                <h3 class="text-3xl font-bold text-white tracking-wide uppercase">{{ $tim->nama_tim }}</h3>
                                <p class="text-md text-emerald-300 font-medium">Ketua: {{ $tim->ketua }}</p>
                            </div>
                        </div>
                        <div class="skor-teks text-7xl font-black text-yellow-400 drop-shadow-[0_0_15px_rgba(250,204,21,0.6)]">{{ $tim->skor }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const lombaId = "{{ $lomba->id }}";

            // LOGIKA SORTING MELAYANG
            const gap = 130; 
            const papanSkor = document.getElementById('papan-skor');
            const cards = Array.from(document.querySelectorAll('.kartu-wrapper'));
            if(papanSkor) papanSkor.style.height = (cards.length * gap) + 'px';

            function urutkanDanRender() {
                if(cards.length === 0) return;
                cards.sort((a, b) => {
                    let skorA = parseInt(a.getAttribute('data-skor')); let skorB = parseInt(b.getAttribute('data-skor'));
                    return skorB === skorA ? parseInt(a.getAttribute('data-id')) - parseInt(b.getAttribute('data-id')) : skorB - skorA; 
                });
                cards.forEach((card, index) => {
                    card.style.transform = `translateY(${index * gap}px)`;
                    card.querySelector('.rank-badge').innerText = '#' + (index + 1);
                    const innerCard = card.querySelector('.kartu-inner');
                    
                    if(index === 0) {
                        innerCard.classList.add('border-yellow-400', 'bg-emerald-800'); innerCard.classList.remove('border-emerald-700', 'bg-emerald-900');
                        card.querySelector('.rank-badge').classList.add('text-yellow-300'); card.querySelector('.rank-badge').classList.remove('text-gray-400');
                    } else {
                        innerCard.classList.remove('border-yellow-400', 'bg-emerald-800'); innerCard.classList.add('border-emerald-700', 'bg-emerald-900');
                        card.querySelector('.rank-badge').classList.remove('text-yellow-300'); card.querySelector('.rank-badge').classList.add('text-gray-400');
                    }
                });
            }
            urutkanDanRender();

            // MENDENGARKAN SINYAL UPDATE SKOR DARI OPERATOR
            window.Echo.channel('lomba.' + lombaId)
                .listen('.skor.diupdate', (e) => {
                    const cardTim = document.getElementById('card-tim-' + e.timId);
                    if (cardTim) {
                        cardTim.querySelector('.skor-teks').innerText = e.skorBaru;
                        cardTim.setAttribute('data-skor', e.skorBaru);
                        
                        // Efek kedip hijau saat skor berubah
                        cardTim.classList.remove('poin-masuk');
                        void cardTim.offsetWidth; 
                        cardTim.classList.add('poin-masuk');
                        
                        urutkanDanRender(); // Otomatis bertukar posisi jika menyalip
                    }
                });
        });
    </script>
</body>
</html>