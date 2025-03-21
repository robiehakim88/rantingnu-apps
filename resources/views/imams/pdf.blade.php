<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rekap Imam Taraweh</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .kop-surat img {
            width: 100%; /* Lebar gambar 80% dari lebar halaman */
            max-width: 1000px; /* Batas maksimal lebar gambar */
            height: auto; /* Tinggi otomatis menyesuaikan */
        }
        /* Styling untuk footer (nomor halaman) */
        .footer {
            position: fixed;
            bottom: 10px;
            right: 20px;
            font-size: 10px; /* Ukuran huruf lebih kecil */
            text-align: right;
        }
    </style>
</head>
<body>
    <!-- Kop Surat -->
    <div class="kop-surat" style="text-align: center; margin-bottom: 20px;">
        <img src="{{ public_path('images/kop_bukti.JPG') }}" alt="Kop Surat">
    </div>
    <h1>Rekap Imam Taraweh Tahun {{ $yearHijriyah ?? 'Semua Tahun' }}</h1>
    <table>
        <thead>
            <tr>
                <th>No.</th> <!-- Kolom Nomor Urut -->
                <th>Nama Masjid/Musholla</th>
                <th>Nama Imam Taraweh</th>
                <th>Alamat</th>
                
            </tr>
        </thead>
        <tbody>
            @forelse ($imams as $index => $imam)
            <tr>
                <td>{{ $loop->iteration }}</td> <!-- Nomor Urut -->
                <td>{{ $imam->place->name }}</td>
                <td>{{ $imam->name }}</td>
                <td>{{ $imam->place->address }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada data.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Footer dengan Nomor Halaman -->
    <div class="footer">
        Halaman <span class="page"></span> dari <span class="topage"></span>
    </div>
</body>
</html>