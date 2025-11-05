<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Silab - Platform E-Learning dengan Tracking Progress</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <i class="fas fa-graduation-cap text-3xl text-purple-600"></i>
                    <span class="ml-2 text-2xl font-bold text-gray-800">Silab</span>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-purple-600 transition">Home</a>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 text-purple-600 hover:text-purple-700 font-semibold transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition shadow-md">
                        Daftar
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="gradient-bg pt-24 pb-20 px-4">
        <div class="text-white h-screen w-full flex items-center justify-center flex-col">
            <h1 class="text-5xl font-bold mb-6">Home</h1>
            <p class="text-xl mb-8 text-gray-100">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Mollitia nisi dolore id rem, est soluta, vel quod, et eligendi porro voluptates consequatur
                omnis animi suscipit deleniti explicabo eum ea sit.</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center mb-4">
                        <i class="fas fa-graduation-cap text-2xl text-purple-400"></i>
                        <span class="ml-2 text-xl font-bold">Silab</span>
                    </div>
                    <p class="text-gray-400">Platform e-learning dengan sistem tracking progress yang transparan dan
                        terstruktur.</p>
                </div>

                <div>
                    <h4 class="font-bold mb-4">Menu</h4>
                    <ul class="space-y-2">
                        <li><a href="#beranda" class="text-gray-400 hover:text-white transition">Beranda</a></li>
                        <li><a href="#fitur" class="text-gray-400 hover:text-white transition">Fitur</a></li>
                        <li><a href="#kursus" class="text-gray-400 hover:text-white transition">Kursus</a></li>
                        <li><a href="#testimoni" class="text-gray-400 hover:text-white transition">Testimoni</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><i class="fas fa-envelope mr-2"></i> info@Silab.id</li>
                        <li><i class="fas fa-phone mr-2"></i> +62 812-3456-7890</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i> Universitas Lampung</li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold mb-4">Sosial Media</h4>
                    <div class="flex space-x-4">
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-purple-600 transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-purple-600 transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-purple-600 transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://github.com/WildanMukmin/track-learn" target="_blank"
                            class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-purple-600 transition">
                            <i class="fab fa-github"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 Silab - Universitas Lampung. Developed by Wildan Mukmin, Nafisya Yagtias, Daniel
                    Okto M.S, Imam Ahdy Sabilla</p>
            </div>
        </div>
    </footer>

</body>