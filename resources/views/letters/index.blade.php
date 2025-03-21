@extends('layouts.app')

@section('title', 'Surat Menyurat')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Surat</h3>
        <div class="float-right d-flex align-items-center">
            <!-- Form Pencarian -->
            <form action="{{ route('letters.index') }}" method="GET" class="form-inline mr-2">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari surat..." value="{{ $search ?? '' }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Tombol Tambah Surat -->
            <a href="{{ route('letters.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Surat
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Form Filter -->
        <form action="{{ route('letters.index') }}" method="GET" class="mb-3">
            <div class="row">
                <!-- Filter Tahun -->
                <div class="col-md-3">
                    <label for="year">Tahun</label>
                    <select name="year" id="year" class="form-control">
                        <option value="">Semua Tahun</option>
                        @foreach ($years as $year)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Bulan -->
                <div class="col-md-3">
                    <label for="month">Bulan</label>
                    <select name="month" id="month" class="form-control">
                        <option value="">Semua Bulan</option>
                        @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                        </option>
                        @endfor
                    </select>
                </div>

                <!-- Filter Jenis Surat -->
                <div class="col-md-3">
                    <label for="type">Jenis Surat</label>
                    <select name="type" id="type" class="form-control">
                        <option value="">Semua Jenis</option>
                        <option value="incoming" {{ request('type') == 'incoming' ? 'selected' : '' }}>Surat Masuk</option>
                        <option value="outgoing" {{ request('type') == 'outgoing' ? 'selected' : '' }}>Surat Keluar</option>
                    </select>
                </div>

                <!-- Tombol Cetak PDF -->
                <div class="col-md-3 align-self-end">
                    <button type="submit" class="btn btn-primary mr-2">
                        <i class="fas fa-filter"></i> Terapkan Filter
                    </button>
                    <a href="{{ route('letters.pdf', request()->all()) }}" class="btn btn-info">
                        <i class="fas fa-download"></i> Cetak PDF
                    </a>
                </div>
            </div>
        </form>

        <!-- Pesan Jika Data Tidak Ditemukan -->
        @if ($search && $letters->isEmpty())
        <div class="alert alert-warning">
            Tidak ada surat yang ditemukan untuk kata kunci "<strong>{{ $search }}</strong>".
        </div>
        @endif

        <!-- Tabel Data -->
        <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Jenis</th>
                    <th>Nomor Surat</th>
                    <th>Asal Surat</th>
                    <th>Tujuan</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Tanggal</th>
                    <th>File</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($letters as $letter)
                <tr>
                    <td>{{ $letter->getTypeTranslatedAttribute() }}</td>
                    <td>{{ $letter->nomor_surat ?? '-' }}</td>
                    <td>{{ $letter->asal_surat ?? '-' }}</td>
                    <td>{{ $letter->tujuan ?? '-' }}</td>
                    <td>{{ $letter->title }}</td>
                    <td>{{ Str::limit($letter->description, 50) }}</td>
                    <td>{{ $letter->date ? \Carbon\Carbon::parse($letter->date)->format('d-m-Y') : '-' }}</td>
                    <td>
                        @if ($letter->file_path)
                        <a href="{{ asset('storage/' . $letter->file_path) }}" target="_blank">
                            <i class="fas fa-file-download"></i> Unduh File
                        </a>
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('letters.edit', $letter->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('letters.destroy', $letter->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus surat ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $letters->links() }}
        </div>
    </div>
</div>
@endsection