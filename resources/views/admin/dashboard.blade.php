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

    @include('partials.header')

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
                            <a href="{{ url('/admin/users') }}" class="block">
    <div class="ml-4 hover:bg-gray-100 p-2 rounded-lg transition">
        <p class="text-gray-600">Total Pengguna</p>
        {{-- $totalUsers dikirim dari DashboardController --}}
        <p class="text-2xl font-bold">{{ $totalUsers ?? 0 }}</p>
    </div>
</a>

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