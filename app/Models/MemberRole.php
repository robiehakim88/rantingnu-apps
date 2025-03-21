<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberRole extends Model
{
    protected $fillable = ['member_id', 'role_id', 'start_year', 'end_year'];

    // Relasi ke tabel members
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    // Relasi ke tabel roles
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}

