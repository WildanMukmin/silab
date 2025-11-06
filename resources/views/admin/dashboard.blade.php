<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Silab</title>
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
            <div class="bg-white p-8 rounded-lg shadow-md">
                
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
                    <p class="text-gray-600">Selamat datang kembali, {{ Auth::user()->name }}!</p>
                </div>

                <hr class="my-6 border-gray-200">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-lg shadow-md card-hover border border-gray-200">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-600">Total Pengguna</p>
                                {{-- $totalUsers dikirim dari DashboardController --}}
                                <p class="text-2xl font-bold">{{ $totalUsers ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Tambahkan card statistik lainnya di sini --}}
            
                </div>
            
                <div class="mt-8">
                    <p>Konten dashboard utama Anda bisa diletakkan di sini.</p>
                </div>
                </div>
        </div>
    </main>

</body>
</html>