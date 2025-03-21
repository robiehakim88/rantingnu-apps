<!-- resources/views/finances/create.blade.php -->
@extends('layouts.app')

@section('title', 'Tambah Transaksi Keuangan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Transaksi Keuangan</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('finances.store') }}" method="POST">
            @csrf

            <!-- Jenis Transaksi -->
            <div class="form-group">
                <label for="type">Jenis Transaksi:</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="income">Pemasukan</option>
                    <option value="expense">Pengeluaran</option>
                </select>
            </div>

            <!-- Deskripsi -->
            <div class="form-group">
                <label for="description">Deskripsi:</label>
                <input type="text" name="description" id="description" class="form-control">
            </div>

            <!-- Jumlah -->
            <div class="form-group">
                <label for="amount">Jumlah:</label>
                <input type="number" name="amount" id="amount" class="form-control" step="0.01" required>
            </div>

            <!-- Tanggal (Wajib Diisi) -->
            <div class="form-group">
                <label for="date">Tanggal:</label>
                <input type="date" name="date" id="date" class="form-control" required>
            </div>

            <!-- Tombol Simpan -->
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection