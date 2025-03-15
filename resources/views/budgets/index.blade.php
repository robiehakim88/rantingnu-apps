@extends('layouts.app')

@section('title', 'Rencana Anggaran Biaya (RAB)')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar RAB</h3>
        <div class="float-right">
            <a href="{{ route('budgets.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah RAB
            </a>
        </div>
    </div>
    @foreach ($budgets as $budget)
    @if ($budget->remaining_budget <= 0)
        <div class="alert alert-danger" role="alert">
            Sisa anggaran untuk kegiatan "{{ $budget->activity_name }}" sudah habis atau melebihi batas!
        </div>
    @elseif ($budget->remaining_budget <= $budget->planned_budget * 0.1)
        <div class="alert alert-warning" role="alert">
            Sisa anggaran untuk kegiatan "{{ $budget->activity_name }}" hampir habis!
        </div>
    @endif
@endforeach
    <div class="card-body">
        <!-- Form Filter -->
        <form action="{{ route('budgets.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <select name="timeframe" class="form-control" onchange="this.form.submit()">
                    <option value="">Semua Waktu</option>
                    <option value="Mingguan" {{ $timeframe === 'Mingguan' ? 'selected' : '' }}>Mingguan</option>
                    <option value="Bulanan" {{ $timeframe === 'Bulanan' ? 'selected' : '' }}>Bulanan</option>
                    <option value="Tahunan" {{ $timeframe === 'Tahunan' ? 'selected' : '' }}>Tahunan</option>
                    <option value="Insidental" {{ $timeframe === 'Insidental' ? 'selected' : '' }}>Insidental</option>
                </select>
            </div>
        </form>

        <!-- Tabel Daftar RAB -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Waktu</th>
                    <th>Nama Kegiatan</th>
                    <th>Anggaran Direncanakan</th>
                    <th>Anggaran Terserap</th>
                    <th>Sisa Anggaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($budgets as $index => $budget)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $budget->timeframe }}</td>
                    <td>{{ $budget->activity_name }}</td>
                    <td>Rp {{ number_format($budget->planned_budget, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($budget->actual_budget ?? 0, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($budget->remaining_budget, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('budgets.edit', $budget->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('budgets.destroy', $budget->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        
        
        

<?php
// Siapkan data JSON di PHP terlebih dahulu
$budgetData = $budgets->map(function ($budget) {
    return [
        'activity_name' => $budget->activity_name,
        'planned_budget' => $budget->planned_budget,
        'actual_budget' => $budget->actual_budget ?? 0,
    ];
})->toJson();
?>
<!-- Grafik Penggunaan Anggaran -->
<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title">Grafik Penggunaan Anggaran</h3>
    </div>
    <div class="card-body">
        <canvas id="budgetChart" width="400" height="200"></canvas>
    </div>
</div>

<script>
    // Data untuk grafik (ambil dari PHP)
    const budgetData = {!! $budgetData !!};

    // Inisialisasi Chart.js
    const ctx = document.getElementById('budgetChart').getContext('2d');
    const budgetChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: budgetData.map(item => item.activity_name),
            datasets: [
                {
                    label: 'Anggaran Direncanakan',
                    data: budgetData.map(item => item.planned_budget),
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                },
                {
                    label: 'Anggaran Terserap',
                    data: budgetData.map(item => item.actual_budget),
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                },
            ],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function (value) {
                            return 'Rp ' + value.toLocaleString();
                        },
                    },
                },
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return context.dataset.label + ': Rp ' + context.raw.toLocaleString();
                        },
                    },
                },
            },
        },
    });
</script>
        
        
    </div>
</div>
@endsection