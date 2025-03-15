@extends('layouts.app')

@section('title', 'Daftar Kegiatan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Kegiatan</h3>
        <div class="float-right">
            <a href="{{ route('events.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Kegiatan
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Form Pencarian -->
        <form action="{{ route('events.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama..." value="{{ $search }}">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
            </div>
        </form>

        <!-- Tabel Daftar Kegiatan -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Tanggal Pelaksanaan</th>
                    <th>Deskripsi</th>
                    <th>Foto Dokumentasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($events as $event)
                <tr>
                    <td>{{ $event->name }}</td>
                    <td>{{ $event->date }}</td>
                    <td>{{ $event->description}}</td>
                   <td>
                        @if ($event->photo_urls->isNotEmpty())
                            @foreach ($event->photo_urls as $url)
                                <img src="{{ $url }}" alt="Foto Kegiatan" style="max-width: 50px; margin: 5px;">
                            @endforeach
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('events.edit', $event->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline;">
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

<!-- Kalender Google-like -->
<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title">Kalender Kegiatan</h3>
    </div>
    <div class="card-body">
        <div id="calendar"></div>
    </div>
</div>

<!-- FullCalendar JS & CSS (via CDN) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var events = @json($events->map(function ($event) {
            return [
                'title' => $event->name,
                'start' => $event->date,
            ];
        }));

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: events,
        });

        calendar.render();
    });
</script>
@endsection