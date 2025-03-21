<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'timeframe',
        'activity_name',
        'description',
        'planned_budget',
        'actual_budget',
        'start_date',
        'end_date',
        'year', // Tambahkan kolom year
    ];

    // Accessor untuk menghitung sisa anggaran
    public function getRemainingBudgetAttribute()
    {
        return $this->planned_budget - ($this->actual_budget ?? 0);
    }
}