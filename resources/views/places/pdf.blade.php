<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Masjid dan Musholla</title>
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
        .map-image {
            width: 100%;
            height: auto;
            margin-top: 20px;
        }
        .kop-surat img {
            width: 100%; /* Gambar akan menyesuaikan lebar halaman */
            max-width: 800px; /* Batas maksimal lebar gambar untuk kertas portrait */
            height: auto; /* Tinggi otomatis menyesuaikan */
            margin: 10px auto; /* Memberi ruang di atas dan bawah gambar */
            display: block;
        }
    </style>
</head>
<body>
    <!-- Kop Surat -->
    <div class="kop-surat">
        <img src="{{ public_path('images/kop-portrait.png') }}" alt="Kop Surat">
    </div>
    <h2>Daftar Masjid dan Musholla di Wilayah Ranting NU Pelem</h2>

    <!-- Tabel Data -->
    <table>
        <thead>
            <tr>
                <th>No</th> <!-- Kolom Nomor Urut -->
                <th>Nama</th>
                <th>Jenis</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($places as $place)
            <tr>
                <td>{{ $loop->iteration }}</td> <!-- Nomor Urut -->
                <td>{{ $place->name }}</td>
                <td>{{ ucfirst($place->type) }}</td>
                <td>{{ $place->address }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>