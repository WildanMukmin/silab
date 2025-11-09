@extends('layouts.app')

@section('title', 'Kelola User')

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

<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">
            <i class="bi bi-people text-primary"></i> Kelola Akun User
        </h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah User Baru
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="bi bi-people-fill text-primary" style="font-size: 2rem;"></i>
                    <h3 class="mt-2">{{ $stats['total'] }}</h3>
                    <p class="text-muted mb-0">Total User</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="bi bi-shield-check text-info" style="font-size: 2rem;"></i>
                    <h3 class="mt-2">{{ $stats['admin'] }}</h3>
                    <p class="text-muted mb-0">Admin</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="bi bi-mortarboard-fill text-success" style="font-size: 2rem;"></i>
                    <h3 class="mt-2">{{ $stats['student'] }}</h3>
                    <p class="text-muted mb-0">Mahasiswa</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 2rem;"></i>
                    <h3 class="mt-2">{{ $stats['active'] }}</h3>
                    <p class="text-muted mb-0">Aktif</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Filter Role</label>
                    <select name="role" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="student" {{ request('role') == 'student' ? 'selected' : '' }}>Mahasiswa</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Filter Status</label>
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Cari User</label>
                    <div class="input-group">
                        <input type="text" 
                               name="search" 
                               class="form-control" 
                               placeholder="Cari nama, email, atau NIM..." 
                               value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i> Cari
                        </button>
                        @if(request()->hasAny(['role', 'status', 'search']))
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Reset
                        </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Foto</th>
                            <th width="25%">Nama / Email</th>
                            <th width="15%">Role</th>
                            <th width="15%">Status</th>
                            <th width="15%">Terdaftar</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                        <tr>
                            <td>{{ $users->firstItem() + $index }}</td>
                            <td>
                                <img src="{{ $user->profile_photo_url }}" 
                                     alt="{{ $user->name }}" 
                                     class="rounded-circle"
                                     style="width: 50px; height: 50px; object-fit: cover;">
                            </td>
                            <td>
                                <strong>{{ $user->name }}</strong><br>
                                <small class="text-muted">{{ $user->email }}</small><br>
                                @if($user->isStudent() && $user->nim)
                                <small class="text-muted">
                                    <i class="bi bi-credit-card"></i> NIM: {{ $user->nim }}
                                </small>
                                @endif
                            </td>
                            <td>
                                @if($user->isAdmin())
                                <span class="badge bg-info">
                                    <i class="bi bi-shield-check"></i> ADMIN
                                </span>
                                @else
                                <span class="badge bg-success">
                                    <i class="bi bi-mortarboard"></i> STUDENT
                                </span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="btn btn-sm {{ $user->is_active ? 'btn-success' : 'btn-secondary' }}"
                                            onclick="return confirm('Yakin ingin mengubah status user ini?')">
                                        <i class="bi {{ $user->is_active ? 'bi-check-circle' : 'bi-x-circle' }}"></i>
                                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                <small>{{ $user->created_at->format('d M Y') }}</small>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.users.show', $user) }}" 
                                       class="btn btn-sm btn-info"
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                       class="btn btn-sm btn-warning"
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger"
                                                title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} user
                </div>
                <div>
                    {{ $users->links() }}
                </div>
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                <p class="text-muted mt-3">Tidak ada user ditemukan</p>
                @if(request()->hasAny(['role', 'status', 'search']))
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-clockwise"></i> Reset Filter
                </a>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection