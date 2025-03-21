@extends('layouts.app')

@section('title', 'Data Imam Taraweh')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Imam Taraweh</h3>
        <div class="float-right">
            <a href="{{ route('imams.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
            <a href="{{ route('imams.pdf') }}?year_hijriyah={{ request('year_hijriyah') }}" class="btn btn-info">
                <i class="fas fa-download"></i> Cetak PDF
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Form Pencarian -->
        <form action="{{ route('imams.index') }}" method="GET" class="mb-3">
            <div class="row">
                <!-- Input Pencarian -->
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama imam atau masjid..." value="{{ $search }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Dropdown Filter Tahun Hijriyah -->
                <div class="col-md-3">
                    <div class="form-group">
                       
                        <select name="year_hijriyah" id="year_hijriyah" class="form-control">
                            <option value="">Pilih Tahuh Hijriyah</option>
                            <option value="">Semua Tahun</option>
                            @php
                                // Ambil daftar tahun hijriyah unik dari database
                                $years = \App\Models\Imam::select('year_hijriyah')->distinct()->orderByDesc('year_hijriyah')->pluck('year_hijriyah');
                            @endphp
                            @foreach ($years as $year)
                                <option value="{{ $year }}" {{ request('year_hijriyah') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </form>

        <!-- Pesan Jika Data Tidak Ditemukan -->
        @if ($search && $imams->isEmpty())
        <div class="alert alert-warning">
            Tidak ada data yang ditemukan untuk kata kunci "<strong>{{ $search }}</strong>".
        </div>
        @endif

        <!-- Tabel Data Imam Taraweh -->
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Nama Masjid/Musholla</th>
                    <th>Alamat</th>
                    <th>Nama Imam Taraweh</th>
                    <th>Tahun Hijriyah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($imams as $imam)
                <tr>
                    <td>{{ $imam->place->name }}</td>
                    <td>{{ $imam->place->address }}</td>
                    <td>{{ $imam->name }}</td>
                    <td>{{ $imam->year_hijriyah }}</td>
                    <td>
                        <a href="{{ route('imams.edit', $imam->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('imams.destroy', $imam->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection