<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Kolom yang diizinkan untuk mass assignment
    protected $fillable = [
        'name',         // Nama role
        'description',  // Deskripsi role
    ];
    
    
    
    // Relasi ke model lain (contoh: relasi ke Member)
    public function members()
    {
        return $this->hasMany(Member::class);
    }
}