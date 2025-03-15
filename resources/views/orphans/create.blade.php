<!-- Contoh untuk create.blade.php -->
@extends('layouts.app')

@section('title', 'Tambah Anak Yatim Piatu')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Anak Yatim Piatu</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('orphans.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Jenis Kelamin</label>
                <select name="gender" id="gender" class="form-control" required>
                    <option value="male">Laki-laki</option>
                    <option value="female">Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="birthdate" class="form-label">Tanggal Lahir</label>
                <input type="date" name="birthdate" id="birthdate" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Alamat</label>
                <textarea name="address" id="address" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection