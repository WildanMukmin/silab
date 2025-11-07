<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Peminjaman | Silab</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-md mt-10 p-8 relative">
        <a href="{{ route('admin.peminjaman') }}" class="absolute top-4 right-4 text-gray-500 hover:text-red-600">
            <i class="fas fa-times text-xl"></i>
        </a>

        <h1 class="text-2xl font-bold mb-4 text-gray-800">Detail Peminjaman</h1>

        <div class="space-y-3 text-gray-700">
            <p><strong>Nama Peminjam:</strong> {{ $peminjaman->user->name }}</p>
            <p><strong>Nama Alat:</strong> {{ $peminjaman->alat->nama_alat }}</p>
            <p><strong>Tujuan:</strong> {{ $peminjaman->tujuan_penggunaan ?? '-' }}</p>
            <p><strong>Catatan Tambahan:</strong> {{ $peminjaman->catatan_tambahan ?? '-' }}</p>

            <p>
                <strong>Tanggal:</strong>
                {{ \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->translatedFormat('d F Y') }}
            </p>
            <p>
                <strong>Waktu:</strong>
                {{ \Carbon\Carbon::parse($peminjaman->waktu_mulai)->format('H:i') }} -
                {{ \Carbon\Carbon::parse($peminjaman->waktu_selesai)->format('H:i') }}
            </p>

            <p><strong>Status:</strong>
                <span class="px-3 py-1 text-sm font-medium rounded-full
                    @if($peminjaman->status == 'menunggu') bg-yellow-100 text-yellow-700
                    @elseif($peminjaman->status == 'disetujui') bg-green-100 text-green-700
                    @elseif($peminjaman->status == 'selesai') bg-blue-100 text-blue-700
                    @else bg-red-100 text-red-700 @endif">
                    {{ ucfirst($peminjaman->status) }}
                </span>
            </p>

            @if($peminjaman->status == 'ditolak' && !empty($peminjaman->alasan_penolakan))
                <div class="mt-3 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <p class="text-sm text-red-700">
                        <strong>Alasan Penolakan:</strong> {{ $peminjaman->alasan_penolakan }}
                    </p>
                </div>
            @endif
        </div>

        <!-- Tombol Aksi Utama -->
        <div class="mt-8 flex flex-wrap gap-3">
            @if($peminjaman->status == 'menunggu')
                <!-- Setujui -->
                <form method="POST" action="{{ route('admin.peminjaman.verifikasi', ['id' => $peminjaman->id, 'status' => 'disetujui']) }}">
                    @csrf
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                        Setujui
                    </button>
                </form>

                <!-- Tolak -->
                <button id="openModal" type="button" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                    Tolak
                </button>
            @elseif($peminjaman->status == 'disetujui')
                <!-- Tandai Selesai -->
                <form method="POST" action="{{ route('admin.peminjaman.updateStatus', $peminjaman->id) }}">
                    @csrf
                    <input type="hidden" name="status" value="selesai">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Tandai Selesai
                    </button>
                </form>
            @endif

            <!-- Edit Status -->
            <button id="editModalBtn" type="button" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition">
                Edit Status
            </button>

            <!-- Hapus -->
            <form method="POST" action="{{ route('admin.peminjaman.destroy', $peminjaman->id) }}" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition">
                    Hapus
                </button>
            </form>
        </div>

        <!-- Modal Tolak -->
        <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white rounded-lg p-6 w-96 relative">
                <button id="closeModal" class="absolute top-2 right-3 text-gray-400 hover:text-red-600">
                    <i class="fas fa-times"></i>
                </button>
                <h2 class="text-lg font-bold mb-4 text-gray-800">Alasan Penolakan</h2>
                <form method="POST" action="{{ route('admin.peminjaman.verifikasi', ['id' => $peminjaman->id, 'status' => 'ditolak']) }}">
                    @csrf
                    <textarea name="alasan_penolakan" rows="3" required
                              class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-red-400"
                              placeholder="Tuliskan alasan penolakan..."></textarea>
                    <div class="mt-4 flex justify-end space-x-2">
                        <button type="button" id="cancelModal" class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100">Batal</button>
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">Kirim</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Edit Status -->
        <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white rounded-lg p-6 w-96 relative">
                <button id="closeEditModal" class="absolute top-2 right-3 text-gray-400 hover:text-red-600">
                    <i class="fas fa-times"></i>
                </button>
                <h2 class="text-lg font-bold mb-4 text-gray-800">Edit Status Peminjaman</h2>
                <form method="POST" action="{{ route('admin.peminjaman.updateStatus', $peminjaman->id) }}">
                    @csrf
                    <label class="block mb-2 text-sm font-medium text-gray-700">Pilih Status:</label>
                    <select name="status" class="w-full border border-gray-300 rounded-lg p-2 mb-4 focus:ring-2 focus:ring-yellow-400">
                        <option value="menunggu" @selected($peminjaman->status == 'menunggu')>Menunggu</option>
                        <option value="disetujui" @selected($peminjaman->status == 'disetujui')>Disetujui</option>
                        <option value="selesai" @selected($peminjaman->status == 'selesai')>Selesai</option>
                        <option value="ditolak" @selected($peminjaman->status == 'ditolak')>Ditolak</option>
                    </select>

                    <label class="block mb-2 text-sm font-medium text-gray-700">Alasan Penolakan (Opsional):</label>
                    <textarea name="alasan_penolakan" rows="3"
                              class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-yellow-400"
                              placeholder="Isi jika status ditolak...">{{ $peminjaman->alasan_penolakan }}</textarea>

                    <div class="mt-4 flex justify-end space-x-2">
                        <button type="button" id="cancelEditModal" class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100">Batal</button>
                        <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Modal Tolak
        const modal = document.getElementById('modal');
        const openModal = document.getElementById('openModal');
        const closeModal = document.getElementById('closeModal');
        const cancelModal = document.getElementById('cancelModal');

        openModal?.addEventListener('click', () => modal.classList.remove('hidden'));
        closeModal?.addEventListener('click', () => modal.classList.add('hidden'));
        cancelModal?.addEventListener('click', () => modal.classList.add('hidden'));

        // Modal Edit
        const editModal = document.getElementById('editModal');
        const editModalBtn = document.getElementById('editModalBtn');
        const closeEditModal = document.getElementById('closeEditModal');
        const cancelEditModal = document.getElementById('cancelEditModal');

        editModalBtn?.addEventListener('click', () => editModal.classList.remove('hidden'));
        closeEditModal?.addEventListener('click', () => editModal.classList.add('hidden'));
        cancelEditModal?.addEventListener('click', () => editModal.classList.add('hidden'));
    </script>
</body>
</html>
