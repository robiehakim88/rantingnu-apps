<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Orphan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gender',
        'birthdate',
        'address',
    ];

    // Accessor untuk menghitung usia
     public function getAgeAttribute()
    {
        if ($this->birthdate) {
            $birthdate = Carbon::parse($this->birthdate); // Parse tanggal lahir
            $age = $birthdate->diffInYears(now()); // Hitung usia dalam tahun

            // Pastikan hasilnya hanya angka bulat positif
            return max(0, intval($age)); // Gunakan intval() untuk memastikan hasil bulat
        }
        return null; // Jika tanggal lahir kosong, kembalikan null
    }

    // Scope untuk mencari berdasarkan nama
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%');
    }
}