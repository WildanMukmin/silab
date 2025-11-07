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
            <a href="{{ route('admin.peminjaman', ['status' => 'menunggu']) }}" 
            class="bg-yellow-400 text-white rounded-xl p-4 flex justify-between items-center shadow-md {{ request('status') == 'menunggu' ? 'ring-4 ring-yellow-200' : '' }}">
                <div>
                    <p class="text-lg font-semibold">Menunggu</p>
                    <h2 class="text-3xl font-bold">{{ $menunggu ?? 0 }}</h2>
                </div>
                <i class="fas fa-hourglass-half text-3xl"></i>
            </a>

            <a href="{{ route('admin.peminjaman', ['status' => 'disetujui']) }}" 
            class="bg-green-500 text-white rounded-xl p-4 flex justify-between items-center shadow-md {{ request('status') == 'disetujui' ? 'ring-4 ring-green-200' : '' }}">
                <div>
                    <p class="text-lg font-semibold">Disetujui</p>
                    <h2 class="text-3xl font-bold">{{ $disetujui ?? 0 }}</h2>
                </div>
                <i class="fas fa-check-circle text-3xl"></i>
            </a>

            <a href="{{ route('admin.peminjaman', ['status' => 'selesai']) }}" 
            class="bg-blue-500 text-white rounded-xl p-4 flex justify-between items-center shadow-md {{ request('status') == 'selesai' ? 'ring-4 ring-blue-200' : '' }}">
                <div>
                    <p class="text-lg font-semibold">Selesai</p>
                    <h2 class="text-3xl font-bold">{{ $selesai ?? 0 }}</h2>
                </div>
                <i class="fas fa-check text-3xl"></i>
            </a>

            <a href="{{ route('admin.peminjaman', ['status' => 'ditolak']) }}" 
            class="bg-red-500 text-white rounded-xl p-4 flex justify-between items-center shadow-md {{ request('status') == 'ditolak' ? 'ring-4 ring-red-200' : '' }}">
                <div>
                    <p class="text-lg font-semibold">Ditolak</p>
                    <h2 class="text-3xl font-bold">{{ $ditolak ?? 0 }}</h2>
                </div>
                <i class="fas fa-times-circle text-3xl"></i>
            </a>
        </div>


       <!-- Filter & Search -->
        <div class="flex justify-between items-center mb-6">
            <form method="GET" action="{{ route('admin.peminjaman') }}" class="flex space-x-3 items-center">
                <!-- Input Pencarian -->
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari peminjam..." 
                    class="px-4 py-2 border rounded-lg w-64 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    oninput="this.form.submit()"
                >

                <!-- Dropdown Status -->
                <select 
                    name="status" 
                    onchange="this.form.submit()" 
                    class="px-4 py-2 border rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value="semua" {{ $status == 'semua' ? 'selected' : '' }}>Semua Status</option>
                    <option value="menunggu" {{ $status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="disetujui" {{ $status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="selesai" {{ $status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="ditolak" {{ $status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </form>

            <!-- Tombol Export -->
            <div>
                <form action="{{ route('admin.peminjaman.export') }}" method="GET">
                    <button type="submit" 
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 hover:bg-blue-700 transition">
                        <i class="fas fa-file-export"></i>
                        <span>Export Data</span>
                    </button>
                </form>
            </div>
            </div>


        <!-- Daftar Peminjaman -->
        <div class="space-y-4">
            @foreach($peminjaman as $item)
                <div class="bg-white rounded-xl shadow-sm p-5 card-hover">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="font-semibold text-lg text-gray-800">{{ $item->user->name }}</h2>
                            <p class="text-sm text-gray-500">{{ $item->user->nim ?? '-' }} • {{ $item->user->prodi ?? '-' }}</p>

                            <h3 class="font-semibold mt-2 text-gray-700">{{ $item->alat->nama_alat }}</h3>
                            <p class="text-sm text-gray-500 mt-1">
                                <span class="font-semibold">Tujuan:</span> {{ $item->tujuan_penggunaan ?? '-' }}
                            </p>
                            @if(!empty($item->catatan_tambahan))
                                <p class="text-sm text-gray-500 mt-1">
                                    <span class="font-semibold">Catatan Tambahan:</span> {{ $item->catatan_tambahan }}
                                </p>
                            @endif
                            @if($item->status == 'ditolak' && !empty($item->alasan_penolakan))
                                <p class="text-sm text-red-600 mt-1">
                                    <span class="font-semibold">Alasan Penolakan:</span> {{ $item->alasan_penolakan }}
                                </p>
                            @endif
                        </div>

                        <div class="flex items-center space-x-3">
                            <span class="px-3 py-1 text-sm font-medium rounded-full 
                                @if($item->status == 'menunggu') bg-yellow-100 text-yellow-700
                                @elseif($item->status == 'disetujui') bg-green-100 text-green-700
                                @elseif($item->status == 'selesai') bg-blue-100 text-blue-700
                                @else bg-red-100 text-red-700 @endif">
                                {{ ucfirst($item->status) }}
                            </span>

                            <a href="{{ route('admin.peminjaman.show', $item->id) }}" 
                               class="text-blue-600 hover:text-blue-800" title="Lihat Detail">
                                <i class="fas fa-eye text-lg"></i>
                            </a>
                        </div>
                    </div>

                    <div class="mt-3 text-gray-500 text-sm flex items-center space-x-4">
                       <div>
                            <i class="fa-regular fa-calendar"></i>
                            {{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->translatedFormat('d F Y') }}
                        </div>
                        <div>
                            <i class="fa-regular fa-clock"></i>
                            {{ \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') }} - 
                            {{ \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i') }}
                        </div>
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
