<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    // Nama tabel eksplisit, agar tidak berubah menjadi "peminjamen"
    protected $table = 'peminjaman';

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'user_id',
        'alat_id',
        'tanggal_peminjaman',
        'waktu_mulai',
        'waktu_selesai',
        'tujuan_penggunaan',
        'catatan_tambahan',
        'lokasi_peminjaman',
        'status',
        'alasan_penolakan',
        'disetujui_at',
        'ditolak_at',
        'selesai_at',
    ];

    // Kolom yang bertipe waktu (timestamp) agar dikenali otomatis oleh Laravel
    protected $casts = [
        'tanggal_peminjaman' => 'date',
        'waktu_mulai' => 'datetime:H:i',
        'waktu_selesai' => 'datetime:H:i',
        'disetujui_at' => 'datetime',
        'ditolak_at' => 'datetime',
        'selesai_at' => 'datetime',
    ];

    /**
     * Relasi ke model User.
     * Setiap peminjaman dilakukan oleh satu pengguna.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke model Alat.
     * Setiap peminjaman terkait dengan satu alat.
     */
    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alat_id');
    }

}
