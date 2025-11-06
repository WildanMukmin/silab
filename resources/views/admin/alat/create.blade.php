<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Alat - Silab</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
            <div class="max-w-3xl mx-auto">
                <div class="bg-white p-8 rounded-lg shadow-md">
                    
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Tambah Alat Baru</h1>
                        <p class="text-gray-600">Isi formulir di bawah untuk menambahkan alat</p>
                    </div>

                    <hr class="my-6 border-gray-200">

                    <form action="{{ route('admin.alat.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                        <div>
                            <label for="nama_alat" class="block text-sm font-medium text-gray-700 mb-1">Nama Alat</label>
                            <input type="text" name="nama_alat" id="nama_alat" value="{{ old('nama_alat') }}"
                                class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-500 @error('nama_alat') border-red-500 @enderror"
                                required>
                            @error('nama_alat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Awal</label>
                            <select name="status" id="status" class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror" required>
                                <option value="Tersedia" {{ old('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="Sedang Digunakan" {{ old('status') == 'Sedang Digunakan' ? 'selected' : '' }}>Sedang Digunakan</option>
                                <option value="Maintenance" {{ old('status') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                                <option value="Rusak" {{ old('status') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                            </select>
                            @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="gambar" class="block text-sm font-medium text-gray-700 mb-1">Gambar Alat</label>
                            <input type="file" name="gambar" id="gambar"
                                class="w-full border border-gray-300 rounded-lg p-2 text-sm
                                       file:mr-4 file:py-2 file:px-4
                                       file:rounded-lg file:border-0
                                       file:text-sm file:font-semibold
                                       file:bg-blue-50 file:text-blue-700
                                       hover:file:bg-blue-100 @error('gambar') border-red-500 @enderror">
                            @error('gambar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                            <a href="{{ route('admin.alat.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Simpan Alat
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </main>

</body>
</html>