@extends('layouts.app')

@section('title', 'Edit Kegiatan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Kegiatan</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- Pastikan ini ada -->

            <!-- Input Nama Kegiatan -->
            <div class="mb-3">
                <label for="name" class="form-label">Nama Kegiatan</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $event->name) }}" required>
            </div>

            <!-- Input Deskripsi -->
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea name="description" id="description" class="form-control">{{ old('description', $event->description) }}</textarea>
            </div>

            <!-- Input Tanggal Pelaksanaan -->
            <div class="mb-3">
                <label for="date" class="form-label">Tanggal Pelaksanaan</label>
                <input type="date" name="date" id="date" class="form-control" value="{{ old('date', $event->date) }}" required>
            </div>

            <!-- Foto Dokumentasi yang Sudah Diupload -->
            <div class="mb-3">
                <label class="form-label">Foto Dokumentasi yang Sudah Diupload</label>
                <div>
                    @if ($event->photo_urls->isNotEmpty())
                        @foreach ($event->photo_urls as $url)
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
                                <img src="{{ $url }}" alt="Foto Kegiatan" style="max-width: 50px; margin-right: 10px;">
                                <form action="{{ route('events.delete_photo', ['event' => $event->id, 'photo' => basename($url)]) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus foto ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    @else
                        <p>Tidak ada foto yang diupload.</p>
                    @endif
                </div>
            </div>

            <!-- Input Foto Dokumentasi Baru -->
            <div class="mb-3">
                <label for="photos" class="form-label">Tambah Foto Dokumentasi Baru (JPG, PNG, JPEG, maks. 2MB)</label>
                <input type="file" name="photos[]" id="photos" class="form-control" multiple>
            </div>

            <!-- Tombol Simpan -->
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection