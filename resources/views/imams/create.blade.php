@extends('layouts.app')

@section('title', 'Tambah Data Imam Taraweh')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Data Imam Taraweh</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('imams.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="place_id">Nama Masjid/Musholla</label>
                <select name="place_id" id="place_id" class="form-control" required>
                    <option value="">Pilih Masjid/Musholla</option>
                    @foreach ($places as $place)
                    <option value="{{ $place->id }}">{{ $place->name }} - {{ $place->address }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="name">Nama Imam Taraweh</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="year_hijriyah">Tahun Hijriyah</label>
                <input type="number" name="year_hijriyah" id="year_hijriyah" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection