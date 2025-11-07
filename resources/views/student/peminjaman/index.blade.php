<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Alat - Silab</title>
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
                    <a href="{{ route('student.dashboard') }}"
                       class="font-medium transition 
                              {{ request()->routeIs('student.dashboard') 
                                 ? 'text-blue-600 border-b-2 border-blue-600' 
                                 : 'text-gray-700 hover:text-blue-600' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('student.peminjaman') }}"
                       class="font-medium transition 
                              {{ request()->routeIs('student.peminjaman*') 
                                 ? 'text-blue-600 border-b-2 border-blue-600' 
                                 : 'text-gray-700 hover:text-blue-600' }}">
                        Peminjaman
                    </a>
                    <a href="{{ route('student.alat.index') }}"
                       class="font-medium transition 
                              {{ request()->routeIs('student.alat*') 
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
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Peminjaman Alat</h1>
                    <p class="text-gray-600">Kelola peminjaman alat laboratorium Anda</p>
                </div>
                <a href="{{ route('student.peminjaman.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center space-x-2 shadow-md">
                    <i class="fas fa-plus"></i>
                    <span>Ajukan Peminjaman</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-blue-500 rounded-xl shadow-sm p-6 text-white card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-90 mb-1">Total Peminjaman</p>
                            <p class="text-3xl font-bold">{{ $totalPeminjaman ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-green-500 rounded-xl shadow-sm p-6 text-white card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-90 mb-1">Disetujui</p>
                            <p class="text-3xl font-bold">{{ $disetujui ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-orange-500 rounded-xl shadow-sm p-6 text-white card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-90 mb-1">Menunggu</p>
                            <p class="text-3xl font-bold">{{ $menunggu ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-purple-500 rounded-xl shadow-sm p-6 text-white card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-90 mb-1">Selesai</p>
                            <p class="text-3xl font-bold">{{ $selesai ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check-circle text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-6 border-b border-gray-200">
                <nav class="flex space-x-8">
                    <a href="{{ route('student.peminjaman', ['tab' => 'aktif']) }}"
                       class="pb-4 px-1 font-medium transition flex items-center space-x-2
                              {{ ($tab ?? 'aktif') === 'aktif' 
                                 ? 'text-blue-600 border-b-2 border-blue-600' 
                                 : 'text-gray-600 hover:text-gray-800' }}">
                        <i class="fas fa-calendar"></i>
                        <span>Peminjaman Aktif</span>
                    </a>
                    <a href="{{ route('student.peminjaman', ['tab' => 'riwayat']) }}"
                       class="pb-4 px-1 font-medium transition flex items-center space-x-2
                              {{ ($tab ?? 'aktif') === 'riwayat' 
                                 ? 'text-blue-600 border-b-2 border-blue-600' 
                                 : 'text-gray-600 hover:text-gray-800' }}">
                        <i class="fas fa-history"></i>
                        <span>Riwayat</span>
                    </a>
                </nav>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                @if(isset($peminjaman) && $peminjaman->count() > 0)
                    <div class="space-y-4">
                        @foreach($peminjaman as $item)
                            <div class="bg-gray-50 rounded-lg p-5 hover:bg-gray-100 transition border border-gray-200">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-start space-x-4 flex-1">
                                        <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-flask text-blue-600 text-2xl"></i>
                                        </div>
                                        
                                        <div class="flex-1">
                                            <h3 class="font-bold text-gray-800 text-lg mb-1">
                                                {{ $item->alat->nama_alat ?? 'Alat tidak ditemukan' }}
                                            </h3>
                                            <p class="text-sm text-gray-600 mb-3">
                                                {{ $item->tujuan_penggunaan }}
                                            </p>
                                            
                                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-3">
                                                <div class="flex items-center space-x-2">
                                                    <i class="fas fa-calendar text-gray-400"></i>
                                                    <span>{{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->format('Y-m-d') }}</span>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <i class="fas fa-clock text-gray-400"></i>
                                                    <span>{{ date('H:i', strtotime($item->waktu_mulai)) }} - {{ date('H:i', strtotime($item->waktu_selesai)) }}</span>
                                                </div>
                                                @if($item->lokasi_peminjaman)
                                                    <div class="flex items-center space-x-2">
                                                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                                                        <span>{{ $item->lokasi_peminjaman }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            @if($item->catatan_tambahan)
                                                <div class="flex items-start space-x-2 bg-blue-50 rounded-lg px-3 py-2 mt-2">
                                                    <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                                                    <p class="text-sm text-blue-700">{{ $item->catatan_tambahan }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start space-x-3 ml-4">
                                        <div>
                                            @if($item->status == 'disetujui')
                                                <span class="px-4 py-2 bg-green-100 text-green-700 rounded-lg text-sm font-medium flex items-center space-x-2">
                                                    <i class="fas fa-check"></i>
                                                    <span>Disetujui</span>
                                                </span>
                                            @elseif($item->status == 'menunggu')
                                                <span class="px-4 py-2 bg-orange-100 text-orange-700 rounded-lg text-sm font-medium flex items-center space-x-2">
                                                    <i class="fas fa-clock"></i>
                                                    <span>Menunggu</span>
                                                </span>
                                            @elseif($item->status == 'ditolak')
                                                <span class="px-4 py-2 bg-red-100 text-red-700 rounded-lg text-sm font-medium flex items-center space-x-2">
                                                    <i class="fas fa-times"></i>
                                                    <span>Ditolak</span>
                                                </span>
                                            @elseif($item->status == 'selesai')
                                                <span class="px-4 py-2 bg-purple-100 text-purple-700 rounded-lg text-sm font-medium flex items-center space-x-2">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Selesai</span>
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <button class="p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-inbox text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg">
                            @if(($tab ?? 'aktif') === 'aktif')
                                Belum ada peminjaman aktif
                            @else
                                Belum ada riwayat peminjaman
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </main>

    @if(session('success'))
        <div id="successMessage" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center space-x-2">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
        <script>
            setTimeout(function() {
                const successMsg = document.getElementById('successMessage');
                if (successMsg) successMsg.style.display = 'none';
            }, 5000);
        </script>
    @endif
</body>

</html>

