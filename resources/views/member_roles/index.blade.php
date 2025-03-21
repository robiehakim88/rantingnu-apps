@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Peran Anggota</h3>
    </div>
    <div class="card-body">
        <!-- Tombol Tambah Data -->
        <div class="mb-3">
            <a href="{{ route('member-roles.create') }}" class="btn btn-primary">Tambah Data</a>
        </div>

        <!-- Form Pencarian -->
        <form action="{{ route('member-roles.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>

        <!-- Tabel Data -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Anggota</th>
                    <th>Peran</th>
                    <th>Periode</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($memberRoles as $index => $memberRole)
                <tr>
                    <td>{{ $index + $memberRoles->firstItem() }}</td>
                    <td>{{ $memberRole->member->name }}</td>
                    <td>{{ $memberRole->role->name }}</td>
                    <td>{{ $memberRole->start_year }} - {{ $memberRole->end_year }}</td>
                    <td>
                        <a href="{{ route('member-roles.edit', $memberRole->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('member-roles.destroy', $memberRole->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                        </form>
                        <a href="{{ route('member.certificate', $memberRole->member_id) }}" class="btn btn-sm btn-success">Cetak Piagam</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $memberRoles->links() }}
        </div>
    </div>
</div>
@endsection