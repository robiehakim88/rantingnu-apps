@extends('layouts.app')

@section('title', 'Manajemen Anggota')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Anggota</h3>
        <div class="float-right">
            <form action="{{ route('members.index') }}" method="GET" class="form-inline">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari anggota..." value="{{ $search ?? '' }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('members.create') }}" class="btn btn-primary ml-2">Tambah Anggota</a>
                        <a href="{{ route('members.pdf') }}" class="btn btn-success ml-2">Cetak PDF</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if ($search && $members->isEmpty())
    <div class="alert alert-warning">
        Tidak ada anggota yang ditemukan untuk kata kunci "<strong>{{ $search }}</strong>".
    </div>
    @endif

    <div class="card-body">
        <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                    <th>Tanggal Lahir</th>
                    <th>Usia</th>
                    <th>Peran</th>
                    <th>Aksi</th>
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
                    <td>{{ $member->age ?? '-' }}</td>
                    <td>{{ $member->role->name ?? '-' }}</td>
                    <td>
                        <a href="{{ route('members.edit', $member->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('members.destroy', $member->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection