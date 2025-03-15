<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    
    use HasFactory;

    // Izinkan kolom-kolom ini untuk mass assignment
    protected $fillable = [
        'type',          // Jenis transaksi (income/expense)
        'description',   // Deskripsi transaksi
        'amount',        // Jumlah uang
        'date',          // Tanggal transaksi
    ];
    


// Scope untuk memfilter transaksi berdasarkan jenis (income/expense)
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Scope untuk memfilter transaksi berdasarkan rentang tanggal
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    // Akses atribut terjemahan untuk kolom type
    public function getTypeTranslatedAttribute()
    {
        return $this->type === 'income' ? 'Pemasukan' : 'Pengeluaran';
    }


}

