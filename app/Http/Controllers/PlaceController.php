<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place;

class PlaceController extends Controller
{
    // Middleware didefinisikan langsung di route

    // Menampilkan daftar masjid/musholla
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Place::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('address', 'like', '%' . $search . '%');
            });
        }

        $places = $query->get();
        return view('places.index', compact('places', 'search'));
    }

    // Menampilkan form tambah masjid/musholla
    public function create()
    {
        return view('places.create');
    }

    // Menyimpan data masjid/musholla baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:masjid,musholla',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        Place::create($validated);

        return redirect()->route('places.index')->with('success', 'Data berhasil ditambahkan.');
    }

    // Menampilkan detail masjid/musholla
    public function show(Place $place)
    {
        return view('places.show', compact('place'));
    }

    // Menampilkan form edit masjid/musholla
    public function edit(Place $place)
    {
        return view('places.edit', compact('place'));
    }

    // Memperbarui data masjid/musholla
    public function update(Request $request, Place $place)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:masjid,musholla',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $place->update($validated);

        return redirect()->route('places.index')->with('success', 'Data berhasil diperbarui.');
    }

    // Menghapus masjid/musholla
    public function destroy(Place $place)
    {
        $place->delete();
        return redirect()->route('places.index')->with('success', 'Data berhasil dihapus.');
    }
}