<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    // Kolom yang diizinkan untuk mass assignment
    protected $fillable = [
        'name',         // Nama masjid/musholla
        'type',         // Jenis: masjid atau musholla
        'address',      // Alamat
        'latitude',     // Latitude lokasi
        'longitude',    // Longitude lokasi
    ];

    // Accessor untuk menerjemahkan jenis ke bahasa Indonesia
    public function getTypeTranslatedAttribute()
    {
        return $this->type === 'masjid' ? 'Masjid' : 'Musholla';
    }
    
  //  protected $fillable = ['name', 'address'];

    public function imams()
    {
        return $this->hasMany(Imam::class);
    }
    
}