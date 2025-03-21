<?php

namespace App\Http\Controllers;

use App\Models\Imam;
use App\Models\Place;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ImamController extends Controller
{
    // Menampilkan daftar imam taraweh
public function index(Request $request)
{
    // Ambil nilai pencarian dari request (jika ada)
    $search = $request->input('search', ''); // Default value adalah string kosong ('')

    $query = Imam::with('place');

    // Filter berdasarkan pencarian
    if ($search) {
        $query->whereHas('place', function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('address', 'like', "%{$search}%");
        })->orWhere('name', 'like', "%{$search}%");
    }

    // Filter berdasarkan tahun hijriyah
    if ($request->has('year_hijriyah') && $request->input('year_hijriyah')) {
        $query->where('year_hijriyah', $request->input('year_hijriyah'));
    }

    // Mengambil semua data tanpa paginasi
    $imams = $query->get();

    return view('imams.index', compact('imams', 'search'));
}



    
    // Menampilkan form tambah imam taraweh
    public function create()
    {
        $places = Place::all();
        return view('imams.create', compact('places'));
    }

    // Menyimpan data imam taraweh
    public function store(Request $request)
    {
        $validated = $request->validate([
            'place_id' => 'required|exists:places,id',
            'name' => 'required|string|max:255',
            'year_hijriyah' => 'required|integer|min:1400|max:9999',
        ]);

        Imam::create($validated);

        return redirect()->route('imams.index')->with('success', 'Data imam taraweh berhasil ditambahkan.');
    }

    // Menampilkan form edit imam taraweh
    public function edit(Imam $imam)
    {
        $places = Place::all();
        return view('imams.edit', compact('imam', 'places'));
    }

    // Memperbarui data imam taraweh
    public function update(Request $request, Imam $imam)
    {
        $validated = $request->validate([
            'place_id' => 'required|exists:places,id',
            'name' => 'required|string|max:255',
            'year_hijriyah' => 'required|integer|min:1400|max:9999',
        ]);

        $imam->update($validated);

        return redirect()->route('imams.index')->with('success', 'Data imam taraweh berhasil diperbarui.');
    }

    // Menghapus data imam taraweh
    public function destroy(Imam $imam)
    {
        $imam->delete();
        return redirect()->route('imams.index')->with('success', 'Data imam taraweh berhasil dihapus.');
    }

    // Mencetak PDF rekap data imam taraweh
public function generatePDF(Request $request)
{
    // Ambil filter tahun hijriyah dari request
    $yearHijriyah = $request->input('year_hijriyah');

    // Query data imam taraweh
    $query = Imam::with('place'); // Mengambil data dengan relasi place

    if ($yearHijriyah) {
        $query->where('year_hijriyah', $yearHijriyah); // Filter berdasarkan tahun hijriyah
    }

    $imams = $query->get();

    // Muat view ke dalam PDF
    $pdf = Pdf::loadView('imams.pdf', compact('imams', 'yearHijriyah'))
               ->setPaper('a4', 'portrait'); // Atur ukuran kertas dan orientasi

    // Unduh PDF
    return $pdf->download('rekap_imam_taraweh.pdf');
}
}