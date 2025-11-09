@extends('layouts.app')

@section('title', 'Tambah User Baru')

@section('content')

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

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="bi bi-person-plus text-primary"></i> Tambah User Baru</h2>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            {{-- Alert --}}
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mt-2 mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Form --}}
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">Form Tambah User</div>
                <div class="card-body">
                    <form 
                        action="{{ route('admin.users.store') }}" 
                        method="POST" 
                        enctype="multipart/form-data" 
                        id="userForm" 
                        autocomplete="off"
                    >
                        @csrf

                        {{-- Role --}}
                        <div class="mb-4">
                            <label class="form-label">Pilih Role <span class="text-danger">*</span></label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="role" id="roleAdmin" value="admin" required>
                                <label class="btn btn-outline-info" for="roleAdmin">
                                    <i class="bi bi-shield-check"></i> Admin
                                </label>

                                <input type="radio" class="btn-check" name="role" id="roleStudent" value="student" checked required>
                                <label class="btn btn-outline-success" for="roleStudent">
                                    <i class="bi bi-mortarboard"></i> Mahasiswa
                                </label>
                            </div>
                            @error('role')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>
                        <h6 class="text-primary mb-3">Informasi Dasar</h6>

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Kim Jong Un" required autocomplete="new-name">
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" placeholder="Contoh: bubub@gmail.com" required autocomplete="off" autocorrect="off" spellcheck="false">
                        </div>

                        {{-- Password --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" required autocomplete="new-password">
                                <small class="text-muted">Minimal 8 karakter dan mengandung angka</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
                            </div>
                        </div>

                        {{-- Phone --}}
                        <div class="mb-3">
                            <label class="form-label">No. HP / WhatsApp</label>
                            <input type="text" name="phone" class="form-control" placeholder="Contoh: 08123456789" autocomplete="off">
                        </div>

                        {{-- Student Info --}}
                        <div id="studentFields">
                            <hr>
                            <h6 class="text-success mb-3">Informasi Mahasiswa</h6>

                            <div class="mb-3">
                                <label class="form-label">NIM <span class="text-danger">*</span></label>
                                <input type="text" name="nim" class="form-control" placeholder="Contoh: 2317051107" required autocomplete="off">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Program Studi <span class="text-danger">*</span></label>
                                <input type="text" name="jurusan" class="form-control" placeholder="Contoh: Ilmu Komputer" required autocomplete="off">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Angkatan <span class="text-danger">*</span></label>
                                <input type="text" name="angkatan" class="form-control" placeholder="Contoh: 2023" required autocomplete="off">
                            </div>
                        </div>

                        {{-- Foto Profil --}}
                        <hr>
                        <h6 class="text-primary mb-3">Foto Profil</h6>
                        <div class="mb-3">
                            <input 
                                type="file" 
                                name="profile_photo" 
                                class="form-control"
                                accept="image/jpeg,image/png,image/jpg"
                                onchange="previewImage(this)"
                                autocomplete="off"
                            >
                            <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                        </div>

                        <div class="text-center mb-3" id="photoPreviewContainer" style="display: none;">
                            <img id="photoPreview" src="" class="rounded-circle border" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>

                        {{-- Tombol --}}
                        <hr>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-save"></i> Simpan User
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.querySelectorAll('input[name="role"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const studentFields = document.getElementById('studentFields');
        studentFields.style.display = (this.value === 'student') ? 'block' : 'none';
        studentFields.querySelectorAll('input').forEach(i => i.required = (this.value === 'student'));
    });
});

function previewImage(input) {
    const preview = document.getElementById('photoPreview');
    const container = document.getElementById('photoPreviewContainer');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            container.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
