@extends('layouts.app')

@section('title', 'Detail User')

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
                    <i class="bi bi-person-badge text-info"></i> Detail User
                </h2>
                <div>
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning me-2">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <!-- Profile Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <div class="d-flex justify-content-center mb-3">
                        <img src="{{ $user->profile_photo_url }}" 
                             alt="{{ $user->name }}" 
                             class="rounded-circle border border-3"
                             style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    
                    <h3 class="mb-2">{{ $user->name }}</h3>
                    
                    @if($user->isAdmin())
                    <span class="badge bg-info fs-6">
                        <i class="bi bi-shield-check"></i> ADMINISTRATOR
                    </span>
                    @else
                    <span class="badge bg-success fs-6">
                        <i class="bi bi-mortarboard"></i> MAHASISWA
                    </span>
                    @endif

                    <div class="mt-2">
                        @if($user->is_active)
                        <span class="badge bg-success">
                            <i class="bi bi-check-circle"></i> Akun Aktif
                        </span>
                        @else
                        <span class="badge bg-secondary">
                            <i class="bi bi-x-circle"></i> Akun Nonaktif
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Information Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle"></i> Informasi Detail
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">
                            <i class="bi bi-person"></i> Nama Lengkap
                        </div>
                        <div class="col-md-8">
                            <strong>{{ $user->name }}</strong>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">
                            <i class="bi bi-envelope"></i> Email
                        </div>
                        <div class="col-md-8">
                            <strong>{{ $user->email }}</strong>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">
                            <i class="bi bi-phone"></i> No. HP/WhatsApp
                        </div>
                        <div class="col-md-8">
                            <strong>{{ $user->phone ?? '-' }}</strong>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">
                            <i class="bi bi-person-badge"></i> Role
                        </div>
                        <div class="col-md-8">
                            <strong>{{ ucfirst($user->role) }}</strong>
                        </div>
                    </div>

                    @if($user->isStudent())
                    <hr>
                    <h6 class="text-success mb-3">Informasi Mahasiswa</h6>

                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">
                            <i class="bi bi-credit-card"></i> NIM
                        </div>
                        <div class="col-md-8">
                            <strong>{{ $user->nim ?? '-' }}</strong>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">
                            <i class="bi bi-building"></i> Jurusan
                        </div>
                        <div class="col-md-8">
                            <strong>{{ $user->jurusan ?? '-' }}</strong>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">
                            <i class="bi bi-calendar"></i> Angkatan
                        </div>
                        <div class="col-md-8">
                            <strong>{{ $user->angkatan ?? '-' }}</strong>
                        </div>
                    </div>
                    @endif

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">
                            <i class="bi bi-calendar-plus"></i> Terdaftar Sejak
                        </div>
                        <div class="col-md-8">
                            <strong>{{ $user->created_at ? $user->created_at->format('d F Y, H:i') . ' WIB' : '-' }}</strong>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">
                            <i class="bi bi-clock-history"></i> Login Terakhir
                        </div>
                        <div class="col-md-8">
                            <strong>
                                {{ $user->last_login_at ? $user->last_login_at->format('d F Y, H:i') . ' WIB' : 'Belum pernah login' }}
                            </strong>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 text-muted">
                            <i class="bi bi-pencil-square"></i> Update Terakhir
                        </div>
                        <div class="col-md-8">
                            <strong>{{ $user->updated_at ? $user->updated_at->format('d F Y, H:i') . ' WIB' : '-' }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            @if($user->isStudent())
            <!-- Peminjaman Statistics Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-bar-chart"></i> Statistik Peminjaman
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="p-3 border rounded">
                                <i class="bi bi-clipboard-data text-primary" style="font-size: 2rem;"></i>
                                <h4 class="mt-2 mb-0">{{ $peminjamanStats['total'] }}</h4>
                                <small class="text-muted">Total Peminjaman</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 border rounded">
                                <i class="bi bi-hourglass-split text-warning" style="font-size: 2rem;"></i>
                                <h4 class="mt-2 mb-0">{{ $peminjamanStats['pending'] }}</h4>
                                <small class="text-muted">Menunggu</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 border rounded">
                                <i class="bi bi-arrow-repeat text-info" style="font-size: 2rem;"></i>
                                <h4 class="mt-2 mb-0">{{ $peminjamanStats['active'] }}</h4>
                                <small class="text-muted">Sedang Dipinjam</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 border rounded">
                                <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                                <h4 class="mt-2 mb-0">{{ $peminjamanStats['completed'] }}</h4>
                                <small class="text-muted">Dikembalikan</small>
                            </div>
                        </div>
                    </div>

                    @if($peminjamanStats['active'] > 0)
                    <div class="alert alert-warning mt-3 mb-0">
                        <i class="bi bi-exclamation-triangle"></i>
                        User ini memiliki <strong>{{ $peminjamanStats['active'] }} peminjaman aktif</strong>. 
                        Pastikan semua alat dikembalikan sebelum menonaktifkan akun.
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-gear"></i> Aksi Cepat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                            <i class="bi bi-pencil-square"></i> Edit Informasi User
                        </a>

                        <form action="{{ route('admin.users.reset-password', $user) }}" method="GET" class="d-inline" onsubmit="return confirm('Reset password user ke: password123?')">
                            @csrf
                            <button type="submit"
                                    class="btn btn-info w-100">
                                <i class="bi bi-key"></i> Reset Password ke Default
                            </button>
                        </form>

                        <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="btn {{ $user->is_active ? 'btn-secondary' : 'btn-success' }} w-100"
                                    onclick="return confirm('Yakin ingin {{ $user->is_active ? 'menonaktifkan' : 'mengaktifkan' }} user ini?')">
                                <i class="bi {{ $user->is_active ? 'bi-x-circle' : 'bi-check-circle' }}"></i>
                                {{ $user->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}
                            </button>
                        </form>

                        @if($user->id !== auth()->id())
                        <hr>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                            @csrf
                            @method('DELETE') 
                            <button type="submit" 
                                    class="btn btn-danger w-100"
                                    onclick="return confirm('YAKIN ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan!')">
                                <i class="bi bi-trash"></i> Hapus User
                            </button>
                        </form>
                        @else
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-shield-lock"></i> Anda tidak dapat menghapus akun sendiri
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection