<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orphan;

class OrphanController extends Controller
{
    // Menampilkan daftar anak yatim piatu
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Orphan::query();

        if ($search) {
            $query->search($search);
        }

        $orphans = $query->get();

        // Hitung total anak berdasarkan jenis kelamin
        $totalMale = $orphans->where('gender', 'male')->count();
        $totalFemale = $orphans->where('gender', 'female')->count();

        // Hitung total anak yang memenuhi syarat santunan (usia < 17 tahun)
        $eligibleForAid = $orphans->filter(function ($orphan) {
            return $orphan->age && $orphan->age < 17;
        })->count();

        return view('orphans.index', compact('orphans', 'search', 'totalMale', 'totalFemale', 'eligibleForAid'));
    }

    // Menampilkan form tambah anak yatim piatu
    public function create()
    {
        return view('orphans.create');
    }

    // Menyimpan data anak yatim piatu baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'birthdate' => 'required|date',
            'address' => 'nullable|string',
        ]);

        Orphan::create($validated);

        return redirect()->route('orphans.index')->with('success', 'Data anak yatim piatu berhasil ditambahkan.');
    }

    // Menampilkan detail anak yatim piatu
    public function show(Orphan $orphan)
    {
        return view('orphans.show', compact('orphan'));
    }

    // Menampilkan form edit anak yatim piatu
    public function edit(Orphan $orphan)
    {
        return view('orphans.edit', compact('orphan'));
    }

    // Memperbarui data anak yatim piatu
    public function update(Request $request, Orphan $orphan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'birthdate' => 'required|date',
            'address' => 'nullable|string',
        ]);

        $orphan->update($validated);

        return redirect()->route('orphans.index')->with('success', 'Data anak yatim piatu berhasil diperbarui.');
    }

    // Menghapus data anak yatim piatu
    public function destroy(Orphan $orphan)
    {
        $orphan->delete();
        return redirect()->route('orphans.index')->with('success', 'Data anak yatim piatu berhasil dihapus.');
    }
}