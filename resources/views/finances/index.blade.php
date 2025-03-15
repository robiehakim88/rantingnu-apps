@extends('layouts.app')

@section('title', 'Manajemen Keuangan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Keuangan</h3>
        <div class="float-right d-flex align-items-center">
            <!-- Form Pencarian -->
            <form action="{{ route('finances.index') }}" method="GET" class="form-inline mr-2">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari transaksi..." value="{{ $search ?? '' }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Tombol Tambah Keuangan -->
            <a href="{{ route('finances.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Transaksi
            </a>
        </div>
    </div>
    <div class="card-body">
        @if ($search && $finances->isEmpty())
        <div class="alert alert-warning">
            Tidak ada transaksi yang ditemukan untuk kata kunci "<strong>{{ $search }}</strong>".
        </div>
        @endif
        <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Jenis</th>
                    <th>Deskripsi</th>
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($finances as $finance)
                <tr>
                    <td>{{ $finance->type_translated }}</td>
                    <td>{{ $finance->description }}</td>
                    <td>Rp {{ number_format($finance->amount, 0, ',', '.') }}</td>
                    <td>{{ $finance->date ? \Carbon\Carbon::parse($finance->date)->format('d-m-Y') : '-' }}</td>
                    <td>
                        <a href="{{ route('finances.edit', $finance->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('finances.destroy', $finance->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection