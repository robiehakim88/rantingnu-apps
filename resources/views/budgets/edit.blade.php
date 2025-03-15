@extends('layouts.app')

@section('title', 'Edit RAB')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Rencana Anggaran Biaya (RAB)</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('budgets.update', $budget->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Input Waktu -->
            <div class="mb-3">
                <label for="timeframe" class="form-label">Waktu</label>
                <select name="timeframe" id="timeframe" class="form-control" required>
                    <option value="Mingguan" {{ old('timeframe', $budget->timeframe) === 'Mingguan' ? 'selected' : '' }}>Mingguan</option>
                    <option value="Bulanan" {{ old('timeframe', $budget->timeframe) === 'Bulanan' ? 'selected' : '' }}>Bulanan</option>
                    <option value="Tahunan" {{ old('timeframe', $budget->timeframe) === 'Tahunan' ? 'selected' : '' }}>Tahunan</option>
                    <option value="Insidental" {{ old('timeframe', $budget->timeframe) === 'Insidental' ? 'selected' : '' }}>Insidental</option>
                </select>
            </div>

            <!-- Input Nama Kegiatan -->
            <div class="mb-3">
                <label for="activity_name" class="form-label">Nama Kegiatan</label>
                <input type="text" name="activity_name" id="activity_name" class="form-control" value="{{ old('activity_name', $budget->activity_name) }}" required>
            </div>

            <!-- Input Deskripsi -->
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea name="description" id="description" class="form-control">{{ old('description', $budget->description) }}</textarea>
            </div>

            <!-- Input Anggaran Direncanakan -->
            <div class="mb-3">
                <label for="planned_budget" class="form-label">Anggaran Direncanakan (Rp)</label>
                <input type="number" name="planned_budget" id="planned_budget" class="form-control" step="0.01" min="0" value="{{ old('planned_budget', $budget->planned_budget) }}" required>
            </div>

            <!-- Input Anggaran Terserap -->
            <div class="mb-3">
                <label for="actual_budget" class="form-label">Anggaran Terserap (Rp)</label>
                <input type="number" name="actual_budget" id="actual_budget" class="form-control" step="0.01" min="0" value="{{ old('actual_budget', $budget->actual_budget) }}">
            </div>

            <!-- Input Tanggal Mulai -->
            <div class="mb-3">
                <label for="start_date" class="form-label">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', $budget->start_date) }}">
            </div>

            <!-- Input Tanggal Selesai -->
            <div class="mb-3">
                <label for="end_date" class="form-label">Tanggal Selesai</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date', $budget->end_date) }}">
            </div>

            <!-- Tombol Simpan -->
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection