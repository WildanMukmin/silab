<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Peminjaman Alat - Silab</title>
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
            <div class="max-w-3xl mx-auto">
                

                <div class="bg-white rounded-xl shadow-sm p-8">
                    <div class="mb-8">
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">Ajukan Peminjaman Alat</h1>
                        <p class="text-gray-600">Isi formulir di bawah untuk mengajukan peminjaman alat</p>
                    </div>
                    @if($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <span class="font-semibold">Terjadi kesalahan:</span>
                            </div>
                            <ul class="list-disc list-inside text-sm ml-6">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('student.peminjaman.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="alat_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Pilih Alat
                            </label>
                            <div class="relative">
                                <select name="alat_id" id="alat_id" required
                                    class="w-full border border-gray-300 rounded-lg py-3 px-4 pr-10 appearance-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('alat_id') border-red-500 @enderror">
                                    <option value="">Pilih alat yang ingin dipinjam</option>
                                    @foreach($alatList ?? [] as $alat)
                                        <option value="{{ $alat->id }}" {{ old('alat_id') == $alat->id ? 'selected' : '' }}>
                                            {{ $alat->nama_alat }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                            @error('alat_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tanggal_peminjaman" class="block text-sm font-semibold text-gray-700 mb-2">
                                Tanggal Peminjaman
                            </label>
                            <div class="relative">
                                <input type="date" name="tanggal_peminjaman" id="tanggal_peminjaman" 
                                    value="{{ old('tanggal_peminjaman') }}"
                                    min="{{ date('Y-m-d') }}"
                                    required
                                    class="w-full border border-gray-300 rounded-lg py-3 px-4 pr-10 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tanggal_peminjaman') border-red-500 @enderror">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar text-gray-400"></i>
                                </div>
                            </div>
                            @error('tanggal_peminjaman')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Waktu</label>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="waktu_mulai" class="block text-xs text-gray-600 mb-1">Waktu Mulai</label>
                                    <div class="relative">
                                        <input type="time" name="waktu_mulai" id="waktu_mulai" 
                                            value="{{ old('waktu_mulai') }}"
                                            required
                                            class="w-full border border-gray-300 rounded-lg py-3 px-4 pr-10 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('waktu_mulai') border-red-500 @enderror">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <i class="fas fa-clock text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('waktu_mulai')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="waktu_selesai" class="block text-xs text-gray-600 mb-1">Waktu Selesai</label>
                                    <div class="relative">
                                        <input type="time" name="waktu_selesai" id="waktu_selesai" 
                                            value="{{ old('waktu_selesai') }}"
                                            required
                                            class="w-full border border-gray-300 rounded-lg py-3 px-4 pr-10 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('waktu_selesai') border-red-500 @enderror">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <i class="fas fa-clock text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('waktu_selesai')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="tujuan_penggunaan" class="block text-sm font-semibold text-gray-700 mb-2">
                                Tujuan Penggunaan
                            </label>
                            <textarea name="tujuan_penggunaan" id="tujuan_penggunaan" rows="3" required
                                placeholder="Contoh: Praktikum Biologi, Penelitian, dll"
                                class="w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tujuan_penggunaan') border-red-500 @enderror">{{ old('tujuan_penggunaan') }}</textarea>
                            @error('tujuan_penggunaan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="catatan_tambahan" class="block text-sm font-semibold text-gray-700 mb-2">
                                Catatan Tambahan
                            </label>
                            <textarea name="catatan_tambahan" id="catatan_tambahan" rows="4"
                                placeholder="Jelaskan detail penggunaan alat atau permintaan khusus..."
                                class="w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('catatan_tambahan') border-red-500 @enderror">{{ old('catatan_tambahan') }}</textarea>
                            @error('catatan_tambahan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                            <a href="{{ route('student.peminjaman') }}"
                                class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Ajukan Peminjaman
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>

</html>

