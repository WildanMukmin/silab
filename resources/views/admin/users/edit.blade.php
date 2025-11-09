@extends('layouts.app')

@section('title', 'Edit User')

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
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="bi bi-pencil-square text-warning"></i> Edit User
                </h2>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <!-- Alert Messages -->
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <!-- Current Photo -->
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <h5 class="mb-3">Foto Profil Saat Ini</h5>
                    <div class="d-flex justify-content-center">
                        <img src="{{ $user->profile_photo_url }}" 
                             alt="{{ $user->name }}" 
                             class="rounded-circle border border-3"
                             style="width: 120px; height: 120px; object-fit: cover;"
                             id="currentPhoto">
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-warning">
                    <h5 class="mb-0">Form Edit User: <strong>{{ $user->name }}</strong></h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Role & Status -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Role <span class="text-danger">*</span></label>
                                <div class="btn-group w-100" role="group">
                                    <input type="radio" class="btn-check" name="role" id="roleAdmin" value="admin" 
                                           {{ old('role', $user->role) == 'admin' ? 'checked' : '' }} required>
                                    <label class="btn btn-outline-info" for="roleAdmin">
                                        <i class="bi bi-shield-check"></i> Admin
                                    </label>

                                    <input type="radio" class="btn-check" name="role" id="roleStudent" value="student" 
                                           {{ old('role', $user->role) == 'student' ? 'checked' : '' }} required>
                                    <label class="btn btn-outline-success" for="roleStudent">
                                        <i class="bi bi-mortarboard"></i> Mahasiswa
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status Akun <span class="text-danger">*</span></label>
                                <div class="btn-group w-100" role="group">
                                    <input type="radio" class="btn-check" name="is_active" id="statusActive" value="1" 
                                           {{ old('is_active', $user->is_active) == 1 ? 'checked' : '' }} required>
                                    <label class="btn btn-outline-success" for="statusActive">
                                        <i class="bi bi-check-circle"></i> Aktif
                                    </label>

                                    <input type="radio" class="btn-check" name="is_active" id="statusInactive" value="0" 
                                           {{ old('is_active', $user->is_active) == 0 ? 'checked' : '' }} required>
                                    <label class="btn btn-outline-secondary" for="statusInactive">
                                        <i class="bi bi-x-circle"></i> Nonaktif
                                    </label>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Basic Info -->
                        <h6 class="text-primary mb-3">Informasi Dasar</h6>

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">No. HP/WhatsApp</label>
                            <input type="text" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone', $user->phone) }}" 
                                   placeholder="08123456789">
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password (Optional) -->
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> 
                            <strong>Ganti Password:</strong> Kosongkan jika tidak ingin mengubah password
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password Baru</label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password">
                                <small class="text-muted">Minimal 8 karakter</small>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation">
                            </div>
                        </div>

                        <!-- Quick Reset Password -->
                        <div class="mb-3">
                            <a href="{{ route('admin.users.reset-password', $user) }}" 
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Reset password ke default: password123?')">
                                <i class="bi bi-key"></i> Reset Password ke Default (password123)
                            </a>
                        </div>

                        <!-- Student Specific Fields -->
                        <div id="studentFields" style="{{ old('role', $user->role) == 'student' ? '' : 'display: none;' }}">
                            <hr>
                            <h6 class="text-success mb-3">Informasi Mahasiswa</h6>

                            <div class="mb-3">
                                <label for="nim" class="form-label">NIM <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('nim') is-invalid @enderror" 
                                       id="nim" 
                                       name="nim" 
                                       value="{{ old('nim', $user->nim) }}">
                                @error('nim')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="jurusan" class="form-label">Program Studi <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('jurusan') is-invalid @enderror"
                                       id="jurusan" 
                                       name="jurusan" 
                                       value="{{ old('jurusan', $user->jurusan) }}"
                                       required>
                                @error('jurusan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="angkatan" class="form-label">Angkatan <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('angkatan') is-invalid @enderror"
                                       id="angkatan" 
                                       name="angkatan" 
                                       value="{{ old('angkatan', $user->angkatan) }}"
                                       placeholder="Contoh: 2023"
                                       required>
                                @error('angkatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <!-- Update Profile Photo -->
                        <hr>
                        <h6 class="text-primary mb-3">Ganti Foto Profil </h6>

                        <div class="mb-3">
                            <input type="file" 
                                   class="form-control @error('profile_photo') is-invalid @enderror" 
                                   name="profile_photo" 
                                   id="profilePhotoInput" 
                                   accept="image/jpeg,image/png,image/jpg"
                                   onchange="previewImage(this)">
                            <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengganti.</small>
                            @error('profile_photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-center mb-3" id="photoPreviewContainer" style="display: none;">
                            <p class="text-muted">Preview Foto Baru:</p>
                            <img id="photoPreview" src="" class="rounded-circle border" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>

                        <!-- Submit Buttons -->
                        <hr>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="bi bi-save"></i> Update User
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="card shadow-sm mt-4 border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-exclamation-triangle"></i> Danger Zone
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-3">Tindakan di bawah ini bersifat permanen dan tidak dapat dibatalkan.</p>
                    
                    @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('YAKIN ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Hapus User Ini
                        </button>
                    </form>
                    @else
                    <div class="alert alert-warning mb-0">
                        <i class="bi bi-shield-lock"></i> Anda tidak dapat menghapus akun sendiri
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle student fields based on role selection
document.querySelectorAll('input[name="role"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const studentFields = document.getElementById('studentFields');
        const nimInput = document.getElementById('nim');
        const jurusanInput = document.getElementById('jurusan');
        const angkatanInput = document.getElementById('angkatan');
        
        if (this.value === 'student') {
            studentFields.style.display = 'block';
            nimInput.required = true;
            jurusanInput.required = true;
            angkatanInput.required = true;
        } else {
            studentFields.style.display = 'none';
            nimInput.required = false;
            jurusanInput.required = false;
            angkatanInput.required = false;
        }
    });
});

// Preview new profile photo
function previewImage(input) {
    const preview = document.getElementById('photoPreview');
    const container = document.getElementById('photoPreviewContainer');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            container.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        container.style.display = 'none';
    }
}
</script>
@endsection