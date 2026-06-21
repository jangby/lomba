<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-xl md:text-2xl text-gray-800 leading-tight uppercase tracking-wide truncate">
                🎛️ Remote: <span class="text-indigo-600">{{ $lomba->nama_lomba }}</span>
            </h2>
            <a href="{{ route('dashboard') }}" class="p-2 bg-gray-100 rounded-lg text-gray-600 hover:text-indigo-600 active:bg-gray-200 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
        </div>
    </x-slot>

    <!-- Hapus padding besar di mobile (py-8 jadi py-4) -->
    <div class="py-4 md:py-8 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex items-center justify-center mb-6">
                <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-4 py-1.5 rounded-full border border-indigo-200 uppercase tracking-widest flex items-center gap-2 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                    Sistem Online
                </span>
            </div>

            <!-- GRID KARTU TIM (1 Kolom di HP, 2-3 di Desktop) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($lomba->tims as $tim)
                    <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden flex flex-col justify-between transform transition duration-200">
                        
                        <!-- Header Tim -->
                        <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-5 py-3 flex items-center justify-between shadow-inner">
                            <h4 class="font-black text-lg text-white uppercase tracking-wider truncate pr-2">
                                {{ $tim->nama_tim }}
                            </h4>
                            <span class="text-[10px] bg-gray-700 text-gray-200 font-bold px-2 py-1 rounded border border-gray-600 uppercase truncate max-w-[100px]">
                                {{ $tim->ketua }}
                            </span>
                        </div>

                        <!-- Layar Skor -->
                        <div class="py-6 bg-gradient-to-b from-indigo-50 to-white text-center border-b border-gray-100 relative">
                            <span id="skor-op-{{ $tim->id }}" class="text-[5.5rem] leading-none font-black text-gray-900 tracking-tighter drop-shadow-sm font-mono transition-opacity duration-200 block">
                                {{ $tim->skor }}
                            </span>
                        </div>

                        <!-- Area Kontrol (Dioptimalkan untuk Jempol) -->
                        <div class="p-4 flex flex-col gap-5 bg-white">
                            
                            <!-- 1. Tombol Tindakan Cepat (Grid 2x2 agar tombol besar di HP) -->
                            <div>
                                <div class="grid grid-cols-2 gap-3">
                                    <button onclick="tambahNilai('{{ $tim->id }}', 100)" class="touch-manipulation bg-emerald-500 hover:bg-emerald-600 text-white font-black py-4 rounded-2xl shadow-[0_4px_0_rgb(5,150,105)] active:translate-y-1 active:shadow-[0_0px_0_rgb(5,150,105)] transition-all text-2xl flex items-center justify-center gap-1">
                                        +100
                                    </button>
                                    <button onclick="tambahNilai('{{ $tim->id }}', 50)" class="touch-manipulation bg-emerald-400 hover:bg-emerald-500 text-white font-black py-4 rounded-2xl shadow-[0_4px_0_rgb(16,185,129)] active:translate-y-1 active:shadow-[0_0px_0_rgb(16,185,129)] transition-all text-xl flex items-center justify-center gap-1">
                                        +50
                                    </button>
                                    <button onclick="tambahNilai('{{ $tim->id }}', -50)" class="touch-manipulation bg-rose-400 hover:bg-rose-500 text-white font-black py-4 rounded-2xl shadow-[0_4px_0_rgb(225,29,72)] active:translate-y-1 active:shadow-[0_0px_0_rgb(225,29,72)] transition-all text-xl flex items-center justify-center gap-1">
                                        -50
                                    </button>
                                    <button onclick="tambahNilai('{{ $tim->id }}', -100)" class="touch-manipulation bg-rose-500 hover:bg-rose-600 text-white font-black py-4 rounded-2xl shadow-[0_4px_0_rgb(190,18,60)] active:translate-y-1 active:shadow-[0_0px_0_rgb(190,18,60)] transition-all text-2xl flex items-center justify-center gap-1">
                                        -100
                                    </button>
                                </div>
                            </div>

                            <!-- 2. Input Tambah/Kurang Custom -->
                            <div class="bg-gray-50 p-3 rounded-2xl border border-gray-200">
                                <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2 block">Custom Poin (+/-)</label>
                                <div class="flex gap-2">
                                    <!-- Atribut inputmode="numeric" akan memunculkan keyboard angka di HP -->
                                    <input type="number" inputmode="numeric" id="tambah-nilai-{{ $tim->id }}" placeholder="Cth: 200 atau -150" class="w-full rounded-xl border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 px-4 py-3 text-center font-black text-gray-700 text-lg shadow-inner">
                                    <button onclick="tambahNilaiCustom('{{ $tim->id }}')" class="touch-manipulation bg-indigo-600 hover:bg-indigo-700 text-white font-black px-6 rounded-xl shadow-md active:scale-95 transition-all uppercase tracking-wider text-sm">
                                        GO
                                    </button>
                                </div>
                            </div>

                            <!-- 3. Edit / Timpa Nilai Mutlak -->
                            <div class="bg-amber-50 p-3 rounded-2xl border border-amber-200">
                                <label class="text-[10px] font-bold text-amber-700 uppercase tracking-wider mb-2 block flex items-center gap-1">
                                    ⚠️ Koreksi / Timpa Total
                                </label>
                                <div class="flex gap-2">
                                    <input type="number" inputmode="numeric" id="edit-nilai-{{ $tim->id }}" placeholder="Angka mutlak..." class="w-full rounded-xl border-amber-300 focus:ring-amber-500 focus:border-amber-500 px-4 py-3 text-center font-black text-amber-900 bg-white text-lg shadow-inner">
                                    <button onclick="editNilai('{{ $tim->id }}')" class="touch-manipulation bg-amber-500 hover:bg-amber-600 text-white font-black px-4 rounded-xl shadow-md active:scale-95 transition-all uppercase tracking-wider text-sm">
                                        UBAH
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            <!-- DANGER ZONE: TOMBOL RESET (Margin dikurangi sedikit untuk layar HP) -->
            <div class="mt-12 mb-8 pt-8 border-t border-gray-300 flex flex-col items-center justify-center">
                <div class="bg-red-50 border-2 border-red-200 rounded-3xl p-5 md:p-6 w-full max-w-md text-center shadow-sm">
                    <h4 class="text-sm font-black text-red-800 uppercase tracking-widest mb-1">Zona Berbahaya</h4>
                    <p class="text-xs text-red-600 font-bold mb-4">Mereset semua nilai kembali menjadi 0.</p>
                    <button onclick="resetSemuaNilai()" class="touch-manipulation w-full bg-red-600 hover:bg-red-700 text-white font-black py-4 rounded-2xl shadow-[0_4px_0_rgb(153,27,27)] active:translate-y-1 active:shadow-[0_0px_0_rgb(153,27,27)] transition-all tracking-widest text-lg uppercase">
                        🚨 RESET SEMUA 🚨
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- SCRIPT AJAX -->
    <script>
        function tambahNilai(timId, poin) {
            const url = "{{ route('lomba.updateSkor', [$lomba->id, ':timId']) }}".replace(':timId', timId);
            eksekusiAjax(url, poin, timId);
        }

        function tambahNilaiCustom(timId) {
            const inputField = document.getElementById('tambah-nilai-' + timId);
            const poin = inputField.value;
            if(!poin) return alert('Silakan masukkan angka poin terlebih dahulu!');
            
            const url = "{{ route('lomba.updateSkor', [$lomba->id, ':timId']) }}".replace(':timId', timId);
            eksekusiAjax(url, parseInt(poin), timId);
            inputField.value = '';
        }

        function editNilai(timId) {
            const inputField = document.getElementById('edit-nilai-' + timId);
            const poin = inputField.value;
            if(!poin) return alert('Silakan masukkan angka nilai baru terlebih dahulu!');
            
            if(!confirm('KOREKSI TOTAL: Anda yakin ingin MENGGANTI nilai tim ini secara mutlak menjadi ' + poin + ' Poin?')) return;

            const url = "{{ route('lomba.setSkor', [$lomba->id, ':timId']) }}".replace(':timId', timId);
            eksekusiAjax(url, parseInt(poin), timId);
            inputField.value = '';
        }

        function eksekusiAjax(url, poin, timId) {
            // Efek visual Loading/Proses
            const skorText = document.getElementById('skor-op-' + timId);
            skorText.classList.add('opacity-30', 'scale-95');

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
                    skorText.innerText = data.skor_baru;
                }
            })
            .catch(error => alert('Terjadi masalah koneksi jaringan!'))
            .finally(() => {
                setTimeout(() => {
                    skorText.classList.remove('opacity-30', 'scale-95');
                }, 150);
            });
        }

        function resetSemuaNilai() {
            if(!confirm('PERINGATAN!\n\nApakah Anda yakin ingin menghapus semua nilai dari seluruh regu kembali menjadi 0?\nTindakan ini tidak bisa di-undo.')) return;
            
            fetch("{{ route('lomba.resetSkor', $lomba->id) }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    window.location.reload(); 
                }
            })
            .catch(error => alert('Gagal mereset skor. Periksa koneksi internet!'));
        }
    </script>
</x-app-layout>