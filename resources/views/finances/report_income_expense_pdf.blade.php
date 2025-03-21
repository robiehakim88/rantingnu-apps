<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laporan Keuangan Bulanan {{ $year }}</title>
<style>
body {
font-family: Arial, sans-serif;
margin: 20px;
}
h1 {
text-align: center;
}
h3 {
margin-top: 20px;
margin-bottom: 10px;
}
table {
width: 100%;
border-collapse: collapse;
margin-top: 10px;
}
th, td {
border: 1px solid #ddd;
padding: 8px;
text-align: left;
}
th {
background-color: #f4f4f4;
}
.income {
color: green;
}
.expense {
color: red;
}
.summary {
margin-top: 20px;
font-weight: bold;
}
.kop-surat img {
width: 100%; /* Gambar akan menyesuaikan lebar halaman */
max-width: 1000px; /* Batas maksimal lebar gambar */
height: auto; /* Tinggi otomatis menyesuaikan */
margin: 0 auto; /* Gambar berada di tengah */
display: block;
}
.signatures {
margin-top: 40px;
display: flex;
justify-content: space-between;
}
.signatures div {
text-align: center;
width: 45%;
border-top: 1px solid #000;
padding-top: 10px;
}
</style>
</head>
<body>
@foreach ($monthlyReports as $index => $report)
<!-- Mulai halaman baru untuk setiap bulan -->
@if ($index > 0)
<div style="page-break-before: always;"></div>
@endif

<!-- Kop Surat -->
<div class="kop-surat">
<img src="{{ public_path('images/kop_laporan.JPG') }}" alt="Kop Surat">
</div>

<h3 align="center">Laporan Keuangan <br />Bulan: {{ \Carbon\Carbon::parse("{$year}-{$report['month']}-01")->translatedFormat('F') }} {{ $year }}</h3>

<!-- Tabel Transaksi -->
<table>
<thead>
<tr>
<th>Tanggal</th>
<th>Jenis Transaksi</th>
<th>Deskripsi</th>
<th>Jumlah</th>
<th>Saldo</th>
</tr>
</thead>
<tbody>
@foreach ($report['transactions'] as $transaction)
<tr>
<td>{{ \Carbon\Carbon::parse($transaction->date)->translatedFormat('d F Y') }}</td>
<td class="{{ $transaction->type === 'income' ? 'income' : 'expense' }}">
{{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
</td>
<td>{{ $transaction->description }}</td>
<td style="text-align:right;">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
<td style="text-align:right;">Rp {{ number_format($transaction->balance, 0, ',', '.') }}</td>
</tr>
@endforeach
</tbody>
</table>

<!-- Ringkasan Bulanan -->
<div class="summary">
<p>Total Pemasukan: Rp {{ number_format($report['totalIncome'], 0, ',', '.') }} -- Total Pengeluaran: Rp {{ number_format($report['totalExpense'], 0, ',', '.') }}</p>
<p>Saldo Akhir Bulan Ini: Rp {{ number_format($report['monthlyBalance'], 0, ',', '.') }} -- Saldo Kumulatif: Rp {{ number_format($report['cumulativeBalance'], 0, ',', '.') }}</p>
</div>

<!-- Tanda Tangan -->
<table align="center" border="0">
<tr>
<td>
<img src="{{ public_path('images/ttd_siswanto.JPG') }}" alt="Siswanto">
</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>
<img src="{{ public_path('images/ttd_agus_purwantoro.JPG') }}" alt="Agus Purwantoro">
</td>
</tr>
</table>
@endforeach
</body>
</html>