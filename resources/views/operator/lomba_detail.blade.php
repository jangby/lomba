<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    ⚙️ Pengaturan Lomba: <span class="text-indigo-600">{{ $lomba->nama_lomba }}</span>
                </h2>
                <p class="text-sm text-gray-500 mt-1">Persiapkan tim, amplop, dan akses kontrol di halaman ini.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-gray-500 hover:text-indigo-600 transition bg-gray-100 hover:bg-indigo-50 px-4 py-2 rounded-lg">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r-lg shadow-sm flex items-center justify-between">
                    <div class="flex items-center">
                        <span class="text-xl mr-3">✅</span>
                        <p class="font-semibold text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg shadow-sm flex items-center justify-between">
                    <div class="flex items-center">
                        <span class="text-xl mr-3">⚠️</span>
                        <p class="font-semibold text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8 flex flex-col md:flex-row justify-between items-center gap-4 bg-gradient-to-r from-indigo-50 to-white">
                <div>
                    <h3 class="font-black text-lg text-indigo-900">Akses Perlombaan</h3>
                    <p class="text-sm text-indigo-600 font-medium">Buka layar untuk penonton dan panel untuk Anda.</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <a href="{{ route('lomba.display', $lomba->id) }}" target="_blank" class="flex-1 sm:flex-none flex items-center justify-center gap-2 bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-xl shadow-md transition hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Buka Smart Board
                    </a>
                    <a href="{{ route('lomba.panel', $lomba->id) }}" class="flex-1 sm:flex-none flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-md transition hover:-translate-y-0.5">
                        Mulai Pandu Lomba
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-8">
                
                <div class="w-full md:w-1/3 flex flex-col gap-6">
                    
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                <span>👥</span> Tambah Tim Baru
                            </h3>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('tim.store', $lomba->id) }}" method="POST" class="flex flex-col gap-4">
                                @csrf
                                <div>
                                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Tim</label>
                                    <input type="text" name="nama_tim" placeholder="Contoh: Regu A" required class="w-full rounded-lg border-gray-300 mt-1 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50 focus:bg-white transition">
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Ketua</label>
                                    <input type="text" name="ketua" placeholder="Nama ketua regu..." required class="w-full rounded-lg border-gray-300 mt-1 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50 focus:bg-white transition">
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Anggota (Opsional)</label>
                                    <textarea name="anggota" class="w-full rounded-lg border-gray-300 mt-1 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50 focus:bg-white transition text-sm" rows="2" placeholder="Fulan, Fulana..."></textarea>
                                </div>
                                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-lg font-bold mt-2 shadow-md transition active:scale-95">
                                    Simpan Tim
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                <span>✉️</span> Persiapan Amplop
                            </h3>
                        </div>
                        <div class="p-6 text-center">
                            <p class="text-sm text-gray-500 mb-5">Sistem akan otomatis membuat amplop sejumlah tim ditambah 1 (untuk soal rebutan/cadangan).</p>
                            <form action="{{ route('amplop.generate', $lomba->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white py-3 rounded-lg font-bold shadow-md transition active:scale-95">
                                    Generate / Reset Amplop
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-2/3 flex flex-col gap-6">
                    
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="font-bold text-lg text-gray-800">Daftar Tim Bertanding</h3>
                            <span class="bg-indigo-100 text-indigo-800 text-xs font-bold px-3 py-1 rounded-full">{{ $lomba->tims->count() }} Tim</span>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @forelse ($lomba->tims as $tim)
                                    <div class="border border-indigo-100 bg-white hover:bg-indigo-50 hover:border-indigo-300 p-5 rounded-xl shadow-sm transition duration-200 relative group">
                                        <div class="absolute top-0 left-0 w-1.5 h-full bg-indigo-500 rounded-l-xl opacity-0 group-hover:opacity-100 transition"></div>
                                        <h4 class="font-black text-indigo-900 text-xl mb-2">{{ $tim->nama_tim }}</h4>
                                        <p class="text-sm text-gray-600"><strong>Ketua:</strong> {{ $tim->ketua }}</p>
                                        <p class="text-sm text-gray-500 mt-1 truncate"><strong>Anggota:</strong> {{ $tim->anggota ?? '-' }}</p>
                                    </div>
                                @empty
                                    <div class="col-span-full py-8 flex flex-col items-center justify-center text-gray-400 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                                        <span class="text-4xl mb-2">👻</span>
                                        <p class="italic font-medium">Belum ada tim yang ditambahkan.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="px-6 py-5 border-b border-gray-100">
                                <h3 class="font-bold text-gray-800">Daftar Amplop Soal</h3>
                            </div>
                            <div class="p-6">
                                <div class="flex flex-wrap gap-3">
                                    @forelse ($lomba->amplops as $amplop)
                                        <div class="bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-lg shadow-sm font-black flex items-center justify-center w-full sm:w-[calc(50%-0.375rem)] h-16 text-center transition hover:bg-amber-100 hover:scale-105 cursor-default">
                                            {{ $amplop->nama_amplop }}
                                        </div>
                                    @empty
                                        <p class="text-gray-400 italic text-sm text-center w-full py-4">Amplop belum di-generate.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                            <div class="bg-gray-800 px-6 py-4">
                                <h3 class="font-bold text-white flex items-center gap-2">
                                    <span>📱</span> Akses Panel Juri
                                </h3>
                            </div>
                            <div class="p-6 flex flex-col items-center justify-center flex-1 text-center bg-gray-50">
                                <p class="text-xs text-gray-500 mb-4 font-medium px-4">Minta Juri untuk scan QR Code ini menggunakan HP mereka (Tanpa Login).</p>
                                
                                <div class="bg-white p-3 rounded-2xl shadow-md border border-gray-200 hover:scale-105 transition duration-300">
                                    {!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(140)->generate(route('juri.panel', $lomba->juri_token)) !!}
                                </div>
                                
                                <a href="{{ route('juri.panel', $lomba->juri_token) }}" target="_blank" class="mt-5 inline-flex items-center gap-1 text-sm font-bold text-indigo-600 hover:text-indigo-800 hover:underline">
                                    Buka Link Manual
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>