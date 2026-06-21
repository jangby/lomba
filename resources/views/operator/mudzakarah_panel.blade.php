<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-xl text-amber-800 uppercase tracking-wide truncate">
                📖 Remote Mudzakarah
            </h2>
            <a href="{{ route('dashboard') }}" class="p-2 bg-gray-100 rounded-lg text-gray-600 active:bg-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
        </div>
    </x-slot>

    <div class="py-4 bg-gray-100 min-h-screen">
        <div class="max-w-md mx-auto px-4">

            <div class="bg-white rounded-3xl shadow-md border border-amber-100 p-5 mb-5 flex flex-col gap-4">
                <div>
                    <label class="text-[11px] font-black text-amber-600 uppercase tracking-wider block mb-1">Nama Pembaca Kitab</label>
                    <select id="select-peserta" onchange="document.getElementById('nama_peserta').value = this.value; kirimUpdate('sync')" class="w-full rounded-xl border-amber-200 font-bold text-gray-700 text-sm mb-2 bg-amber-50">
                        <option value="">-- Pilih Peserta --</option>
                        @foreach($lomba->tims as $tim)
                            <option value="{{ $tim->nama_tim }} ({{ $tim->ketua }})">{{ $tim->nama_tim }} - {{ $tim->ketua }}</option>
                        @endforeach
                    </select>
                    <input type="text" id="nama_peserta" placeholder="Ketik nama manual..." class="w-full rounded-xl border-amber-200 font-bold text-gray-800 p-3 text-sm focus:ring-amber-500 bg-white">
                </div>
                <button onclick="kirimUpdate('sync')" class="touch-manipulation bg-amber-600 active:bg-amber-700 text-white font-black py-3 rounded-xl shadow-md text-xs uppercase tracking-widest w-full">
                    📖 Update Nama di Layar
                </button>
            </div>

            <div class="bg-white rounded-3xl shadow-md border border-amber-100 p-5 mb-5 flex flex-col gap-4">
                <div>
                    <label class="text-[11px] font-black text-amber-600 uppercase tracking-wider block mb-1">Set Durasi Mudzakarah</label>
                    <div class="grid grid-cols-3 gap-2 mb-3">
                        <button onclick="setMenit(5)" class="touch-manipulation bg-amber-50 active:bg-amber-100 border border-amber-200 text-amber-900 font-bold py-2 rounded-xl text-sm">5 Mnt</button>
                        <button onclick="setMenit(10)" class="touch-manipulation bg-amber-50 active:bg-amber-100 border border-amber-200 text-amber-900 font-bold py-2 rounded-xl text-sm">10 Mnt</button>
                        <button onclick="setMenit(15)" class="touch-manipulation bg-amber-50 active:bg-amber-100 border border-amber-200 text-amber-900 font-bold py-2 rounded-xl text-sm">15 Mnt</button>
                    </div>
                    <input type="number" inputmode="numeric" id="durasi_menit" value="10" class="w-full rounded-xl border-amber-300 font-black text-center text-xl p-3 shadow-inner text-amber-900">
                </div>

                <div class="grid grid-cols-2 gap-3 mt-2">
                    <button onclick="kirimUpdate('start')" class="touch-manipulation col-span-2 bg-emerald-600 hover:bg-emerald-700 text-white font-black py-4 rounded-2xl shadow-[0_4px_0_rgb(5,150,105)] active:translate-y-1 active:shadow-[0_0px_0_rgb(5,150,105)] text-xl tracking-wider uppercase">
                        ▶️ MULAI WAKTU
                    </button>
                    <button onclick="kirimUpdate('pause')" class="touch-manipulation bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl shadow-[0_4px_0_rgb(37,99,235)] active:translate-y-1 active:shadow-[0_0px_0_rgb(37,99,235)] text-md tracking-wider uppercase">
                        ⏸️ PAUSE
                    </button>
                    <button onclick="kirimUpdate('reset')" class="touch-manipulation bg-rose-600 hover:bg-rose-700 text-white font-black py-4 rounded-2xl shadow-[0_4px_0_rgb(153,27,27)] active:translate-y-1 active:shadow-[0_0px_0_rgb(153,27,27)] text-md tracking-wider uppercase">
                        ⏹️ RESET
                    </button>
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('lomba.mudzakarahDisplay', $lomba->id) }}" target="_blank" class="text-xs font-bold text-amber-600 underline">Buka Layar TV Mudzakarah &rarr;</a>
            </div>
        </div>
    </div>

    <script>
        function setMenit(menit) {
            document.getElementById('durasi_menit').value = menit;
            kirimUpdate('reset');
        }

        function kirimUpdate(statusAksi) {
            const menit = document.getElementById('durasi_menit').value || 0;
            fetch("{{ route('lomba.mudzakarahSync', $lomba->id) }}", {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    status: statusAksi,
                    waktu: parseInt(menit) * 60,
                    nama_peserta: document.getElementById('nama_peserta').value
                })
            }).catch(err => alert('Koneksi bermasalah!'));
        }
    </script>
</x-app-layout>