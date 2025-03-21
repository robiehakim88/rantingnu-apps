<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Finance;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;


class FinanceController extends Controller
{
    
    // Method-method CRUD (index, create, store, edit, update, destroy)
public function index(Request $request)
{
    // Query dasar
    $query = Finance::query();

    // Filter berdasarkan pencarian
    if ($request->has('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('description', 'like', '%' . $request->input('search') . '%')
              ->orWhere('amount', 'like', '%' . $request->input('search') . '%');
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

    // Filter berdasarkan jenis transaksi
    if ($request->has('type') && $request->input('type')) {
        $query->where('type', $request->input('type'));
    }

    // Paginate hasil query
    $finances = $query->paginate(1000)->withQueryString();

    return view('finances.index', compact('finances'));
}
    
    
    
    
   
    
    
    
    

   public function create()
{
    return view('finances.create');
}


public function store(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'type' => 'required|string|in:income,expense',
        'description' => 'nullable|string',
        'amount' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/', // Angka positif dengan maksimal 2 desimal
        'date' => 'required|date', // Tanggal wajib diisi
    ]);

    // Simpan data ke database
    $finance = Finance::create($validated);

    // Update actual_budget di tabel budgets jika budget_id ada
    if ($finance->budget_id) {
        $budget = Budget::find($finance->budget_id);
        if ($budget) {
            $budget->increment('actual_budget', $finance->amount);
        }
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
    // Ambil tahun dari request atau gunakan tahun saat ini jika tidak dipilih
    $year = $request->input('year', date('Y'));

    // Ambil data pemasukan dan pengeluaran per bulan
    $monthlyData = Finance::selectRaw('MONTH(date) as month')
        ->selectRaw('SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as total_income')
        ->selectRaw('SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as total_expense')
        ->whereYear('date', $year)
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();

    // Proses data untuk ditampilkan di view
    $months = [];
    $cumulativeBalance = 0; // Variabel untuk menyimpan saldo akumulatif

    foreach ($monthlyData as $data) {
        $totalIncome = $data->total_income ?? 0;
        $totalExpense = $data->total_expense ?? 0;
        $netIncome = $totalIncome - $totalExpense;

        // Hitung saldo akumulatif
        $cumulativeBalance += $netIncome;

        // Simpan data bulan
        $months[] = [
            'month' => $data->month,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'netIncome' => $netIncome,
            'cumulativeBalance' => $cumulativeBalance,
        ];
    }

    // Kirim data ke view
    return view('finances.report_income_expense', compact('months', 'year'));
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
    // Set locale ke bahasa Indonesia untuk Carbon
    \Carbon\Carbon::setLocale('id');

    // Ambil tahun dari input atau gunakan tahun saat ini jika tidak ada input
    $year = $request->input('year', date('Y'));

    // Inisialisasi saldo awal tahun
    $cumulativeBalance = 0;

    // Data bulanan dengan transaksi dan saldo akhir
    $monthlyReports = [];

    for ($i = 1; $i <= 12; $i++) {
        $month = str_pad($i, 2, '0', STR_PAD_LEFT);
        $startDate = "$year-$month-01";
        $endDate = Carbon::parse("$year-$month-01")->endOfMonth()->format('Y-m-d');

        // Ambil semua transaksi dalam bulan tertentu
        $transactions = Finance::whereBetween('date', [$startDate, $endDate])
                               ->orderBy('date')
                               ->get();

        // Hitung total pemasukan dan pengeluaran
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');

        // Hitung saldo akhir bulan ini
        $monthlyBalance = $totalIncome - $totalExpense;
        $cumulativeBalance += $monthlyBalance;

        // Hitung saldo per transaksi
        $currentBalance = $cumulativeBalance - $monthlyBalance; // Saldo awal bulan
        foreach ($transactions as $transaction) {
            if ($transaction->type === 'income') {
                $currentBalance += $transaction->amount;
            } else {
                $currentBalance -= $transaction->amount;
            }
            $transaction->balance = $currentBalance; // Tambahkan saldo ke objek transaksi
        }

        // Simpan data bulan ini ke array
        $monthlyReports[] = [
            'month' => $month,
            'transactions' => $transactions,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'monthlyBalance' => $monthlyBalance,
            'cumulativeBalance' => $cumulativeBalance,
        ];
    }

    // Kirim data ke view untuk PDF
    $pdf = Pdf::loadView('finances.report_income_expense_pdf', compact('monthlyReports', 'year'));

    // Set orientasi landscape dan ukuran kertas A4
    $pdf->setPaper('A4', 'landscape');

    // Unduh file PDF
    return $pdf->download("laporan_keuangan_bulanan_$year.pdf");
}
    
public function reportAnnual()
{
    // Ambil daftar tahun unik dari database, diurutkan dari tahun terlama ke terbaru
    $years = Finance::selectRaw('YEAR(date) as year')->distinct()->orderBy('year')->pluck('year');

    // Hitung total pemasukan, pengeluaran, dan saldo bersih untuk setiap tahun
    $annualReports = [];
    $cumulativeBalance = 0; // Variabel untuk menyimpan saldo akumulatif

    foreach ($years as $year) {
        $totalIncome = Finance::whereYear('date', $year)
                              ->where('type', 'income')
                              ->sum('amount');
        $totalExpense = Finance::whereYear('date', $year)
                               ->where('type', 'expense')
                               ->sum('amount');
        $netIncome = $totalIncome - $totalExpense;

        // Tambahkan saldo bersih tahun ini ke saldo akumulatif
        $cumulativeBalance += $netIncome;

        $annualReports[] = [
            'year' => $year,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'netIncome' => $netIncome,
            'cumulativeBalance' => $cumulativeBalance, // Saldo akumulatif
        ];
    }

    return view('finances.report_annual', compact('annualReports'));
}

public function filterByYearMonth(Request $request)
{
    $year = $request->input('year', date('Y'));
    $month = $request->input('month', date('m'));

    $query = Finance::query();
    $query->whereYear('date', $year)
          ->whereMonth('date', $month);

    $finances = $query->get();

    return view('finances.index', compact('finances', 'year', 'month'));
}



public function printReceipt($id)
{
    // Ambil data transaksi berdasarkan ID
    $finance = Finance::findOrFail($id);

    // Pastikan transaksi adalah pengeluaran
    if ($finance->type !== 'expense') {
        abort(403, 'Aksi ini hanya tersedia untuk transaksi pengeluaran.');
    }

    // Konversi kolom date ke objek Carbon
    $finance->date = \Carbon\Carbon::parse($finance->date);

    // Generate PDF dengan orientasi landscape
    $pdf = Pdf::loadView('finances.receipt', compact('finance'))
               ->setPaper('a4', 'landscape'); // Atur ukuran kertas dan orientasi

    // Unduh atau tampilkan PDF
    return $pdf->stream("bukti_penerimaan_{$finance->id}.pdf");
}
    
}