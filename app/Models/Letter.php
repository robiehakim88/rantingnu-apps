<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    use HasFactory;

    // Izinkan kolom-kolom ini untuk mass assignment
    protected $fillable = [
        'type',          // Jenis surat (incoming/outgoing)
        'title',         // Judul surat
        'description',   // Deskripsi surat
        'file_path',     // Path file surat
        'date',          // Tanggal surat
        'created_by',    // Pengguna yang membuat surat
        'nomor_surat',   // Nomor surat
        'asal_surat',    // Asal surat (untuk incoming)
        'tujuan',        // Tujuan surat (untuk incoming dan outgoing)
    ];

// Relasi ke tabel letter_files (opsional)
//    public function files(): HasMany
//    {
//        return $this->hasMany(LetterFile::class);
//    }

public function getTypeTranslatedAttribute()
{
    return $this->type === 'incoming' ? 'Surat Masuk' : 'Surat Keluar';
}
}

