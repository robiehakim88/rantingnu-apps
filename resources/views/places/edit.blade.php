@extends('layouts.app')

@section('title', 'Edit Masjid/Musholla')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Masjid/Musholla</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('places.update', $place->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Metode HTTP PUT untuk update -->

            <!-- Input Nama -->
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $place->name) }}" required>
            </div>

            <!-- Input Jenis -->
            <div class="mb-3">
                <label for="type" class="form-label">Jenis</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="masjid" {{ old('type', $place->type) === 'masjid' ? 'selected' : '' }}>Masjid</option>
                    <option value="musholla" {{ old('type', $place->type) === 'musholla' ? 'selected' : '' }}>Musholla</option>
                </select>
            </div>

            <!-- Input Alamat -->
            <div class="mb-3">
                <label for="address" class="form-label">Alamat</label>
                <textarea name="address" id="address" class="form-control">{{ old('address', $place->address) }}</textarea>
            </div>

            <!-- Input Latitude -->
            <div class="mb-3">
                <label for="latitude" class="form-label">Latitude</label>
                <input type="text" name="latitude" id="latitude" class="form-control" value="{{ old('latitude', $place->latitude) }}">
            </div>

            <!-- Input Longitude -->
            <div class="mb-3">
                <label for="longitude" class="form-label">Longitude</label>
                <input type="text" name="longitude" id="longitude" class="form-control" value="{{ old('longitude', $place->longitude) }}">
            </div>

            <!-- Tombol Simpan -->
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection