<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // Impor namespace Carbon

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'role_id',
        'date_of_birth',
    ];

    // Relasi ke model Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    
    public function roles()
    {
        return $this->hasMany(MemberRole::class);
    }

    // Accessor untuk usia
    public function getAgeAttribute()
    {
        if ($this->date_of_birth) {
            return Carbon::parse($this->date_of_birth)->age;
        }
        return null;
    }

    // Accessor untuk tanggal lahir dalam format tertentu
    public function getFormattedDateOfBirthAttribute()
    {
        if ($this->date_of_birth) {
            return Carbon::parse($this->date_of_birth)->format('d-m-Y');
        }
        return '-';
    }
}