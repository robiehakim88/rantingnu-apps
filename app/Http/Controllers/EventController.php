<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    // Menampilkan daftar kegiatan
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Event::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
        }

        $events = $query->get();
        return view('events.index', compact('events', 'search'));
    }

    // Menampilkan form tambah kegiatan
    public function create()
    {
        return view('events.create');
    }

    // Menyimpan data kegiatan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'photos.*' => 'nullable|file|mimes:jpg,png,jpeg|max:2048', // Validasi untuk multiple foto
        ]);
    
        // Simpan data kegiatan
        $event = Event::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'date' => $validated['date'],
        ]);
    
        // Simpan foto jika ada
        if ($request->hasFile('photos')) {
            $photoPaths = [];
    
            foreach ($request->file('photos') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('events', $fileName, 'public'); // Simpan ke storage/app/public/events
                $photoPaths[] = $filePath; // Pastikan ini adalah array
            }
    
            $event->update(['photos' => $photoPaths]); // Simpan sebagai array
        }
    
        return redirect()->route('events.index')->with('success', 'Kegiatan berhasil ditambahkan.');
    }   
    
    // Menampilkan detail kegiatan
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    // Menampilkan form edit kegiatan
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    // Memperbarui data kegiatan
  public function update(Request $request, Event $event)
{
    // Validasi data input
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'date' => 'required|date',
        'photos.*' => 'nullable|file|mimes:jpg,png,jpeg|max:2048', // Validasi untuk multiple foto
    ]);

    // Update data kegiatan
    $event->update([
        'name' => $validated['name'],
        'description' => $validated['description'],
        'date' => $validated['date'],
    ]);

    // Simpan foto baru jika ada
    if ($request->hasFile('photos')) {
        $photoPaths = $event->photos ?? []; // Ambil foto yang sudah ada

        foreach ($request->file('photos') as $file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('events', $fileName, 'public'); // Simpan ke storage/app/public/events
            $photoPaths[] = $filePath; // Tambahkan path foto baru
        }

        $event->update(['photos' => $photoPaths]); // Simpan array gabungan foto lama dan baru
    }

    return redirect()->route('events.index')->with('success', 'Kegiatan berhasil diperbarui.');
}
    
    // Menghapus data kegiatan
   public function destroy(Event $event)
    {
        // Hapus semua foto terkait jika ada
        if ($event->photos) {
            // Pastikan photos adalah array
            $photos = is_string($event->photos) ? json_decode($event->photos, true) : $event->photos;
    
            if (is_array($photos)) {
                foreach ($photos as $photo) {
                    Storage::disk('public')->delete($photo);
                }
            }
        }
    
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Kegiatan berhasil dihapus.');
    }
    
    public function deletePhoto(Request $request, Event $event, $photo)
    {
        // Pastikan file ada di database
        if ($event->photos && in_array($photo, $event->photos)) {
            // Hapus file dari storage
            Storage::disk('public')->delete('events/' . $photo);
    
            // Hapus file dari array photos
            $photos = array_diff($event->photos, [$photo]);
            $event->update(['photos' => array_values($photos)]);
        }
    
        return redirect()->back()->with('success', 'Foto berhasil dihapus.');
    }
}