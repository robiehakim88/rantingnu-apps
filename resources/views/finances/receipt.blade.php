<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bukti Penerimaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 100%; /* Gambar akan menyesuaikan lebar halaman */
            max-width: 1000px; /* Batas maksimal lebar gambar */
            height: auto; /* Tinggi otomatis menyesuaikan */
            margin: 0 auto; /* Gambar berada di tengah */
            display: block;
        }
        .header h1 {
            font-size: 1.5em;
            margin-top: 10px; /* Jarak antara gambar dan judul */
        }
        .details {
            margin-top: 20px;
        }
        .details table {
            width: 100%;
            border-collapse: collapse;
        }
        .details th, .details td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
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
    <!-- Kop Surat -->
    <div class="header">
        <img src="{{ public_path('images/kop_bukti.JPG') }}" alt="Kop Surat">
        <h1>Bukti Penerimaan</h1>
        <p>ID Transaksi: {{ $finance->id }}</p>
    </div>

    <div class="details">
        <table>
            <tr>
                <th>Deskripsi</th>
                <td>{{ $finance->description }}</td>
            </tr>
            <tr>
                <th>Tipe</th>
                <td>
                    @if ($finance->type === 'expense')
                        Pengeluaran
                    @else
                        Pemasukan
                    @endif
                </td>
            </tr>
            <tr>
                <th>Jumlah</th>
                <td>Rp {{ number_format($finance->amount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Terbilang</th>
                <td>({{ terbilang($finance->amount) }} rupiah)</td>
            </tr>
            <tr>
                <th>Tanggal</th>
                <td>
                    @php
                        // Format tanggal ke bahasa Indonesia
                        $bulanIndonesia = [
                            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                        ];
                        $tanggal = \Carbon\Carbon::parse($finance->date);
                        $hari = $tanggal->day;
                        $bulan = $bulanIndonesia[$tanggal->month - 1];
                        $tahun = $tanggal->year;
                        echo "$hari $bulan $tahun";
                    @endphp
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Dicetak pada: 
            @php
                // Format tanggal cetak ke bahasa Indonesia
                $tanggalCetak = now();
                $hariCetak = $tanggalCetak->day;
                $bulanCetak = $bulanIndonesia[$tanggalCetak->month - 1];
                $tahunCetak = $tanggalCetak->year;
                echo "$hariCetak $bulanCetak $tahunCetak " . $tanggalCetak->format('H:i:s');
            @endphp
        </p>
    </div>

    <!-- Tanda Tangan -->
    <table align="center" border="0">
        <tr>
            <td>
                <div style="margin-right: 20px;">
                    <p align="center"><strong>Yang Menyerahkan</strong></p><br /><br />
                    <p align="center">Agus Purwantoro<br />Bendahara Ranting</p>
                </div>
            </td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>
                <div>
                    <p align="center"><strong>Yang Menerima</strong></p><br /><br />
                    <p>(................................................)</p>
                </div>
            </td>
        </tr>
    </table>

    <!-- Fungsi Terbilang -->
    @php
    function terbilang($number)
    {
        $units = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];
        if ($number < 12) {
            return $units[$number];
        }
        if ($number < 20) {
            return terbilang($number - 10) . ' belas';
        }
        if ($number < 100) {
            return terbilang(floor($number / 10)) . ' puluh ' . terbilang($number % 10);
        }
        if ($number < 200) {
            return 'seratus ' . terbilang($number - 100);
        }
        if ($number < 1000) {
            return terbilang(floor($number / 100)) . ' ratus ' . terbilang($number % 100);
        }
        if ($number < 2000) {
            return 'seribu ' . terbilang($number - 1000);
        }
        if ($number < 1000000) {
            return terbilang(floor($number / 1000)) . ' ribu ' . terbilang($number % 1000);
        }
        if ($number < 1000000000) {
            return terbilang(floor($number / 1000000)) . ' juta ' . terbilang($number % 1000000);
        }
        if ($number < 1000000000000) {
            return terbilang(floor($number / 1000000000)) . ' miliar ' . terbilang($number % 1000000000);
        }
        return 'Angka terlalu besar';
    }
    @endphp
</body>
</html>