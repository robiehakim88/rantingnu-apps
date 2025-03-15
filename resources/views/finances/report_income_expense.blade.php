@extends('layouts.app')

@section('title', 'Laporan Laba Rugi')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Laporan Laba Rugi</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('finances.report.income-expense') }}" method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-6">
                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate ?? '' }}">
                </div>
                <div class="col-md-6">
                    <label for="end_date" class="form-label">Tanggal Akhir</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate ?? '' }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Filter</button>
            <!-- Tombol Download PDF -->
            <a href="{{ route('finances.report.income-expense.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-success mt-2 ml-2">
            <i class="fas fa-download"></i> Download PDF
</a>
            @if(isset($startDate) && isset($endDate))
           <!-- <a href="{{ route('finances.report.income-expense.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-success mt-2 ml-2">
                <i class="fas fa-download"></i> Download PDF
            </a>-->
            @endif
        </form>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Jenis Transaksi</th>
                    <th>Total Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Pemasukan</td>
                    <td>Rp {{ number_format($totalIncome, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Pengeluaran</td>
                    <td>Rp {{ number_format($totalExpense, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td><strong>Pendapatan Bersih</strong></td>
                    <td><strong>Rp {{ number_format($netIncome, 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection