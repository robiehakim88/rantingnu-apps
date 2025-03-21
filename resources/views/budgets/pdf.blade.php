<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan RAB Tahun {{ $year }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* Memastikan lebar kolom tetap konsisten */
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            word-wrap: break-word; /* Memastikan teks panjang tidak melebihi lebar kolom */
        }
        th {
            background-color: #f2f2f2;
        }
        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .grand-total {
            font-size: 1.2em;
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
        }
        .kop-surat img {
            width: 100%; /* Gambar akan menyesuaikan lebar halaman */
            max-width: 800px; /* Batas maksimal lebar gambar untuk kertas portrait */
            height: auto; /* Tinggi otomatis menyesuaikan */
            margin: 10px auto; /* Memberi ruang di atas dan bawah gambar */
            display: block;
        }
        /* Lebar kolom tetap */
        th:nth-child(1), td:nth-child(1) {
            width: 10%; /* Kolom No */
        }
        th:nth-child(2), td:nth-child(2) {
            width: 60%; /* Kolom Nama Kegiatan */
            text-align: left; /* Perataan teks ke kiri */
        }
        th:nth-child(3), td:nth-child(3) {
            width: 10%; /* Kolom Anggaran Direncanakan */
            text-align: right; /* Perataan teks ke kanan */
        }
        th:nth-child(4), td:nth-child(4) {
            width: 20%; /* Kolom Anggaran Direncanakan */
            text-align: right; /* Perataan teks ke kanan */
        }
    </style>
</head>
<body>
    
     <!-- Kop Surat -->
    <div class="kop-surat">
        <img src="{{ public_path('images/kop-portrait.png') }}" alt="Kop Surat">
    </div>
    
    <h3 style="text-align: center;">Rencana Anggaran Biaya (RAB) <br />Ranting NU Pelem Kertosono <br />Tahun {{ $year }}</h3>

    @if ($groupedBudgets->isEmpty())
        <p>Tidak ada data RAB untuk tahun {{ $year }}.</p>
    @else
        <!-- Loop untuk setiap timeframe -->
        @foreach ($groupedBudgets as $timeframe => $budgetGroup)
            <h3>Agenda Kegiatan {{ $timeframe }}</h3>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kegiatan</th>
                        <th colspan="2">Anggaran Direncanakan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($budgetGroup as $index => $budget)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $budget->activity_name }}</td>
                        <td>Rp</td>
                        <td> {{ number_format($budget->planned_budget, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="2"><strong>Total {{ $timeframe }}</strong></td>
                        <td colspan="2" style="text-align: right;"><strong> {{ number_format($totals[$timeframe], 0, ',', '.') }}</strong></td>
                    </tr>
                </tbody>
            </table>
        @endforeach

        <!-- Total Keseluruhan -->
        <div class="grand-total">
            <strong>Total Keseluruhan: Rp {{ number_format($totals->sum(), 0, ',', '.') }}</strong>
        </div>
    @endif
</body>
</html>