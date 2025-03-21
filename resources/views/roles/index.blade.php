@extends('layouts.app')

@section('title', 'Manajemen Roles')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Roles</h3>
        <div class="float-right d-flex align-items-center">
            <!-- Form Pencarian -->
            <form action="{{ route('roles.index') }}" method="GET" class="form-inline mr-2">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari role..." value="{{ $search ?? '' }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Tombol Tambah Role -->
            <a href="{{ route('roles.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Role
            </a>
        </div>
    </div>
    <div class="card-body">
        @if ($search && $roles->isEmpty())
        <div class="alert alert-warning">
            Tidak ada role yang ditemukan untuk kata kunci "<strong>{{ $search }}</strong>".
        </div>
        @endif
        <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>{{ Str::limit($role->description, 50) }}</td>
                    <td>
                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus role ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection