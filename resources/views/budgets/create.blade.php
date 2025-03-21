@extends('layouts.app')

@section('title', 'Tambah RAB')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Rencana Anggaran Biaya (RAB)</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('budgets.store') }}" method="POST">
            @csrf

            <!-- Input Tahun Anggaran -->
            <div class="mb-3">
                <label for="year" class="form-label">Tahun Anggaran</label>
                <select name="year" id="year" class="form-control" required>
                    @for ($i = date('Y'); $i >= 2000; $i--)
                        <option value="{{ $i }}" {{ old('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <!-- Input Waktu -->
            <div class="mb-3">
                <label for="timeframe" class="form-label">Waktu</label>
                <select name="timeframe" id="timeframe" class="form-control" required>
                    <option value="Mingguan" {{ old('timeframe') === 'Mingguan' ? 'selected' : '' }}>Mingguan</option>
                    <option value="Bulanan" {{ old('timeframe') === 'Bulanan' ? 'selected' : '' }}>Bulanan</option>
                    <option value="Tahunan" {{ old('timeframe') === 'Tahunan' ? 'selected' : '' }}>Tahunan</option>
                    <option value="Insidental" {{ old('timeframe') === 'Insidental' ? 'selected' : '' }}>Insidental</option>
                </select>
            </div>

            <!-- Input Nama Kegiatan -->
            <div class="mb-3">
                <label for="activity_name" class="form-label">Nama Kegiatan</label>
                <input type="text" name="activity_name" id="activity_name" class="form-control" value="{{ old('activity_name') }}" required>
            </div>

            <!-- Input Deskripsi -->
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <!-- Input Anggaran Direncanakan -->
            <div class="mb-3">
                <label for="planned_budget" class="form-label">Anggaran Direncanakan (Rp)</label>
                <input type="number" name="planned_budget" id="planned_budget" class="form-control" step="0.01" min="0" value="{{ old('planned_budget') }}" required>
            </div>

            <!-- Input Tanggal Mulai -->
            <div class="mb-3">
                <label for="start_date" class="form-label">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}">
            </div>

            <!-- Input Tanggal Selesai -->
            <div class="mb-3">
                <label for="end_date" class="form-label">Tanggal Selesai</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}">
            </div>

            <!-- Tombol Simpan -->
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection