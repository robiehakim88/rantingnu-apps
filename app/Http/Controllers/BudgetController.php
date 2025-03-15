<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;
use Barryvdh\DomPDF\Facade\Pdf;

class BudgetController extends Controller
{
    // Menampilkan daftar RAB
    public function index(Request $request)
    {
        $timeframe = $request->input('timeframe'); // Filter berdasarkan timeframe
        $query = Budget::query();

        if ($timeframe) {
            $query->where('timeframe', $timeframe);
        }

        $budgets = $query->get();
        return view('budgets.index', compact('budgets', 'timeframe'));
    }
    
    

    // Menampilkan form tambah RAB
    public function create()
    {
        return view('budgets.create');
    }

    // Menyimpan data RAB baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'timeframe' => 'required|in:Mingguan,Bulanan,Tahunan,Insidental',
            'activity_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'planned_budget' => 'required|numeric|min:0',
            'actual_budget' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        Budget::create($validated);

        return redirect()->route('budgets.index')->with('success', 'RAB berhasil ditambahkan.');
    }

    // Menampilkan detail RAB
    public function show(Budget $budget)
    {
        return view('budgets.show', compact('budget'));
    }

    // Menampilkan form edit RAB
    public function edit(Budget $budget)
    {
        return view('budgets.edit', compact('budget'));
    }

    // Memperbarui data RAB
    public function update(Request $request, Budget $budget)
    {
        $validated = $request->validate([
            'timeframe' => 'required|in:Mingguan,Bulanan,Tahunan,Insidental',
            'activity_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'planned_budget' => 'required|numeric|min:0',
            'actual_budget' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $budget->update($validated);

        return redirect()->route('budgets.index')->with('success', 'RAB berhasil diperbarui.');
    }

    // Menghapus data RAB
    public function destroy(Budget $budget)
    {
        $budget->delete();
        return redirect()->route('budgets.index')->with('success', 'RAB berhasil dihapus.');
    }
    
    
    public function exportPdf()
{
    $budgets = Budget::all();

    $pdf = Pdf::loadView('budgets.pdf', compact('budgets'));
    return $pdf->download('laporan_rab.pdf');
}
}