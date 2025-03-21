@extends('layouts.app')

@section('title', 'Edit Data Imam Taraweh')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Data Imam Taraweh</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('imams.update', $imam->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Metode HTTP untuk update -->

            <!-- Dropdown Nama Masjid/Musholla -->
            <div class="form-group">
                <label for="place_id">Nama Masjid/Musholla</label>
                <select name="place_id" id="place_id" class="form-control" required>
                    <option value="">Pilih Masjid/Musholla</option>
                    @foreach ($places as $place)
                    <option value="{{ $place->id }}" {{ $imam->place_id == $place->id ? 'selected' : '' }}>
                        {{ $place->name }} - {{ $place->address }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Input Nama Imam Taraweh -->
            <div class="form-group">
                <label for="name">Nama Imam Taraweh</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $imam->name) }}" required>
            </div>

            <!-- Input Tahun Hijriyah -->
            <div class="form-group">
                <label for="year_hijriyah">Tahun Hijriyah</label>
                <input type="number" name="year_hijriyah" id="year_hijriyah" class="form-control" value="{{ old('year_hijriyah', $imam->year_hijriyah) }}" required>
            </div>

            <!-- Tombol Simpan -->
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('imams.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection