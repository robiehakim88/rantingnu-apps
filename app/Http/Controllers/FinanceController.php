<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Finance;
use Barryvdh\DomPDF\Facade\Pdf;

class FinanceController extends Controller
{
    // Method-method CRUD (index, create, store, edit, update, destroy)
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Finance::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', '%' . $search . '%')
                  ->orWhere('type', 'like', '%' . $search . '%');
            });
        }

        $finances = $query->get();
        return view('finances.index', compact('finances', 'search'));
    }

    public function create()
    {
        return view('finances.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|in:income,expense',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'budget_id' => 'nullable|exists:budgets,id',
            'date' => 'nullable|date',
        ]);

        Finance::create($validated);
        
         // Update actual_budget di tabel budgets
    if ($finance->budget_id) {
        $budget = Budget::find($finance->budget_id);
        $budget->increment('actual_budget', $finance->amount);
    }

    return redirect()->route('finances.index')->with('success', 'Transaksi berhasil ditambahkan.');
}
        
  

    public function edit(Finance $finance)
    {
        return view('finances.edit', compact('finance'));
    }

    public function update(Request $request, Finance $finance)
    {
        $validated = $request->validate([
            'type' => 'required|string|in:income,expense',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'date' => 'nullable|date',
        ]);

        $finance->update($validated);

        return redirect()->route('finances.index')->with('success', 'Data keuangan berhasil diperbarui.');
    }

    public function destroy(Finance $finance)
    {
        $finance->delete();
        return redirect()->route('finances.index')->with('success', 'Data keuangan berhasil dihapus.');
    }
    
    
    
    public function reportIncomeExpense(Request $request)
    {
        // Ambil parameter tanggal dari request (opsional)
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // Query untuk menghitung total pemasukan dan pengeluaran
        $query = Finance::query();
    
        if ($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }
    
        $totalIncome = $query->where('type', 'income')->sum('amount');
        $totalExpense = $query->where('type', 'expense')->sum('amount');
        $netIncome = $totalIncome - $totalExpense;
    
        // Kirim data ke view
        return view('finances.report_income_expense', compact('totalIncome', 'totalExpense', 'netIncome', 'startDate', 'endDate'));
    }
    
    
    
    public function reportCashFlow(Request $request)
    {
        // Ambil parameter tanggal dari request (opsional)
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // Query untuk mengelompokkan transaksi berdasarkan jenis
        $query = Finance::query();
    
        if ($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }
    
        $cashFlow = $query->selectRaw('type, SUM(amount) as total_amount')
                          ->groupBy('type')
                          ->get();
    
        // Kirim data ke view
        return view('finances.report_cash_flow', compact('cashFlow', 'startDate', 'endDate'));
    }
    
    
    
    public function downloadIncomeExpensePdf(Request $request)
    {
        // Ambil parameter tanggal dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // Validasi bahwa tanggal tidak kosong
        if (!$startDate || !$endDate) {
            abort(400, 'Tanggal mulai dan akhir harus diisi.');
        }
    
        // Query untuk mengambil semua transaksi dalam rentang tanggal
        $transactions = Finance::whereBetween('date', [$startDate, $endDate])
                               ->orderBy('date') // Urutkan berdasarkan tanggal
                               ->get();
    
        // Hitung total pemasukan dan pengeluaran
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $netIncome = $totalIncome - $totalExpense;
    
        // Kirim data ke view PDF
        $data = [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'transactions' => $transactions,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'netIncome' => $netIncome,
        ];
    
        // Load view PDF dengan orientasi landscape
        $pdf = Pdf::loadView('finances.report_income_expense_pdf', $data)
               ->setPaper('a4', 'landscape'); // Ubah orientasi ke landscape
    
        // Unduh file PDF
        return $pdf->download('laporan-laba-rugi-' . $startDate . '-to-' . $endDate . '.pdf');
    }
    
    
    
}