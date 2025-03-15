@extends('layouts.app')

@section('title', 'Daftar Anak Yatim Piatu')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Anak Yatim Piatu</h3>
        <div class="float-right">
            <a href="{{ route('orphans.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Form Pencarian -->
        <form action="{{ route('orphans.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama..." value="{{ $search }}">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
            </div>
        </form>

        <!-- Statistik -->
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalMale }}</h3>
                        <p>Total Laki-laki</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $totalFemale }}</h3>
                        <p>Total Perempuan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $eligibleForAid }}</h3>
                        <p>Memenuhi Syarat Santunan (< 17 Tahun)</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Daftar Anak Yatim Piatu -->
        <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Tanggal Lahir</th>
                    <th>Usia</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orphans as $orphan)
                <tr>
                    <td>{{ $orphan->name }}</td>
                    <td>{{ $orphan->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td>{{ $orphan->birthdate }}</td>
                    <td>{{ $orphan->age ?? '-' }} Tahun</td>
                    <td>{{ $orphan->address }}</td>
                    <td>
                        <a href="{{ route('orphans.edit', $orphan->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('orphans.destroy', $orphan->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection