<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - Silab</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- Header --}}
    @include('partials.header1')

    <main class="flex-1 py-10 px-4">
        <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-xl p-8">

            {{-- Judul --}}
            <h2 class="text-2xl font-bold mb-6 text-center text-indigo-600">Edit Profil</h2>

            {{-- Alert --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            {{-- FORM EDIT PROFIL --}}
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="editProfileForm">
                @csrf
                @method('PUT')

                {{-- Foto Profil --}}
                <div class="text-center mb-6">
                    <img id="profilePreview"
                        src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('images/default-avatar.png') }}"
                        alt="Foto Profil"
                        class="w-32 h-32 object-cover rounded-full border-4 border-indigo-200 mx-auto">
                </div>

                <div class="mb-4">
                    <label for="profile_photo" class="block font-semibold mb-1">Foto Profil</label>
                    <input class="block w-full border rounded-lg p-2" type="file" id="profile_photo" name="profile_photo" accept="image/*" onchange="previewImage(this)">
                    <p class="text-sm text-gray-500">Format: JPG, JPEG, PNG. Maksimal 2MB.</p>
                </div>

                {{-- Informasi --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block font-semibold mb-1">Nama Lengkap *</label>
                        <input type="text" name="name" class="w-full border rounded-lg p-2" value="{{ old('name', auth()->user()->name) }}" required>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Email *</label>
                        <input type="email" name="email" class="w-full border rounded-lg p-2" value="{{ old('email', auth()->user()->email) }}" required>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">No. HP / WhatsApp *</label>
                        <input type="text" id="phone" name="phone" class="w-full border rounded-lg p-2"
                            value="{{ old('phone', auth()->user()->phone) }}"
                            placeholder="Contoh: 081234567890" required>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">NIM *</label>
                        <input type="text" id="nim" name="nim" class="w-full border rounded-lg p-2"
                            value="{{ old('nim', auth()->user()->nim) }}" placeholder="10 digit angka" required>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Jurusan *</label>
                        <input type="text" name="jurusan" class="w-full border rounded-lg p-2"
                            value="{{ old('jurusan', auth()->user()->jurusan) }}" placeholder="Contoh: Teknik Komputer" required>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Angkatan *</label>
                        <input type="text" id="angkatan" name="angkatan" class="w-full border rounded-lg p-2"
                            value="{{ old('angkatan', auth()->user()->angkatan) }}" placeholder="Contoh: 2021" required>
                    </div>
                </div>

                {{-- Tombol Simpan --}}
                <div class="text-right">
                    <button class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700" type="submit">
                        <i class="fa-solid fa-save mr-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        {{-- GANTI PASSWORD --}}
        <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-xl p-8 mt-10">
            <h2 class="text-2xl font-bold mb-6 text-center text-yellow-600">Ganti Password</h2>

            <form action="{{ route('profile.password') }}" method="POST" id="passwordForm">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Password Lama *</label>
                    <input type="password" name="current_password" class="w-full border rounded-lg p-2" required>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Password Baru *</label>
                    <input type="password" id="new_password" name="new_password" class="w-full border rounded-lg p-2"
                        placeholder="Minimal 8 karakter & mengandung angka" required>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Konfirmasi Password Baru *</label>
                    <input type="password" id="confirm_password" name="new_password_confirmation" class="w-full border rounded-lg p-2" required>
                </div>

                <div class="text-right">
                    <button class="bg-yellow-500 text-white px-5 py-2 rounded-lg hover:bg-yellow-600" type="submit">
                        <i class="fa-solid fa-key mr-1"></i> Ganti Password
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        // Preview Foto
        function previewImage(input){
            if(input.files && input.files[0]){
                const reader = new FileReader();
                reader.onload = e => document.getElementById('profilePreview').src = e.target.result;
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Validasi sebelum submit
        document.getElementById('editProfileForm').addEventListener('submit', function(e){
            const phone = document.getElementById('phone').value.trim();
            const nim = document.getElementById('nim').value.trim();
            const angkatan = document.getElementById('angkatan').value.trim();

            if(!/^08\d{8,11}$/.test(phone)){
                alert('Nomor HP harus diawali 08 dan berjumlah 10–13 digit.');
                e.preventDefault();
                return;
            }

            if(!/^\d{10}$/.test(nim)){
                alert('NIM harus terdiri dari tepat 10 angka.');
                e.preventDefault();
                return;
            }

            if(!/^\d{4}$/.test(angkatan)){
                alert('Angkatan harus terdiri dari 4 angka (contoh: 2021).');
                e.preventDefault();
                return;
            }
        });

        // Validasi password
        document.getElementById('passwordForm').addEventListener('submit', function(e){
            const newPass = document.getElementById('new_password').value;
            const confirm = document.getElementById('confirm_password').value;
            if(newPass.length < 8 || !/\d/.test(newPass)){
                alert('Password baru harus minimal 8 karakter dan mengandung angka.');
                e.preventDefault();
                return;
            }
            if(newPass !== confirm){
                alert('Konfirmasi password tidak cocok.');
                e.preventDefault();
                return;
            }
        });
    </script>
</body>
</html>
