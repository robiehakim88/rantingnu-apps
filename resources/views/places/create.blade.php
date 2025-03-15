@extends('layouts.app')

@section('title', 'Tambah Masjid/Musholla')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Masjid/Musholla</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('places.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Jenis</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="masjid">Masjid</option>
                    <option value="musholla">Musholla</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Alamat</label>
                <textarea name="address" id="address" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label for="latitude" class="form-label">Latitude</label>
                <input type="text" name="latitude" id="latitude" class="form-control">
            </div>
            <div class="mb-3">
                <label for="longitude" class="form-label">Longitude</label>
                <input type="text" name="longitude" id="longitude" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection