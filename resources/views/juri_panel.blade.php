<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Juri - {{ $lomba->nama_lomba }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans p-4 min-h-screen flex flex-col">

    <div class="max-w-md mx-auto w-full bg-white rounded-2xl shadow-lg overflow-hidden flex-1">
        <div class="bg-indigo-600 p-4 text-center text-white relative shadow-md z-10">
            <h2 class="font-black text-2xl uppercase tracking-wider">PANEL JURI</h2>
            <p class="text-indigo-200 text-sm font-semibold">{{ $lomba->nama_lomba }}</p>
            
            @if($lomba->nomor_soal > 0)
                <div class="mt-2 inline-block bg-indigo-800 text-yellow-300 font-bold px-3 py-1 rounded-full text-xs shadow-inner">
                    SOAL KE-{{ $lomba->nomor_soal }} / 10
                </div>
            @endif
        </div>

        <div class="p-4 bg-gray-50 h-full">

            @if($lomba->sesi_state == 'jawab_normal' && $lomba->timAktif)
                
                <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 p-3 rounded-lg text-center font-bold mb-4 text-sm shadow-sm">
                    🟢 SESI AMPLOP: Silakan nilai jawaban tim ini.
                </div>

                <div class="border-2 border-emerald-500 bg-white p-5 rounded-xl shadow-md">
                    <h3 class="font-black text-2xl text-gray-800 text-center uppercase mb-1">{{ $lomba->timAktif->nama_tim }}</h3>
                    <p class="text-xs text-gray-500 text-center mb-6 font-semibold">Ketua: {{ $lomba->timAktif->ketua }}</p>
                    
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <button onclick="kirimNilai(this, '{{ $lomba->tim_aktif_id }}', 100)" class="tombol-nilai bg-green-500 hover:bg-green-600 text-white font-black py-4 rounded-xl shadow active:scale-95 text-lg transition-transform">
                            BENAR<br><span class="text-2xl">+100</span>
                        </button>
                        <button onclick="kirimNilai(this, '{{ $lomba->tim_aktif_id }}', 0)" class="tombol-nilai bg-gray-500 hover:bg-gray-600 text-white font-black py-4 rounded-xl shadow active:scale-95 text-lg transition-transform">
                            SALAH<br><span class="text-2xl">0</span>
                        </button>
                    </div>

                    <div class="border-t pt-4 mt-2">
                        <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Input Nilai Custom (Jika Perlu):</label>
                        <div class="flex gap-2">
                            <input type="number" id="custom-nilai-{{ $lomba->tim_aktif_id }}" placeholder="Ketik angka..." class="w-full border-gray-300 rounded-lg font-bold text-center">
                            <button onclick="kirimNilaiCustom(this, '{{ $lomba->tim_aktif_id }}')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 rounded-lg shadow active:scale-95">
                                INPUT
                            </button>
                        </div>
                    </div>
                </div>

                @elseif($lomba->sesi_state == 'jawab_rebutan' && $lomba->timAktif)
                
                <div class="bg-blue-100 border border-blue-300 text-blue-800 p-3 rounded-lg text-center font-bold mb-4 text-sm shadow-sm animate-pulse">
                    🚨 SESI REBUTAN: Pertanyaan hangus jika salah!
                </div>

                <div class="border-4 border-blue-500 bg-white p-5 rounded-xl shadow-2xl transform scale-105">
                    <h3 class="font-black text-3xl text-gray-800 text-center uppercase mb-6">{{ $lomba->timAktif->nama_tim }}</h3>
                    
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <button onclick="kirimNilai(this, '{{ $lomba->tim_aktif_id }}', 100)" class="tombol-nilai bg-green-500 hover:bg-green-600 text-white font-black py-6 rounded-xl shadow-lg active:scale-95 transition-transform">
                            BENAR<br><span class="text-3xl">+100</span>
                        </button>
                        <button onclick="kirimNilai(this, '{{ $lomba->tim_aktif_id }}', -100)" class="tombol-nilai bg-red-600 hover:bg-red-700 text-white font-black py-6 rounded-xl shadow-lg active:scale-95 transition-transform">
                            SALAH<br><span class="text-3xl">-100</span>
                        </button>
                    </div>

                    <div class="border-t-2 border-dashed border-gray-200 pt-4 mt-2">
                        <label class="text-xs font-bold text-gray-500 uppercase mb-2 block text-center">Atau Input Nilai Custom (Gunakan tanda "-" untuk minus):</label>
                        <div class="flex gap-2">
                            <input type="number" id="custom-nilai-{{ $lomba->tim_aktif_id }}" placeholder="Contoh: 500 atau -700" class="w-full border-gray-300 rounded-lg font-bold text-center text-lg">
                            <button onclick="kirimNilaiCustom(this, '{{ $lomba->tim_aktif_id }}')" class="bg-blue-800 hover:bg-blue-900 text-white font-bold px-6 rounded-lg shadow active:scale-95">
                                INPUT
                            </button>
                        </div>
                    </div>
                </div>


            @elseif($lomba->sesi_state == 'jawab_lemparan' && $lomba->timLemparan)
                
                <div class="bg-purple-100 border border-purple-300 text-purple-800 p-3 rounded-lg text-center font-bold mb-4 text-sm shadow-sm animate-pulse">
                    🔥 SESI LEMPARAN: Anda bisa membagi nilai!
                </div>

                <div class="flex flex-col gap-4">
                    
                    <div class="border-2 border-purple-500 bg-white p-4 rounded-xl shadow-md relative overflow-hidden">
                        <div class="absolute top-0 right-0 bg-purple-500 text-white text-[10px] font-black px-2 py-1 rounded-bl-lg">TIM PEREBUT</div>
                        <h3 class="font-black text-xl text-gray-800 uppercase mb-3">{{ $lomba->timLemparan->nama_tim }}</h3>
                        
                        <div class="grid grid-cols-2 gap-2 mb-3">
                            <button onclick="kirimNilai(this, '{{ $lomba->tim_lemparan_id }}', 100)" class="tombol-nilai bg-green-500 text-white font-bold py-2 rounded-lg shadow active:scale-95">BENAR (+100)</button>
                            <button onclick="kirimNilai(this, '{{ $lomba->tim_lemparan_id }}', 0)" class="tombol-nilai bg-gray-500 text-white font-bold py-2 rounded-lg shadow active:scale-95">SALAH (0)</button>
                        </div>
                        <div class="flex gap-2">
                            <input type="number" id="custom-nilai-{{ $lomba->tim_lemparan_id }}" placeholder="Nilai custom..." class="w-full border-gray-300 rounded-lg text-sm text-center">
                            <button onclick="kirimNilaiCustom(this, '{{ $lomba->tim_lemparan_id }}')" class="bg-blue-600 text-white font-bold px-3 rounded-lg shadow active:scale-95 text-sm">INPUT</button>
                        </div>
                    </div>

                    <div class="border border-gray-300 bg-white p-4 rounded-xl shadow-sm relative">
                        <div class="absolute top-0 right-0 bg-gray-300 text-gray-700 text-[10px] font-black px-2 py-1 rounded-bl-lg">PEMILIK AMPLOP</div>
                        <h3 class="font-black text-lg text-gray-600 uppercase mb-3">{{ $lomba->timAktif?->nama_tim }}</h3>
                        
                        <div class="flex gap-2">
                            <input type="number" id="custom-nilai-{{ $lomba->tim_aktif_id }}" placeholder="Beri nilai sisa (custom)..." class="w-full border-gray-300 rounded-lg text-sm text-center">
                            <button onclick="kirimNilaiCustom(this, '{{ $lomba->tim_aktif_id }}')" class="bg-gray-700 text-white font-bold px-3 rounded-lg shadow active:scale-95 text-sm">INPUT</button>
                        </div>
                    </div>

                </div>


            @else
                <div class="flex flex-col items-center justify-center h-64 opacity-60">
                    <div class="w-16 h-16 border-4 border-indigo-400 border-t-transparent rounded-full animate-spin mb-4"></div>
                    <h3 class="font-bold text-xl text-gray-600">MENUNGGU...</h3>
                    <p class="text-sm text-gray-500 text-center mt-2 px-6">
                        @if($lomba->sesi_state == 'tunggu_bel_lemparan')
                            Menunggu tim menekan bel rebutan...
                        @else
                            Silakan perhatikan layar utama. Menunggu instruksi dari Operator.
                        @endif
                    </p>
                </div>
            @endif

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const lombaId = "{{ $lomba->id }}";

            // SANGAT SIMPEL: Jika ada perubahan state dari Operator, langsung refresh layar Juri!
            window.Echo.channel('lomba.' + lombaId)
                .listen('.state.diupdate', (e) => {
                    // Beri sedikit animasi loading sebelum refresh
                    document.body.style.opacity = '0.5';
                    setTimeout(() => window.location.reload(), 300);
                });
        });

        // Fungsi mengirim nilai dengan efek visual pada tombol
        function kirimNilai(tombol, timId, poin) {
            eksekusiNilai(tombol, timId, poin);
        }

        function kirimNilaiCustom(tombol, timId) {
            const poin = document.getElementById('custom-nilai-' + timId).value;
            if(poin === '') return alert('Masukkan angka terlebih dahulu!');
            eksekusiNilai(tombol, timId, poin);
        }

        function eksekusiNilai(tombol, timId, poin) {
            // Ubah tampilan tombol agar Juri tahu sedang diproses
            const teksAsli = tombol.innerHTML;
            tombol.innerHTML = "⏳...";
            tombol.disabled = true;
            tombol.classList.add('opacity-50');

            const url = `/juri/{{ $lomba->juri_token }}/nilai/${timId}`;
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ nilai: poin })
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    // Tampilkan notifikasi visual sukses (Ceklis)
                    tombol.innerHTML = "✅ TERSIMPAN";
                    tombol.classList.remove('bg-green-500', 'bg-gray-500', 'bg-blue-600');
                    tombol.classList.add('bg-emerald-700');
                    
                    // Kosongkan form input custom jika ada
                    const inputCustom = document.getElementById('custom-nilai-' + timId);
                    if(inputCustom) inputCustom.value = '';
                }
            })
            .catch(error => {
                alert('Terjadi kesalahan jaringan!');
                tombol.innerHTML = teksAsli;
                tombol.disabled = false;
                tombol.classList.remove('opacity-50');
            });
        }
    </script>
</body>
</html>