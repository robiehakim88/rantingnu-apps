<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Laba Rugi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
    
    
</head>
<body>
    <h1 style="text-align: center;">Laporan Laba Rugi</h1>
    <p style="text-align: center;">
        Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}
    </p>

    <!-- Tabel Detail Transaksi -->
    <h3>Detail Transaksi</h3>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis Transaksi</th>
                <th>Deskripsi</th>
                <th colspan="2">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
            <tr>
                <td>{{ \Carbon\Carbon::parse($transaction->date)->format('d F Y') }}</td>
                <td>{{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}</td>
                <td style="text-align: left;">{{ $transaction->description }}</td>
                
                <td border="0">Rp. </td>    
                <td style="text-align: right;">
                    
                    {{ number_format($transaction->amount, 0, ',', '.') }}
                </td>
                
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Ringkasan Total -->
    <h3>Ringkasan</h3>
    <table>
        <tr>
            <th>Total Pemasukan</th>
            <td>Rp {{ number_format($totalIncome, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Total Pengeluaran</th>
            <td>Rp {{ number_format($totalExpense, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Pendapatan Bersih</th>
            <td><strong>Rp {{ number_format($netIncome, 0, ',', '.') }}</strong></td>
        </tr>
    </table>
</body>
</html>