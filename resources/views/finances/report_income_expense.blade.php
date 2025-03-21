@extends('layouts.app')

@section('title', 'Laporan Keuangan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Laporan Keuangan</h3>
    </div>
    <div class="card-body">
        <!-- Form Pemilihan Tahun -->
        <form action="{{ route('finances.report.income-expense') }}" method="GET" class="mb-4">
            <div class="form-group">
                <label for="year">Pilih Tahun:</label>
                <select name="year" id="year" class="form-control" required>
                    @php
                        $years = \App\Models\Finance::selectRaw('YEAR(date) as year')->distinct()->orderByDesc('year')->pluck('year');
                    @endphp
                    @foreach ($years as $y)
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tampilkan Laporan</button>
            <a href="{{ route('finances.report.income-expense.pdf', ['year' => $year]) }}" class="btn btn-success ml-2">
                Download PDF
            </a>
        </form>

        <!-- Tabel Laporan Keuangan -->
        <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th>Total Pemasukan</th>
                    <th>Total Pengeluaran</th>
                    <th>Saldo Bersih</th>
                    <th>Saldo Akumulatif</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($months as $monthData)
                <tr>
                    <td>{{ Carbon\Carbon::parse("{$year}-{$monthData['month']}-01")->format('F') }}</td>
                    <td>Rp {{ number_format($monthData['totalIncome'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($monthData['totalExpense'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($monthData['netIncome'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($monthData['cumulativeBalance'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection