<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Surat</title>
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

        /* Styling untuk kop surat */
        .kop-surat img {
            width: 100%; /* Lebar gambar 80% dari lebar halaman */
            max-width: 900px; /* Batas maksimal lebar gambar */
            height: auto; /* Tinggi otomatis menyesuaikan */
            margin: 10px auto; /* Memberi ruang di atas dan bawah gambar */
            display: block;
        }

        /* Styling tambahan untuk mode cetak (landscape) */
        @media print {
            body {
                width: 100%;
                height: auto;
            }
            table {
                font-size: 12px; /* Mengurangi ukuran font agar muat */
            }
            .kop-surat img {
                width: 80%; /* Lebar gambar 80% dari lebar halaman */
                max-width: 900px; /* Batas maksimal lebar gambar */
                height: auto; /* Tinggi otomatis menyesuaikan */
            }
        }
    </style>
</head>
<body>
    <!-- Kop Surat -->
    <div class="kop-surat" style="text-align: center; margin-bottom: 20px;">
        <img src="{{ public_path('images/kop_bukti.JPG') }}" alt="Kop Surat">
    </div>

    <!-- Judul Dinamis -->
    <h1>Daftar {{ $typeLabel }}</h1>

    <!-- Tabel Data -->
    <table>
        <thead>
            <tr>
                <th>Jenis</th>
                <th>Nomor Surat</th>
                <th>Asal Surat</th>
                <th>Tujuan</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($letters as $letter)
            <tr>
                <td>{{ $letter->type === 'incoming' ? 'Surat Masuk' : 'Surat Keluar' }}</td>
                <td>{{ $letter->nomor_surat ?? '-' }}</td>
                <td>{{ $letter->asal_surat ?? '-' }}</td>
                <td>{{ $letter->tujuan ?? '-' }}</td>
                <td>{{ $letter->title }}</td>
                <td>{{ Str::limit($letter->description, 50) }}</td>
                <td>{{ $letter->date ? \Carbon\Carbon::parse($letter->date)->format('d-m-Y') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>