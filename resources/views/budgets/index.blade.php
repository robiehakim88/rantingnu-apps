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
    <div class="card-body">
        <!-- Form Filter -->
        <form action="{{ route('budgets.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <select name="year" class="form-control" onchange="this.form.submit()">
                    <option value="">Pilih Tahun Anggaran</option>
                    @for ($i = date('Y'); $i >= 2000; $i--)
                        <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </form>

        <!-- Tombol Unduh Laporan PDF -->
        <div class="mb-3">
            @if ($year)
                <a href="{{ route('budgets.export_pdf', ['year' => $year]) }}" class="btn btn-primary">
                    <i class="fas fa-download"></i> Unduh Laporan PDF
                </a>
            @else
                <button class="btn btn-secondary" disabled>
                    <i class="fas fa-download"></i> Pilih Tahun Untuk Mengunduh Laporan
                </button>
            @endif
        </div>

        <!-- Grafik Penggunaan Anggaran Berdasarkan Waktu -->
        <div class="card mt-4">
            <div class="card-header">
                <h3 class="card-title">Grafik Penggunaan Anggaran Berdasarkan Waktu</h3>
            </div>
            <div class="card-body">
                <!-- Canvas untuk Pie Chart -->
                <div style="max-width: 400px; margin: auto;">
                    <canvas id="budgetChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Tabel Daftar RAB -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tahun Anggaran</th>
                    <th>Nama Kegiatan</th>
                    <th>Anggaran Direncanakan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($budgets as $index => $budget)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $budget->year }}</td>
                    <td>{{ $budget->activity_name }}</td>
                    <td>Rp {{ number_format($budget->planned_budget, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('budgets.edit', $budget->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('budgets.destroy', $budget->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data RAB.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Script untuk Grafik Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const groupedBudgets = @json($groupedBudgets);

    const ctx = document.getElementById('budgetChart').getContext('2d');
    const budgetChart = new Chart(ctx, {
        type: 'pie', // Pie chart
        data: {
            labels: Object.keys(groupedBudgets), // Nama timeframe (Mingguan, Bulanan, dll.)
            datasets: [
                {
                    label: 'Total Anggaran Direncanakan',
                    data: Object.values(groupedBudgets).map(item => item.total_planned_budget), // Total anggaran per timeframe
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',   // Merah
                        'rgba(54, 162, 235, 0.6)',   // Biru
                        'rgba(75, 192, 192, 0.6)',   // Hijau
                        'rgba(153, 102, 255, 0.6)',  // Ungu
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                    ],
                    borderWidth: 1,
                },
            ],
        },
        options: {
            responsive: true, // Aktifkan mode responsif
            maintainAspectRatio: false, // Biarkan ukuran disesuaikan oleh kontainer
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            return `${label}: Rp ${value.toLocaleString()}`;
                        },
                    },
                },
            },
        },
    });
</script>
@endsection