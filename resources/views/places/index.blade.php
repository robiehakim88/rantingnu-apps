@extends('layouts.app')

@section('title', 'Daftar Masjid dan Musholla')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Masjid dan Musholla</h3>
        <div class="float-right">
            <a href="{{ route('places.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
        </div>
    </div>
    <div class="card-body">
        <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Jenis</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($places as $place)
                <tr>
                    <td>{{ $place->name }}</td>
                    <td>{{ ucfirst($place->type) }}</td>
                    <td>{{ $place->address }}</td>
                    <td>
                        <a href="{{ route('places.edit', $place->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('places.destroy', $place->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Peta -->
<div id="map" style="height: 400px; margin-top: 20px;"></div>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script>
    var map = L.map('map').setView([-7.5985281227759165, 112.1027729841309], 15); // Koordinat default (Jakarta)

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Tambahkan marker untuk setiap lokasi
    @foreach ($places as $place)
        @if ($place->latitude && $place->longitude)
        L.marker([{{ $place->latitude }}, {{ $place->longitude }}])
            .addTo(map)
            .bindPopup("{{ $place->name }}<br>{{ $place->address }}");
        @endif
    @endforeach
</script>
@endsection