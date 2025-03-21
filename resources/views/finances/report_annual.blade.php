<!-- resources/views/finances/report_annual.blade.php -->
@extends('layouts.app')

@section('title', 'Laporan Keuangan Tahunan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Laporan Keuangan Tahunan</h3>
    </div>
    <div class="card-body">
        <!-- Tabel Laporan Keuangan Tahunan -->
        <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Tahun</th>
                    <th>Total Pemasukan</th>
                    <th>Total Pengeluaran</th>
                    <th>Saldo Bersih</th>
                    <th>Saldo Akumulatif</th> <!-- Kolom baru -->
                </tr>
            </thead>
            <tbody>
                @foreach ($annualReports as $report)
                <tr>
                    <td>{{ $report['year'] }}</td>
                    <td>Rp {{ number_format($report['totalIncome'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($report['totalExpense'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($report['netIncome'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($report['cumulativeBalance'], 0, ',', '.') }}</td> <!-- Saldo akumulatif -->
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection