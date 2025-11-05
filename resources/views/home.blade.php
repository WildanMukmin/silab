<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Equipment System - Sistem Peminjaman Alat Laboratorium</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e0e7ff 0%, #dbeafe 100%);
        }

        .feature-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>

<body class="min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-flask text-white"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-800">Lab Equipment System</span>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}"
                        class="text-gray-700 hover:text-blue-600 transition font-medium">Home</a>
                    <a href="#fitur" class="text-gray-700 hover:text-blue-600 transition font-medium">Fitur</a>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('login') }}"
                        class="px-5 py-2 text-gray-700 hover:text-blue-600 font-semibold transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md">
                        Daftar
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="py-20 px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl font-bold text-gray-900 mb-4">
                Sistem Peminjaman <br>
                <span class="text-blue-600">Alat Laboratorium</span>
            </h1>
            <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                Platform modern untuk mengelola peminjaman alat laboratorium dengan mudah,
                efisien, dan terintegras. Cepat, aman, universitas, sekolah, dan institusi penelitian.
            </p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('register') }}"
                    class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-lg font-semibold">
                    Mulai Sekarang
                </a>
                <a href="#fitur"
                    class="px-8 py-3 bg-white text-gray-700 rounded-lg hover:bg-gray-50 transition shadow-md font-semibold">
                    Masuk ke Akun
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-20 px-4 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Fitur Unggulan</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Sistem yang dirancang khusus untuk memudahkan pengelolaan alat laboratorium
                </p>
            </div>

            <!-- Feature Cards Grid -->
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Multi Role System -->
                <div class="feature-card bg-gradient-to-br from-blue-50 to-blue-100 p-8 rounded-2xl">
                    <div class="w-14 h-14 bg-blue-600 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Multi Role System</h3>
                    <p class="text-gray-600">
                        Kelola akses berdasarkan peran mahasiswa, dosen, dan admin dengan pembagian tugas yang
                        terstruktur dan aman
                    </p>
                </div>

                <!-- Booking Management -->
                <div class="feature-card bg-gradient-to-br from-green-50 to-green-100 p-8 rounded-2xl">
                    <div class="w-14 h-14 bg-green-600 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-calendar-check text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Booking Management</h3>
                    <p class="text-gray-600">
                        Sistem pemesanan alat laboratorium yang mudah dengan peminjaman yang mudah dan real-time
                        tracking alat
                    </p>
                </div>

                <!-- Equipment Tracking -->
                <div class="feature-card bg-gradient-to-br from-purple-50 to-purple-100 p-8 rounded-2xl">
                    <div class="w-14 h-14 bg-purple-600 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-box text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Equipment Tracking</h3>
                    <p class="text-gray-600">
                        Tracking kondisi alat secara real-time dengan kemudahan dalam monitoring dan laporan kondisi
                        alat labor
                    </p>
                </div>

                <!-- Dashboard Analytics -->
                <div class="feature-card bg-gradient-to-br from-orange-50 to-orange-100 p-8 rounded-2xl">
                    <div class="w-14 h-14 bg-orange-600 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-chart-line text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Dashboard Analytics</h3>
                    <p class="text-gray-600">
                        Visualisasi data informatif dengan statistik penggunaan dan laporan berbasis data visual
                    </p>
                </div>

                <!-- Secure Authentication -->
                <div class="feature-card bg-gradient-to-br from-red-50 to-red-100 p-8 rounded-2xl">
                    <div class="w-14 h-14 bg-red-600 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Secure Authentication</h3>
                    <p class="text-gray-600">
                        Keamanan tingkat tinggi dengan enkripsi data dan proteksi akses yang aman
                    </p>
                </div>

                <!-- Responsive Design -->
                <div class="feature-card bg-gradient-to-br from-indigo-50 to-indigo-100 p-8 rounded-2xl">
                    <div class="w-14 h-14 bg-indigo-600 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-mobile-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Responsive Design</h3>
                    <p class="text-gray-600">
                        Interface yang user friendly dengan akses di berbagai perangkat, desktop dan mobile seamless
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-flask text-white"></i>
                        </div>
                        <span class="text-xl font-bold">Lab Equipment System</span>
                    </div>
                    <p class="text-gray-400">Platform modern untuk mengelola peminjaman alat laboratorium dengan efisien
                        dan terstruktur.</p>
                </div>

                <div>
                    <h4 class="font-bold mb-4">Menu</h4>
                    <ul class="space-y-2">
                        <li><a href="#beranda" class="text-gray-400 hover:text-white transition">Beranda</a></li>
                        <li><a href="#fitur" class="text-gray-400 hover:text-white transition">Fitur</a></li>
                        <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition">Login</a>
                        </li>
                        <li><a href="{{ route('register') }}"
                                class="text-gray-400 hover:text-white transition">Register</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><i class="fas fa-envelope mr-2"></i> info@silab.ac.id</li>
                        <li><i class="fas fa-phone mr-2"></i> +62 812-3456-7890</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i> Universitas Lampung</li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold mb-4">Sosial Media</h4>
                    <div class="flex space-x-4">
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://github.com/WildanMukmin/track-learn" target="_blank"
                            class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                            <i class="fab fa-github"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 Lab Equipment System - Universitas Lampung. Developed by Wildan Mukmin</p>
            </div>
        </div>
    </footer>

</body>

</html>