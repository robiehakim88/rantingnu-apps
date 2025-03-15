@extends('layouts.app')

@section('title', 'Tambah Transaksi')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Transaksi</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('finances.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="type" class="form-label">Jenis Transaksi</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="income">Pemasukan</option>
                    <option value="expense">Pengeluaran</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea name="description" id="description" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">Jumlah</label>
                <input type="number" name="amount" id="amount" class="form-control" step="0.01" min="0" required>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Tanggal</label>
                <input type="date" name="date" id="date" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection