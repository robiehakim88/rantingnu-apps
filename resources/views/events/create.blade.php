@extends('layouts.app')

@section('title', 'Tambah Kegiatan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Kegiatan</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Input Nama Kegiatan -->
            <div class="mb-3">
                <label for="name" class="form-label">Nama Kegiatan</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <!-- Input Deskripsi -->
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea name="description" id="description" class="form-control"></textarea>
            </div>

            <!-- Input Tanggal Pelaksanaan -->
            <div class="mb-3">
                <label for="date" class="form-label">Tanggal Pelaksanaan</label>
                <input type="date" name="date" id="date" class="form-control" required>
            </div>

            <!-- Input Foto Dokumentasi -->
            <div class="mb-3">
                <label for="photos" class="form-label">Foto Dokumentasi (JPG, PNG, JPEG, maks. 2MB)</label>
                <input type="file" name="photos[]" id="photos" class="form-control" multiple>
            </div>

            <!-- Tombol Simpan -->
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection