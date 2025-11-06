<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Alat - Silab</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
    </style>
    {{-- Helper PHP untuk styling status --}}
    @php
    function getStatusBadge($status) {
        switch ($status) {
            case 'Tersedia': return 'bg-green-100 text-green-800';
            case 'Sedang Digunakan': return 'bg-blue-100 text-blue-800';
            case 'Maintenance': return 'bg-yellow-100 text-yellow-800';
            case 'Rusak': return 'bg-red-100 text-red-800';
            default: return 'bg-gray-100 text-gray-800';
        }
    }
    function getStatusIcon($status) {
        switch ($status) {
            case 'Tersedia': return 'fas fa-check-circle text-green-500';
            case 'Sedang Digunakan': return 'fas fa-clock text-blue-500';
            case 'Maintenance': return 'fas fa-exclamation-triangle text-yellow-500';
            case 'Rusak': return 'fas fa-times-circle text-red-500';
            default: return 'fas fa-question-circle text-gray-500';
        }
    }
    @endphp
</head>

<body class="bg-gray-100">

    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="px-8">
        <div class="flex justify-between h-16 items-center">
                
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-flask text-white"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-800 uppercase">Silab</span>
                </div>

                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('admin.dashboard') }}"
                       class="font-medium transition 
                              {{ request()->routeIs('admin.dashboard') 
                                 ? 'text-blue-600 border-b-2 border-blue-600' 
                                 : 'text-gray-700 hover:text-blue-600' }}">
                        Dashboard
                    </a>
                    <a href="#" {{-- TODO: Ganti ke route peminjaman --}}
                       class="font-medium text-gray-700 hover:text-blue-600 transition">
                        Peminjaman
                    </a>
                    <a href="{{ route('admin.alat.index') }}"
                       class="font-medium transition 
                              {{ request()->routeIs('admin.alat.*') 
                                 ? 'text-blue-600 border-b-2 border-blue-600' 
                                 : 'text-gray-700 hover:text-blue-600' }}">
                        Alat
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                        <span class="text-gray-700 font-medium">{{ Auth::user()->name }}</span>
                    </div>
                    <span class="text-gray-300">|</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="text-gray-500 hover:text-red-600 transition"
                            title="Logout">
                            <i class="fas fa-sign-out-alt text-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-1">
        <div class="p-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                {{-- Card Statistik --}}
                <div class="bg-white p-5 rounded-lg shadow-sm flex items-center space-x-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Tersedia</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['tersedia'] }}</p>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-sm flex items-center space-x-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-blue-600 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Sedang Digunakan</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['digunakan'] }}</p>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-sm flex items-center space-x-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-yellow-600 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Maintenance</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['maintenance'] }}</p>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-sm flex items-center space-x-4">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-times-circle text-red-600 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Rusak</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['rusak'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm mb-8">
                <div class="flex flex-wrap justify-between items-center gap-4">
                    
                    <form action="{{ route('admin.alat.index') }}" method="GET" class="flex-grow">
                        <div class="flex flex-wrap md:flex-nowrap items-center gap-4">
                            
                            <div class="relative w-full md:w-80">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    placeholder="Cari nama alat...">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                            
                            <select name="status" onchange="this.form.submit()" class="w-full md:w-48 border border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-500">
                                <option value="Semua Status">Semua Status</option>
                                <option value="Tersedia" {{ request('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="Sedang Digunakan" {{ request('status') == 'Sedang Digunakan' ? 'selected' : '' }}>Sedang Digunakan</option>
                                <option value="Maintenance" {{ request('status') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                                <option value="Rusak" {{ request('status') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                            </select>
                            
                            <button type="submit" class="hidden">Cari</button>
                        </div>
                    </form>

                    <div class="flex-shrink-0">
                        <a href="{{ route('admin.alat.create') }}" class="w-full md:w-auto px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md whitespace-nowrap flex items-center justify-center">
                            <i class="fas fa-plus mr-2"></i>Tambah Alat
                        </a>
                    </div>
                </div>
            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($alatList as $alat)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden card-hover">
                        <div class="relative">
                            <img src="{{ $alat->gambar ? Storage::url($alat->gambar) : 'https://via.placeholder.com/400x300.png?text=Gambar+Alat' }}"
                                alt="{{ $alat->nama_alat }}" class="w-full h-48 object-cover">
                            
                            <span class="absolute top-3 right-3 text-xs font-semibold px-3 py-1 rounded-full {{ getStatusBadge($alat->status) }}">
                                <i class="{{ getStatusIcon($alat->status) }} mr-1.5"></i>
                                {{ $alat->status }}
                            </span>
                        </div>
                        
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-gray-900">{{ $alat->nama_alat }}</h3>
                        </div>
                        
                        <div class="px-5 py-3 bg-gray-50 border-t border-gray-100 flex justify-end space-x-3">
                            <a href="{{ route('admin.alat.edit', $alat->id) }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <form action="{{ route('admin.alat.destroy', $alat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus alat ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium">
                                    <i class="fas fa-trash-alt mr-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12 bg-white rounded-lg shadow-sm">
                        <i class="fas fa-box-open text-gray-400 text-5xl mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-700">Belum Ada Alat</h3>
                        <p class="text-gray-500">Belum ada data alat yang ditambahkan.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $alatList->appends(request()->query())->links() }}
            </div>
        </div>
    </main>

</body>
</html>