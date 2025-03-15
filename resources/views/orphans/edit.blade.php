@extends('layouts.app')

@section('title', 'Edit Anak Yatim Piatu')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Anak Yatim Piatu</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('orphans.update', $orphan->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Metode HTTP PUT untuk update -->

            <!-- Input Nama -->
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $orphan->name) }}" required>
            </div>

            <!-- Input Jenis Kelamin -->
            <div class="mb-3">
                <label for="gender" class="form-label">Jenis Kelamin</label>
                <select name="gender" id="gender" class="form-control" required>
                    <option value="male" {{ old('gender', $orphan->gender) === 'male' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="female" {{ old('gender', $orphan->gender) === 'female' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <!-- Input Tanggal Lahir -->
            <div class="mb-3">
                <label for="birthdate" class="form-label">Tanggal Lahir</label>
                <input type="date" name="birthdate" id="birthdate" class="form-control" value="{{ old('birthdate', $orphan->birthdate) }}" required>
            </div>

            <!-- Input Alamat -->
            <div class="mb-3">
                <label for="address" class="form-label">Alamat</label>
                <textarea name="address" id="address" class="form-control">{{ old('address', $orphan->address) }}</textarea>
            </div>

            <!-- Tombol Simpan -->
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection