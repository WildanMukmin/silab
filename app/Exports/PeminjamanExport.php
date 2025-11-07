<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PeminjamanExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Peminjaman::with(['user', 'alat'])->get();
    }

    public function map($peminjaman): array
    {
        return [
            $peminjaman->id,
            $peminjaman->user->name,
            // $peminjaman->user->nim ?? '-',
            $peminjaman->alat->nama_alat,
            $peminjaman->tanggal_peminjaman,
            $peminjaman->waktu_mulai . ' - ' . $peminjaman->waktu_selesai,
            $peminjaman->tujuan_penggunaan,
            ucfirst($peminjaman->status),
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Peminjam',
            // 'NIM',
            'Nama Alat',
            'Tanggal',
            'Waktu',
            'Tujuan Penggunaan',
            'Status',
        ];
    }
}
