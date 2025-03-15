<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User; // Model untuk anggota
use App\Models\Letter; // Model untuk surat
use App\Models\Finance; // Model untuk keuangan
use App\Models\Event; // Model untuk kegiatan
use App\Models\Place;
use App\Models\Member;
use App\Models\Orphan; // Untuk total anak yatim piatu

class DashboardController extends Controller
{
  

    public function index()
    {
        // Hitung jumlah data dari tabel-tabel
        //$totalMembers = User::count();
        $totalMembers = Member::count();
        $totalLetters = Letter::count();
        $totalFinances = Finance::count();
        $totalEvents = Event::count();
        
        // Hitung total masjid dan musholla
        $totalPlaces = Place::count();
        $totalMosques = Place::where('type', 'masjid')->count();
        $totalMushollas = Place::where('type', 'musholla')->count();
        
         // Hitung total anak yatim piatu
        $totalOrphans = Orphan::count();
        $totalMaleOrphans = Orphan::where('gender', 'male')->count();
        $totalFemaleOrphans = Orphan::where('gender', 'female')->count();


        // Kirim variabel ke view
        return view('dashboard', compact(
            'totalMembers',
            'totalLetters',
            'totalFinances',
            'totalEvents',
            'totalPlaces',
            'totalMosques',
            'totalMushollas',
            'totalOrphans',
            'totalMaleOrphans',
            'totalFemaleOrphans'
        ));
    }
}

