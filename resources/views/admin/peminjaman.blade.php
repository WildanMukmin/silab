<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Alat - Admin | Silab</title>
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
    <!-- Navbar -->
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
                       class="font-medium transition {{ request()->routeIs('admin.dashboard') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.peminjaman') }}"
                       class="font-medium text-blue-600 border-b-2 border-blue-600 transition">
                        Peminjaman
                    </a>
                    <a href="{{ route('admin.alat.index') }}"
                       class="font-medium transition {{ request()->routeIs('admin.alat.*') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
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
                        <button type="submit" class="text-gray-500 hover:text-red-600 transition" title="Logout">
                            <i class="fas fa-sign-out-alt text-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="px-8 py-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Kelola Peminjaman</h1>
        <p class="text-gray-500 mb-6">Kelola dan setujui peminjaman alat laboratorium</p>

        <!-- Status Cards -->
        <div class="grid grid-cols-4 gap-4 mb-8">
            <div class="bg-yellow-400 text-white rounded-xl p-4 flex justify-between items-center shadow-md">
                <div>
                    <p class="text-lg font-semibold">Menunggu</p>
                    <h2 class="text-3xl font-bold">{{ $menunggu ?? 0 }}</h2>
                </div>
                <i class="fas fa-hourglass-half text-3xl"></i>
            </div>

            <div class="bg-green-500 text-white rounded-xl p-4 flex justify-between items-center shadow-md">
                <div>
                    <p class="text-lg font-semibold">Disetujui</p>
                    <h2 class="text-3xl font-bold">{{ $disetujui ?? 0 }}</h2>
                </div>
                <i class="fas fa-check-circle text-3xl"></i>
            </div>

            <div class="bg-blue-500 text-white rounded-xl p-4 flex justify-between items-center shadow-md">
                <div>
                    <p class="text-lg font-semibold">Selesai</p>
                    <h2 class="text-3xl font-bold">{{ $selesai ?? 0 }}</h2>
                </div>
                <i class="fas fa-check text-3xl"></i>
            </div>

            <div class="bg-red-500 text-white rounded-xl p-4 flex justify-between items-center shadow-md">
                <div>
                    <p class="text-lg font-semibold">Ditolak</p>
                    <h2 class="text-3xl font-bold">{{ $ditolak ?? 0 }}</h2>
                </div>
                <i class="fas fa-times-circle text-3xl"></i>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex space-x-3">
                <input type="text" placeholder="Cari peminjaman..." class="px-4 py-2 border rounded-lg w-64">
                <select class="px-4 py-2 border rounded-lg">
                    <option>Semua Status</option>
                    <option>Menunggu</option>
                    <option>Disetujui</option>
                    <option>Selesai</option>
                    <option>Ditolak</option>
                </select>
            </div>

            <div class="flex space-x-3">
                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
                    <i class="fas fa-file-export"></i>
                    <span>Export Data</span>
                </button>
                <!-- <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg flex items-center space-x-2">
                    <i class="fas fa-cog"></i>
                    <span>Pengaturan</span>
                </button> -->
            </div>
        </div>

        <!-- Daftar Peminjaman -->
        <div class="space-y-4">
            @foreach($peminjaman as $item)
                <div class="bg-white rounded-xl shadow-sm p-5 card-hover">
                    <div class="flex justify-between">
                        <div>
                            <h2 class="font-semibold text-lg text-gray-800">{{ $item->user->name }}</h2>
                            <p class="text-sm text-gray-500">{{ $item->user->nim ?? '-' }} • {{ $item->user->prodi ?? '-' }}</p>
                            <h3 class="font-semibold mt-2 text-gray-700">{{ $item->alat->nama_alat }}</h3>
                            <p class="text-sm text-gray-500">{{ $item->tujuan_penggunaan }}</p>
                        </div>
                        <div>
                            <span class="px-3 py-1 text-sm font-medium rounded-full 
                                @if($item->status == 'menunggu') bg-yellow-100 text-yellow-700
                                @elseif($item->status == 'disetujui') bg-green-100 text-green-700
                                @elseif($item->status == 'selesai') bg-blue-100 text-blue-700
                                @else bg-red-100 text-red-700 @endif">
                                {{ ucfirst($item->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-3 text-gray-500 text-sm flex items-center space-x-4">
                        <div><i class="fa-regular fa-calendar"></i> {{ $item->tanggal_peminjaman }}</div>
                        <div><i class="fa-regular fa-clock"></i> {{ $item->waktu_mulai }} - {{ $item->waktu_selesai }}</div>
                        <div><i class="fa-solid fa-location-dot"></i> {{ $item->lokasi_peminjaman ?? '-' }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $peminjaman->links() }}
        </div>
    </main>
</body>
</html>
