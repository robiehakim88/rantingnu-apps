<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;
use Barryvdh\DomPDF\Facade\Pdf;


class BudgetController extends Controller
{
    
    
  public function index(Request $request)
{
    $year = $request->input('year'); // Ambil tahun dari request
    $query = Budget::query();

    if ($year) {
        $query->where('year', $year);
    }

    $budgets = $query->get();

    // Kelompokkan data berdasarkan timeframe
    $groupedBudgets = $budgets->groupBy('timeframe')->map(function ($group) {
        return [
            'count' => $group->count(),
            'total_planned_budget' => $group->sum('planned_budget'),
        ];
    });

    return view('budgets.index', compact('budgets', 'year', 'groupedBudgets'));
}
    
    // Menampilkan daftar RAB
   // public function index(Request $request)
    //{
    //    $timeframe = $request->input('timeframe'); // Filter berdasarkan timeframe
    //    $query = Budget::query();

    //    if ($timeframe) {
    //        $query->where('timeframe', $timeframe);
    //    }

    //    $budgets = $query->get();
    //    return view('budgets.index', compact('budgets', 'timeframe'));
    //}
    
    

    // Menampilkan form tambah RAB
    public function create()
    {
        return view('budgets.create');
    }
    
    
    public function store(Request $request)
{
    $validated = $request->validate([
        'year' => 'required|numeric|min:2000|max:' . date('Y'), // Validasi tahun anggaran
        'timeframe' => 'required|in:Mingguan,Bulanan,Tahunan,Insidental',
        'activity_name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'planned_budget' => 'required|numeric|min:0',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
    ]);

    Budget::create($validated);

    return redirect()->route('budgets.index')->with('success', 'RAB berhasil ditambahkan.');
}
    
    
    
    

    // Menyimpan data RAB baru
   // public function store(Request $request)
//    {
  //      $validated = $request->validate([
//            'timeframe' => 'required|in:Mingguan,Bulanan,Tahunan,Insidental',
  //          'activity_name' => 'required|string|max:255',
//            'description' => 'nullable|string',
  //          'planned_budget' => 'required|numeric|min:0',
//            'actual_budget' => 'nullable|numeric|min:0',
 //           'start_date' => 'nullable|date',
  //          'end_date' => 'nullable|date|after_or_equal:start_date',
//        ]);

  //      Budget::create($validated);

//        return redirect()->route('budgets.index')->with('success', 'RAB berhasil ditambahkan.');
 //   }

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


public function update(Request $request, Budget $budget)
{
    $validated = $request->validate([
        'year' => 'required|numeric|min:2000|max:' . date('Y'), // Validasi tahun anggaran
        'timeframe' => 'required|in:Mingguan,Bulanan,Tahunan,Insidental',
        'activity_name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'planned_budget' => 'required|numeric|min:0',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
    ]);

    $budget->update($validated);

    return redirect()->route('budgets.index')->with('success', 'RAB berhasil diperbarui.');
}






    // Memperbarui data RAB
//    public function update(Request $request, Budget $budget)
 //   {
 //       $validated = $request->validate([
 //           'timeframe' => 'required|in:Mingguan,Bulanan,Tahunan,Insidental',
 //           'activity_name' => 'required|string|max:255',
 //           'description' => 'nullable|string',
 //           'planned_budget' => 'required|numeric|min:0',
 //           'actual_budget' => 'nullable|numeric|min:0',
 //           'start_date' => 'nullable|date',
 //           'end_date' => 'nullable|date|after_or_equal:start_date',
 //       ]);

 //       $budget->update($validated);

//        return redirect()->route('budgets.index')->with('success', 'RAB berhasil diperbarui.');
//    }

    // Menghapus data RAB
    public function destroy(Budget $budget)
    {
        $budget->delete();
        return redirect()->route('budgets.index')->with('success', 'RAB berhasil dihapus.');
    }
    
    
//    public function exportPdf()
//{
//    $budgets = Budget::all();

//    $pdf = Pdf::loadView('budgets.pdf', compact('budgets'));
//    return $pdf->download('laporan_rab.pdf');
//}





public function exportPdf($year)
{
    // Ambil data RAB berdasarkan tahun anggaran
    $budgets = Budget::where('year', $year)->get();

    // Kelompokkan data berdasarkan timeframe
    $groupedBudgets = $budgets->groupBy('timeframe');

    // Hitung total anggaran per timeframe
    $totals = $groupedBudgets->map(function ($group) {
        return $group->sum('planned_budget');
    });

    // Kirim data ke view
    $pdf = Pdf::loadView('budgets.pdf', compact('groupedBudgets', 'totals', 'year'));

    // Unduh file PDF dengan nama yang mencakup tahun
    return $pdf->download("laporan_rab_$year.pdf");
}

}