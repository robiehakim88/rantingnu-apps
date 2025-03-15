@extends('layouts.app')

@section('title', 'Edit Transaksi')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Transaksi</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('finances.update', $finance->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="type" class="form-label">Jenis Transaksi</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="income" {{ old('type', $finance->type) === 'income' ? 'selected' : '' }}>Pemasukan</option>
                    <option value="expense" {{ old('type', $finance->type) === 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea name="description" id="description" class="form-control">{{ old('description', $finance->description) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">Jumlah</label>
                <input type="number" name="amount" id="amount" class="form-control" step="0.01" min="0" value="{{ old('amount', $finance->amount) }}" required>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Tanggal</label>
                <input type="date" name="date" id="date" class="form-control" value="{{ old('date', $finance->date) }}">
            </div>
            <button type="submit" class="btn btn-primary">Perbarui</button>
        </form>
    </div>
</div>
@endsection