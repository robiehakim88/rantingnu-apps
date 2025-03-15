<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan RAB</title>
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
    <h1 style="text-align: center;">Laporan Rencana Anggaran Biaya (RAB)</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kegiatan</th>
                <th>Anggaran Direncanakan</th>
                <th>Anggaran Terserap</th>
                <th>Sisa Anggaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($budgets as $index => $budget)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $budget->activity_name }}</td>
                <td>Rp {{ number_format($budget->planned_budget, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($budget->actual_budget ?? 0, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($budget->remaining_budget, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>