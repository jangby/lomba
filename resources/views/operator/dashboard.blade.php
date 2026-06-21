<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Operator LCC') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 border-b border-gray-200">
                    <h3 class="text-lg font-bold mb-4">Buat Perlombaan Baru</h3>
                    <form action="{{ route('lomba.store') }}" method="POST" class="flex gap-4">
                        @csrf
                        <input type="text" name="nama_lomba" placeholder="Contoh: LCC Tingkat Wustha" required
                               class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Buat Lomba
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Daftar Perlombaan</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse ($lombas as $lomba)
                            <div class="border rounded-lg p-4 shadow-sm relative">
                                <h4 class="font-bold text-xl text-indigo-600">{{ $lomba->nama_lomba }}</h4>
                                <p class="text-sm text-gray-500 mb-2">Status: <span class="uppercase font-semibold">{{ $lomba->status }}</span></p>
                                
                                <div class="mt-4 flex gap-2">
                                    <a href="{{ route('lomba.show', $lomba->id) }}" class="bg-gray-800 hover:bg-gray-900 text-white text-sm py-1 px-3 rounded inline-block">
                                        Atur Tim & Soal
                                    </a>
                                    <button class="bg-green-600 hover:bg-green-700 text-white text-sm py-1 px-3 rounded">
                                        Link Juri
                                    </button>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 italic">Belum ada perlombaan yang dibuat.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>