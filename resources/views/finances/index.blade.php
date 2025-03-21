@extends('layouts.app')

@section('title', 'Manajemen Keuangan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Keuangan</h3>
        <div class="float-right d-flex align-items-center">
            <!-- Form Filter Tahun, Bulan, dan Jenis Transaksi -->
            <form action="{{ route('finances.index') }}" method="GET" class="form-inline mr-2">
                <div class="form-group">
                    <label for="year">Tahun:</label>
                    <select name="year" id="year" class="form-control">
                        <option value="">Semua Tahun</option>
                        @for ($i = 2023; $i <= date('Y'); $i++)
                            <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="form-group">
                    <label for="month">Bulan:</label>
                    <select name="month" id="month" class="form-control">
                        <option value="">Semua Bulan</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ request('month') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::parse("2023-{$i}-01")->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="form-group">
                    <label for="type">Jenis Transaksi:</label>
                    <select name="type" id="type" class="form-control">
                        <option value="">Semua Jenis</option>
                        <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
                        <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>

            <!-- Form Pencarian -->
            <form action="{{ route('finances.index') }}" method="GET" class="form-inline mr-2">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari transaksi..." value="{{ request('search') }}">
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
        @if (request('search') && $finances->isEmpty())
        <div class="alert alert-warning">
            Tidak ada transaksi yang ditemukan untuk kata kunci "<strong>{{ request('search') }}</strong>".
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
                            <button type="submit" class="btn btn-sm btn-danger ml-2" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                        </form>
                        @if ($finance->type === 'expense')
                            <a href="{{ route('finances.print_receipt', $finance->id) }}" class="btn btn-sm btn-info ml-2" target="_blank">
                                Cetak Bukti
                            </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection