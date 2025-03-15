<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Letter;
use Illuminate\Support\Facades\Storage; // Impor kelas Storage

class LetterController extends Controller
{
    // Method untuk menampilkan daftar surat
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Letter::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('type', 'like', '%' . $search . '%');
            });
        }

        $letters = $query->get();
        return view('letters.index', compact('letters', 'search'));
    }

    // Method untuk menampilkan halaman tambah surat
    public function create()
    {
        return view('letters.create');
    }

    // Method untuk menyimpan data surat baru
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'type' => 'required|in:incoming,outgoing',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'files.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,jpeg|max:2048',
            'date' => 'nullable|date',
            'nomor_surat' => 'nullable|string|max:255',
            'asal_surat' => 'nullable|string|max:255|required_if:type,incoming', // Wajib untuk incoming
            'tujuan' => 'nullable|string|max:255|required', // Wajib untuk semua jenis surat
        ]);
        
        
       

         // Simpan file jika ada
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Nama unik untuk file
            $filePath = $file->storeAs('letters', $fileName, 'public'); // Simpan ke storage/app/public/letters
            $validated['file_path'] = $filePath; // Simpan path ke database
        }

        
        // Tambahkan created_by menggunakan ID pengguna yang sedang login
        $validated['created_by'] = auth()->id();
    
        Letter::create($validated);
    
        return redirect()->route('letters.index')->with('success', 'Surat berhasil ditambahkan.');
        
    }

    // Method untuk menampilkan halaman edit surat
    public function edit(Letter $letter)
    {
        return view('letters.edit', compact('letter'));
    }

    // Method untuk memperbarui data surat
    public function update(Request $request, Letter $letter)
    {
        
        $validated = $request->validate([
            'type' => 'required|in:incoming,outgoing',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'files.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,jpeg|max:2048',
            'date' => 'nullable|date',
            'nomor_surat' => 'nullable|string|max:255',
            'asal_surat' => 'nullable|string|max:255|required_if:type,incoming', // Wajib untuk incoming
            'tujuan' => 'nullable|string|max:255|required', // Wajib untuk semua jenis surat
        ]);
        
       

        // Simpan file baru jika ada
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($letter->file_path) {
                Storage::disk('public')->delete($letter->file_path);
            }
    
            // Simpan file baru
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('letters', $fileName, 'public');
            $validated['file_path'] = $filePath;
        }
    
        // Perbarui data surat
        $letter->update($validated);
    
        return redirect()->route('letters.index')->with('success', 'Surat berhasil diperbarui.');
    }

    // Method untuk menghapus surat
    public function destroy(Letter $letter)
    {
        // Hapus semua file terkait jika ada
        if ($letter->file_paths) {
            foreach ($letter->file_paths as $filePath) {
                Storage::disk('public')->delete($filePath);
            }
        }

        $letter->delete();
        return redirect()->route('letters.index')->with('success', 'Surat berhasil dihapus.');
    }
    
    
    
    public function deleteFile(Request $request, Letter $letter, $filePath)
    {
        // Pastikan file ada di database
        if ($letter->file_paths && in_array($filePath, $letter->file_paths)) {
            // Hapus file dari storage
            Storage::disk('public')->delete($filePath);
    
            // Hapus file dari array file_paths
            $filePaths = array_diff($letter->file_paths, [$filePath]);
            $letter->update(['file_paths' => array_values($filePaths)]);
        }
    
        return redirect()->back()->with('success', 'File berhasil dihapus.');
    }
    
    
    
}