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
        @if ($search && $letters->isEmpty())
        <div class="alert alert-warning">
            Tidak ada surat yang ditemukan untuk kata kunci "<strong>{{ $search }}</strong>".
        </div>
        @endif
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
    </div>
</div>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
@endsection