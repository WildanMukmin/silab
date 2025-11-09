<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Alat - Silab</title>
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

    @include('partials.header1')

    <main class="flex-1">
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
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
                <form action="{{ route('student.alat.index') }}" method="GET" class="flex flex-wrap md:flex-nowrap items-center gap-4">
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
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($alatList as $alat)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden card-hover">
                        <div class="relative">
                            <img src="{{ $alat->gambar ? asset($alat->gambar) : 'https://via.placeholder.com/400x300.png?text=Gambar+Alat' }}"
                                alt="{{ $alat->nama_alat }}" class="w-full h-48 object-cover">
                            
                            <span class="absolute top-3 right-3 text-xs font-semibold px-3 py-1 rounded-full {{ getStatusBadge($alat->status) }}">
                                <i class="{{ getStatusIcon($alat->status) }} mr-1.5"></i>
                                {{ $alat->status }}
                            </span>
                        </div>
                        
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-gray-900">{{ $alat->nama_alat }}</h3>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12 bg-white rounded-lg shadow-sm">
                        <i class="fas fa-box-open text-gray-400 text-5xl mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-700">Belum Ada Alat</h3>
                        <p class="text-gray-500">Belum ada data alat yang tersedia.</p>
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

