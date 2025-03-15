<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'date',
        'photos', // Kolom untuk lampiran foto
    ];

    // Mutator untuk menyimpan photos sebagai array JSON
    public function setPhotosAttribute($value)
    {
        $this->attributes['photos'] = is_array($value) ? json_encode($value) : $value;
    }

    // Accessor untuk mendapatkan photos sebagai array
    public function getPhotosAttribute($value)
    {
        return is_string($value) ? json_decode($value, true) : $value;
    }

    // Accessor untuk mendapatkan URL foto sebagai Collection
    public function getPhotoUrlsAttribute()
    {
        $photos = $this->photos ?? [];

        if (is_array($photos)) {
            return collect($photos)->map(function ($photo) {
                return asset('storage/' . $photo);
            });
        }
        return collect(); // Kembalikan Collection kosong jika tidak ada foto
    }
}