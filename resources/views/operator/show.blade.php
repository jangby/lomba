<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    ⚙️ Pengaturan Lomba: <span class="text-indigo-600">{{ $lomba->nama_lomba }}</span>
                </h2>
                <p class="text-sm text-gray-500 mt-1">Tambahkan tim yang akan bertanding di sini.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-gray-500 hover:text-indigo-600 transition bg-gray-100 hover:bg-indigo-50 px-4 py-2 rounded-lg border border-gray-200">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r-lg shadow-sm flex items-center">
                    <span class="text-xl mr-3">✅</span>
                    <p class="font-semibold text-sm">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 mb-8 flex flex-col md:flex-row justify-between items-center gap-4 bg-gradient-to-r from-indigo-50 to-white">
                <div>
                    <h3 class="font-black text-lg text-indigo-900">Akses Perlombaan</h3>
                    <p class="text-sm text-indigo-600 font-medium">Buka layar untuk penonton dan remote kontrol untuk Anda.</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <a href="{{ route('lomba.display', $lomba->id) }}" target="_blank" class="flex-1 sm:flex-none flex items-center justify-center gap-2 bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-xl shadow-md transition active:scale-95">
                        🖥️ Buka Smart Board (TV)
                    </a>
                    <a href="{{ route('lomba.panel', $lomba->id) }}" class="flex-1 sm:flex-none flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-md transition active:scale-95">
                        🎛️ Buka Remote Kontrol
                    </a>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-8">
                
                <div class="w-full md:w-1/3 flex flex-col gap-6">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                <span>👥</span> Tambah Tim Baru
                            </h3>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('tim.store', $lomba->id) }}" method="POST" class="flex flex-col gap-4">
                                @csrf
                                <div>
                                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1">Nama Tim</label>
                                    <input type="text" name="nama_tim" placeholder="Contoh: Regu A" required class="w-full rounded-xl border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50 focus:bg-white transition text-sm font-bold">
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1">Nama Ketua</label>
                                    <input type="text" name="ketua" placeholder="Nama ketua regu..." required class="w-full rounded-xl border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50 focus:bg-white transition text-sm">
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1">Anggota (Opsional)</label>
                                    <textarea name="anggota" class="w-full rounded-xl border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50 focus:bg-white transition text-sm" rows="3" placeholder="Fulan, Fulana..."></textarea>
                                </div>
                                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-bold mt-2 shadow-md transition active:scale-95 tracking-wide">
                                    Simpan Tim
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-2/3 flex flex-col gap-6">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="font-bold text-lg text-gray-800">Daftar Tim Bertanding</h3>
                            <span class="bg-indigo-100 text-indigo-800 text-xs font-bold px-3 py-1.5 rounded-full">{{ $lomba->tims->count() }} Tim</span>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @forelse ($lomba->tims as $tim)
                                    <div class="border border-indigo-100 bg-white hover:bg-indigo-50 hover:border-indigo-300 p-5 rounded-2xl shadow-sm transition duration-200 relative group overflow-hidden">
                                        <div class="absolute top-0 left-0 w-1.5 h-full bg-indigo-500 rounded-l-2xl opacity-0 group-hover:opacity-100 transition"></div>
                                        <h4 class="font-black text-indigo-900 text-xl mb-2">{{ $tim->nama_tim }}</h4>
                                        <p class="text-sm text-gray-600"><strong>Ketua:</strong> {{ $tim->ketua }}</p>
                                        <p class="text-sm text-gray-500 mt-1 truncate"><strong>Anggota:</strong> {{ $tim->anggota ?? '-' }}</p>
                                    </div>
                                @empty
                                    <div class="col-span-full py-12 flex flex-col items-center justify-center text-gray-400 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                                        <span class="text-5xl mb-3">👻</span>
                                        <p class="italic font-medium">Belum ada tim yang ditambahkan.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>