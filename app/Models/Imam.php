<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imam extends Model
{
    protected $fillable = ['place_id', 'name', 'year_hijriyah'];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}