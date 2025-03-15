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

            <!-- Input Waktu -->
            <div class="mb-3">
                <label for="timeframe" class="form-label">Waktu</label>
                <select name="timeframe" id="timeframe" class="form-control" required>
                    <option value="Mingguan">Mingguan</option>
                    <option value="Bulanan">Bulanan</option>
                    <option value="Tahunan">Tahunan</option>
                    <option value="Insidental">Insidental</option>
                </select>
            </div>

            <!-- Input Nama Kegiatan -->
            <div class="mb-3">
                <label for="activity_name" class="form-label">Nama Kegiatan</label>
                <input type="text" name="activity_name" id="activity_name" class="form-control" required>
            </div>

            <!-- Input Deskripsi -->
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea name="description" id="description" class="form-control"></textarea>
            </div>

            <!-- Input Anggaran Direncanakan -->
            <div class="mb-3">
                <label for="planned_budget" class="form-label">Anggaran Direncanakan (Rp)</label>
                <input type="number" name="planned_budget" id="planned_budget" class="form-control" step="0.01" min="0" required>
            </div>

            <!-- Input Anggaran Terserap -->
            <div class="mb-3">
                <label for="actual_budget" class="form-label">Anggaran Terserap (Rp)</label>
                <input type="number" name="actual_budget" id="actual_budget" class="form-control" step="0.01" min="0">
            </div>

            <!-- Input Tanggal Mulai -->
            <div class="mb-3">
                <label for="start_date" class="form-label">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" class="form-control">
            </div>

            <!-- Input Tanggal Selesai -->
            <div class="mb-3">
                <label for="end_date" class="form-label">Tanggal Selesai</label>
                <input type="date" name="end_date" id="end_date" class="form-control">
            </div>

            <!-- Tombol Simpan -->
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection