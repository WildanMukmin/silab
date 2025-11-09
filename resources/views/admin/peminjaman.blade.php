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
    @include('partials.header')

    <!-- Main Content -->
    <main class="px-8 py-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Kelola Peminjaman</h1>
        <p class="text-gray-500 mb-6">Kelola dan setujui peminjaman alat laboratorium</p>

        <!-- Status Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">               
                <div class="bg-white rounded-xl shadow-sm p-6 card-hover">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-clock text-yellow-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Menunggu</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $menunggu ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm p-6 card-hover">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-check text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Disetujui</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $disetujui ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 card-hover">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-times text-red-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Ditolak</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $ditolak ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm p-6 card-hover">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-clipboard-check text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Selesai</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $selesai ?? 0 }}</p>
                        </div>
                    </div>
                </div>
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
