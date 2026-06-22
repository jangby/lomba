<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-black text-2xl text-gray-800 leading-tight uppercase tracking-wide">
                🖥️ Dashboard Operator
            </h2>
            <p class="text-sm text-gray-500 mt-1">Kelola sesi Cerdas Cermat dan Lomba Dakwah Anda dari satu pusat kendali.</p>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r-2xl shadow-sm flex items-center">
                    <span class="text-xl mr-3">✅</span>
                    <p class="font-semibold text-sm">{{ session('success') }}</p>
                </div>
            @endif

            <!-- ======================================================== -->
            <!-- PANEL KONTROL VIDEO BUMPER GLOBAL -->
            <!-- ======================================================== -->
            <div class="mb-8 bg-slate-900 rounded-3xl shadow-[0_10px_30px_rgba(0,0,0,0.2)] border border-slate-800 p-6 flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/10 via-purple-500/10 to-transparent"></div>
                <div class="relative z-10">
                    <h3 class="font-black text-xl text-white uppercase tracking-wider flex items-center gap-2">
                        <span>🎬</span> Master Kontrol Layar Jeda
                    </h3>
                    <p class="text-slate-400 text-xs mt-1 font-medium">Nyalakan untuk mengambil alih semua TV display dan memutar video bumper berulang kali.</p>
                </div>
                <div class="flex gap-3 w-full md:w-auto relative z-10">
                    <!-- Tombol ON -->
                    <button onclick="kontrolBumper('on')" class="flex-1 md:flex-none bg-emerald-500 hover:bg-emerald-600 text-white font-black py-3 px-6 rounded-xl shadow-[0_4px_0_rgb(4,120,87)] active:translate-y-1 active:shadow-[0_0px_0_rgb(4,120,87)] transition-all flex items-center justify-center gap-2 text-sm">
                        <span class="animate-pulse">▶️</span> PUTAR VIDEO
                    </button>
                    <!-- Tombol OFF -->
                    <button onclick="kontrolBumper('off')" class="flex-1 md:flex-none bg-rose-600 hover:bg-rose-700 text-white font-black py-3 px-6 rounded-xl shadow-[0_4px_0_rgb(159,18,57)] active:translate-y-1 active:shadow-[0_0px_0_rgb(159,18,57)] transition-all flex items-center justify-center gap-2 text-sm">
                        ⏹️ MATIKAN
                    </button>
                </div>
            </div>

            <!-- SCRIPT FETCH UNTUK TOMBOL BUMPER -->
            <script>
                function kontrolBumper(statusAksi) {
                    fetch("{{ route('bumper.sync') }}", {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
                        body: JSON.stringify({ status: statusAksi })
                    }).catch(err => alert('Koneksi ke server bermasalah!'));
                }
            </script>
            <!-- ======================================================== -->


            <!-- GRID UTAMA -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sticky top-8">
                    <div class="border-b border-gray-100 pb-4 mb-5">
                        <h3 class="font-extrabold text-lg text-gray-800 flex items-center gap-2">
                            <span>✨</span> Buat Sesi Baru
                        </h3>
                        <p class="text-xs text-gray-400 mt-0.5">Tambahkan wadah kompetisi baru.</p>
                    </div>

                    <form action="{{ route('lomba.store') }}" method="POST" class="flex flex-col gap-4">
                        @csrf
                        <div>
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1.5">Nama Sesi Perlombaan</label>
                            <input type="text" name="nama_lomba" placeholder="Contoh: Penyisihan Grup A / Dakwah Sesi 1" required 
                                class="w-full rounded-xl border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50 focus:bg-white transition text-sm font-semibold p-3">
                        </div>
                        
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-bold shadow-md transition active:scale-[0.98] tracking-wide text-sm flex items-center justify-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Buat Sesi Sekarang
                        </button>
                    </form>
                </div>

                <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-5 mb-6">
                        <div>
                            <h3 class="text-xl font-black text-gray-800 uppercase tracking-tight">Daftar Perlombaan</h3>
                            <p class="text-xs text-gray-400 font-medium">Kumpulan sesi yang siap dijalankan.</p>
                        </div>
                        <span class="bg-indigo-50 text-indigo-700 text-xs font-bold px-3 py-1.5 rounded-full border border-indigo-100">
                            {{ $lombas->count() }} Total Sesi
                        </span>
                    </div>

                    <div class="flex flex-col gap-6">
                        @forelse ($lombas as $lomba)
                            <div class="border border-gray-200 hover:border-indigo-300 bg-white p-5 rounded-3xl shadow-sm transition-all duration-300 group">
                                
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-5 border-b border-gray-100 pb-4">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-extrabold text-gray-900 text-xl tracking-tight truncate">
                                            {{ $lomba->nama_lomba }}
                                        </h4>
                                        <p class="text-xs text-gray-400 font-medium mt-1 flex items-center gap-1">
                                            <span>📅 Dibuat {{ $lomba->created_at->diffForHumans() }}</span>
                                            <span class="mx-2">•</span>
                                            <span>👥 {{ $lomba->tims ? $lomba->tims->count() : 0 }} Peserta/Tim Terdaftar</span>
                                        </p>
                                    </div>
                                    
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('lomba.show', $lomba->id) }}" class="flex items-center justify-center py-2 px-4 rounded-xl border border-gray-300 hover:bg-gray-100 text-gray-700 text-xs font-bold shadow-sm transition active:scale-95">
                                            👥 Atur Peserta
                                        </a>

                                        <form action="{{ route('lomba.destroy', $lomba->id) }}" method="POST" onsubmit="return confirm('PERINGATAN!\n\nAnda yakin ingin menghapus Sesi ini secara permanen?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="flex items-center justify-center p-2 rounded-xl border border-red-200 bg-red-50 text-red-600 hover:bg-red-100 shadow-sm transition active:scale-95" title="Hapus Sesi">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    
                                    <div class="bg-indigo-50/50 rounded-xl border border-indigo-100 p-3">
                                        <h5 class="text-[9px] font-black text-indigo-500 uppercase tracking-widest mb-2 flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span> Cerdas Cermat
                                        </h5>
                                        <div class="flex flex-col xl:flex-row gap-1.5">
                                            <a href="{{ route('lomba.display', $lomba->id) }}" target="_blank" class="flex-1 bg-white border border-indigo-200 text-indigo-700 font-bold py-1.5 rounded-lg text-[10px] text-center hover:bg-indigo-50 transition">📺 TV</a>
                                            <a href="{{ route('lomba.panel', $lomba->id) }}" class="flex-1 bg-indigo-600 text-white font-bold py-1.5 rounded-lg text-[10px] text-center hover:bg-indigo-700 transition">🎛️ Remote</a>
                                        </div>
                                    </div>

                                    <div class="bg-emerald-50/50 rounded-xl border border-emerald-100 p-3">
                                        <h5 class="text-[9px] font-black text-emerald-600 uppercase tracking-widest mb-2 flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Dakwah
                                        </h5>
                                        <div class="flex flex-col xl:flex-row gap-1.5">
                                            <a href="{{ route('lomba.dakwahDisplay', $lomba->id) }}" target="_blank" class="flex-1 bg-white border border-emerald-200 text-emerald-700 font-bold py-1.5 rounded-lg text-[10px] text-center hover:bg-emerald-50 transition">📺 TV</a>
                                            <a href="{{ route('lomba.dakwahPanel', $lomba->id) }}" class="flex-1 bg-emerald-600 text-white font-bold py-1.5 rounded-lg text-[10px] text-center hover:bg-emerald-700 transition">🎤 Remote</a>
                                        </div>
                                    </div>

                                    <div class="bg-amber-50/50 rounded-xl border border-amber-100 p-3">
                                        <h5 class="text-[9px] font-black text-amber-600 uppercase tracking-widest mb-2 flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Mudzakarah
                                        </h5>
                                        <div class="flex flex-col xl:flex-row gap-1.5">
                                            <a href="{{ route('lomba.mudzakarahDisplay', $lomba->id) }}" target="_blank" class="flex-1 bg-white border border-amber-200 text-amber-700 font-bold py-1.5 rounded-lg text-[10px] text-center hover:bg-amber-50 transition">📺 TV</a>
                                            <a href="{{ route('lomba.mudzakarahPanel', $lomba->id) }}" class="flex-1 bg-amber-600 text-white font-bold py-1.5 rounded-lg text-[10px] text-center hover:bg-amber-700 transition">📖 Remote</a>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        @empty
                            <div class="py-16 flex flex-col items-center justify-center text-gray-400 bg-gray-50 rounded-3xl border border-dashed border-gray-300">
                                <span class="text-5xl mb-3">🏁</span>
                                <h5 class="font-bold text-gray-700 text-base">Belum Ada Sesi</h5>
                                <p class="text-xs text-gray-400 mt-1 max-w-xs text-center">Silakan ketik nama acara di form sebelah kiri untuk memulai.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
            
        </div>
    </div>
</x-app-layout>