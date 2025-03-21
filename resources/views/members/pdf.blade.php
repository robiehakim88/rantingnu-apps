<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
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
    </style>
</head>
<body>
    <h1>{{ $title }} Ranting NU Pelem Kertosono</h1>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th>Tanggal Lahir</th>
                <th>Usia</th>
                <th>Jabatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $member)
            <tr>
                <td>{{ $member->name }}</td>
                <td>{{ $member->gender === 'male' ? 'Laki-laki' : ($member->gender === 'female' ? 'Perempuan' : '-') }}</td>
                <td>{{ $member->email }}</td>
                <td>{{ $member->phone }}</td>
                <td>{{ $member->address }}</td>
                <td>{{ $member->formatted_date_of_birth }}</td>
                <td>{{ $member->age ?? '-' }} Tahun</td>
                <td>{{ $member->role->name ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>