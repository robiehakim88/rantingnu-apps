<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Letter;
use Illuminate\Support\Facades\Storage; // Impor kelas Storage
use Barryvdh\DomPDF\Facade\Pdf;

class LetterController extends Controller
{
    // Method untuk menampilkan daftar surat

public function index(Request $request)
{
    // Ambil semua tahun unik dari database
    $years = Letter::selectRaw('YEAR(date) as year')->distinct()->pluck('year');

    // Query dasar
    $query = Letter::query();

    // Inisialisasi variabel search
    $search = $request->input('search', '');

    // Filter berdasarkan pencarian
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%')
              ->orWhere('description', 'like', '%' . $search . '%')
              ->orWhere('type', 'like', '%' . $search . '%');
        });
    }

    // Filter berdasarkan tahun
    if ($request->has('year') && $request->input('year')) {
        $query->whereYear('date', $request->input('year'));
    }

    // Filter berdasarkan bulan
    if ($request->has('month') && $request->input('month')) {
        $query->whereMonth('date', $request->input('month'));
    }

    // Filter berdasarkan jenis surat
    if ($request->has('type') && $request->input('type')) {
        $query->where('type', $request->input('type'));
    }

    // Paginate hasil query
    $letters = $query->paginate(10)->withQueryString();

    return view('letters.index', compact('letters', 'years', 'search'));
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
    
    
    // Method untuk menghasilkan PDF
public function generatePDF(Request $request)
{
    // Query berdasarkan filter yang sama dengan index
    $query = Letter::query();

    if ($request->has('year') && $request->input('year')) {
        $query->whereYear('date', $request->input('year'));
    }

    if ($request->has('month') && $request->input('month')) {
        $query->whereMonth('date', $request->input('month'));
    }

    if ($request->has('type') && $request->input('type')) {
        $query->where('type', $request->input('type'));
    }

    $letters = $query->get();

    // Tentukan judul berdasarkan filter jenis surat
    $typeFilter = $request->input('type');
    $typeLabel = match ($typeFilter) {
        'incoming' => 'Surat Masuk',
        'outgoing' => 'Surat Keluar',
        default => 'Semua Jenis Surat',
    };

    // Muat view ke dalam PDF
    $pdf = Pdf::loadView('letters.pdf', compact('letters', 'typeLabel'));

    // Atur ukuran kertas menjadi A4 dan orientasi menjadi landscape
    $pdf->setPaper('a4', 'landscape');

    // Unduh PDF
    return $pdf->download('daftar_surat.pdf');
}
    
    
}