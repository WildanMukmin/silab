<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User - Silab</title>
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

    @include('partials.header1')

    <main class="flex-1">
        <div class="p-8">
            <!-- Header Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Student</h1>
                <p class="text-gray-600">Kelola peminjaman alat laboratorium Anda</p>
            </div>

            <!-- Summary Cards Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Peminjaman Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6 card-hover">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-calendar text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Total Peminjaman</p>
                                <p class="text-3xl font-bold text-gray-800">{{ $totalPeminjaman ?? 0 }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Disetujui Card -->
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

                    <!-- Menunggu Card -->
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

                    <!-- Ditolak Card -->
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
            </div>

            <!-- Navigation Tabs Section -->
            <div class="mb-6 border-b border-gray-200">
                <nav class="flex space-x-8">
                    <a href="#" class="pb-4 px-1 border-b-2 border-blue-600 font-semibold text-blue-600">
                        Ringkasan
                    </a>
                    <a href="{{ route('student.peminjaman', ['tab' => 'riwayat']) }}" class="pb-4 px-1 text-gray-600 hover:text-gray-800 transition">
                        Riwayat Peminjaman
                    </a>
                </nav>
            </div>

            <!-- Recent Loans Section -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Peminjaman Terbaru</h2>
                
                @if(isset($recentLoans) && $recentLoans->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentLoans as $loan)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-flask text-blue-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800">{{ $loan->alat->nama_alat ?? 'Alat tidak ditemukan' }}</h3>
                                        <p class="text-sm text-gray-600">
                                            {{ \Carbon\Carbon::parse($loan->tanggal_peminjaman)->format('Y-m-d') }} • 
                                            {{ date('H:i', strtotime($loan->waktu_mulai)) }} - 
                                            {{ date('H:i', strtotime($loan->waktu_selesai)) }}
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    @if($loan->status == 'disetujui')
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-sm font-medium">
                                            Disetujui
                                        </span>
                                    @elseif($loan->status == 'menunggu')
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-sm font-medium">
                                            Menunggu
                                        </span>
                                    @elseif($loan->status == 'ditolak')
                                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-sm font-medium">
                                            Ditolak
                                        </span>
                                    @elseif($loan->status == 'selesai')
                                        <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium">
                                            Selesai
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-inbox text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-500">Belum ada peminjaman</p>
                    </div>
                @endif
            </div>
        </div>
    </main>
</body>

</html>
