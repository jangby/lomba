<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-black text-2xl text-gray-800 leading-tight uppercase tracking-wide">
                🖥️ Dashboard Operator
            </h2>
            <p class="text-sm text-gray-500 mt-1">Selamat datang. Silakan pilih atau buat perlombaan baru untuk memulai.</p>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Notifikasi Flash Message -->
            @if (session('success'))
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r-2xl shadow-sm flex items-center">
                    <span class="text-xl mr-3">✅</span>
                    <p class="font-semibold text-sm">{{ session('success') }}</p>
                </div>
            @endif

            <!-- GRID UTAMA -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                <!-- LAYOUT KIRI: FORM BUAT LOMBA BARU -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sticky top-8">
                    <div class="border-b border-gray-100 pb-4 mb-5">
                        <h3 class="font-extrabold text-lg text-gray-800 flex items-center gap-2">
                            <span>✨</span> Buat Lomba Baru
                        </h3>
                        <p class="text-xs text-gray-400 mt-0.5">Tambahkan sesi kompetisi cerdas cermat baru.</p>
                    </div>

                    <form action="{{ route('lomba.store') }}" method="POST" class="flex flex-col gap-4">
                        @csrf
                        <div>
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1.5">Nama Perlombaan</label>
                            <input type="text" name="nama_lomba" placeholder="Contoh: LCC Babak Penyisihan Grup A" required 
                                class="w-full rounded-xl border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50 focus:bg-white transition text-sm font-semibold p-3">
                        </div>
                        
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-bold shadow-md transition active:scale-[0.98] tracking-wide text-sm flex items-center justify-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Buat Sesi Lomba
                        </button>
                    </form>
                </div>

                <!-- LAYOUT KANAN: DAFTAR LOMBA YANG ADA -->
                <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-5 mb-6">
                        <div>
                            <h3 class="text-xl font-black text-gray-800 uppercase tracking-tight">Daftar Perlombaan</h3>
                            <p class="text-xs text-gray-400 font-medium">Kumpulan seluruh sesi cerdas cermat yang telah terdaftar.</p>
                        </div>
                        <span class="bg-indigo-50 text-indigo-700 text-xs font-bold px-3 py-1.5 rounded-full border border-indigo-100">
                            {{ $lombas->count() }} Total Sesi
                        </span>
                    </div>

                    <!-- LIST KARTU LOMBA -->
                    <div class="flex flex-col gap-5">
                        @forelse ($lombas as $lomba)
                            <div class="border border-gray-200 hover:border-indigo-200 bg-white hover:bg-indigo-50/10 p-5 rounded-2xl shadow-sm transition-all duration-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4 group">
                                
                                <!-- Info Lomba -->
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-extrabold text-gray-900 text-xl tracking-tight group-hover:text-indigo-900 transition truncate">
                                        {{ $lomba->nama_lomba }}
                                    </h4>
                                    <div class="flex items-center gap-4 text-xs text-gray-400 font-medium mt-1">
                                        <span class="flex items-center gap-1">
                                            👥 {{ $lomba->tims ? $lomba->tims->count() : 0 }} Tim Terdaftar
                                        </span>
                                        <span>•</span>
                                        <span>
                                            📅 {{ $lomba->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Tombol Kendali/Aksi -->
                                <div class="flex flex-wrap sm:flex-nowrap items-center gap-2">
                                    <!-- 1. Tombol Atur Tim -->
                                    <a href="{{ route('lomba.show', $lomba->id) }}" title="Pengaturan Tim" 
                                       class="flex items-center justify-center p-2.5 rounded-xl border border-gray-200 hover:border-indigo-300 bg-white text-gray-600 hover:text-indigo-600 shadow-sm transition active:scale-95">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                                        <span class="text-xs font-bold ml-1.5 sm:hidden lg:inline">Atur Tim</span>
                                    </a>

                                    <!-- 2. Tombol Smart Board TV -->
                                    <a href="{{ route('lomba.display', $lomba->id) }}" target="_blank" title="Buka Layar Display TV" 
                                       class="flex items-center justify-center p-2.5 rounded-xl border border-purple-200 hover:border-purple-300 bg-purple-50 text-purple-700 hover:bg-purple-100 shadow-sm transition active:scale-95">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        <span class="text-xs font-bold ml-1.5 sm:hidden lg:inline">Layar TV</span>
                                    </a>

                                    <!-- 3. Tombol Remote Kontrol Utama -->
                                    <a href="{{ route('lomba.panel', $lomba->id) }}" title="Masuk Remote Kontrol Nilai" 
                                       class="flex items-center justify-center py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold shadow-md shadow-blue-500/10 transition active:scale-95 text-xs uppercase tracking-wider flex-1 sm:flex-none">
                                        Remote Kontrol &rarr;
                                    </a>
                                </div>

                            </div>
                        @empty
                            <!-- State Kosong jika belum ada lomba -->
                            <div class="py-16 flex flex-col items-center justify-center text-gray-400 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                                <span class="text-5xl mb-3">🏁</span>
                                <h5 class="font-bold text-gray-700 text-base">Belum Ada Perlombaan</h5>
                                <p class="text-xs text-gray-400 mt-1 max-w-xs text-center">Silakan ketik nama lomba di panel sebelah kiri untuk membuat sesi pertandingan pertama Anda.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
            
        </div>
    </div>
</x-app-layout>