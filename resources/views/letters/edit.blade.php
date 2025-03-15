@extends('layouts.app')

@section('title', 'Edit Surat')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Surat</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('letters.update', $letter->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Jenis Surat -->
            <div class="form-group">
                <label for="type">Jenis Surat</label>
                <select name="type" id="type" class="form-control" required disabled>
                    <option value="incoming" {{ $letter->type === 'incoming' ? 'selected' : '' }}>Surat Masuk</option>
                    <option value="outgoing" {{ $letter->type === 'outgoing' ? 'selected' : '' }}>Surat Keluar</option>
                </select>
                <input type="hidden" name="type" value="{{ $letter->type }}">
            </div>

            <!-- Nomor Surat -->
            <div class="form-group">
                <label for="nomor_surat">Nomor Surat</label>
                <input type="text" name="nomor_surat" id="nomor_surat" class="form-control" 
                       placeholder="Masukkan nomor surat" value="{{ old('nomor_surat', $letter->nomor_surat) }}">
            </div>

            <!-- Asal Surat (Hanya untuk Incoming) -->
            <div class="form-group" id="asal-surat-field" style="{{ $letter->type === 'incoming' ? 'display: block;' : 'display: none;' }}">
                <label for="asal_surat">Asal Surat</label>
                <input type="text" name="asal_surat" id="asal_surat" class="form-control" 
                       placeholder="Masukkan asal surat" value="{{ old('asal_surat', $letter->asal_surat) }}">
            </div>

            <!-- Tujuan -->
            <div class="form-group">
                <label for="tujuan">Tujuan</label>
                <input type="text" name="tujuan" id="tujuan" class="form-control" 
                       placeholder="Masukkan tujuan surat" value="{{ old('tujuan', $letter->tujuan) }}" required>
            </div>

            <!-- Judul -->
            <div class="form-group">
                <label for="title">Judul</label>
                <input type="text" name="title" id="title" class="form-control" 
                       placeholder="Masukkan judul surat" value="{{ old('title', $letter->title) }}" required>
            </div>

            <!-- Deskripsi -->
            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea name="description" id="description" class="form-control" rows="3"
                          placeholder="Masukkan deskripsi">{{ old('description', $letter->description) }}</textarea>
            </div>

            <!-- Tanggal -->
            <div class="form-group">
                <label for="date">Tanggal</label>
                <input type="date" name="date" id="date" class="form-control" 
                       value="{{ old('date', $letter->date ? \Carbon\Carbon::parse($letter->date)->format('Y-m-d') : '') }}">
            </div>

            <!-- File -->
            <div class="form-group">
                <label for="file">File</label>
                <input type="file" name="file" id="file" class="form-control">
                @if ($letter->file_path)
                <p class="mt-2">
                    <a href="{{ asset('storage/' . $letter->file_path) }}" target="_blank">
                        <i class="fas fa-file-download"></i> Unduh File Saat Ini
                    </a>
                </p>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Toggle field asal_surat berdasarkan jenis surat
    document.getElementById('type').addEventListener('change', function () {
        const asalSuratField = document.getElementById('asal-surat-field');
        if (this.value === 'incoming') {
            asalSuratField.style.display = 'block';
        } else {
            asalSuratField.style.display = 'none';
        }
    });
</script>
@endsection