@extends('layouts.app')

@section('title', 'Laporan Arus Kas Operasional')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Laporan Arus Kas Operasional</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('finances.report.cash-flow') }}" method="GET" class="mb-3">
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
        </form>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Jenis Transaksi</th>
                    <th>Total Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cashFlow as $item)
                <tr>
                    <td>{{ $item->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}</td>
                    <td>Rp {{ number_format($item->total_amount, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection