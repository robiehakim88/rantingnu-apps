@extends('layouts.app')

@section('title', 'Tambah Surat')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Surat</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('letters.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="type">Jenis Surat</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="incoming">Surat Masuk</option>
                    <option value="outgoing">Surat Keluar</option>
                </select>
            </div>
        
            <div class="form-group">
                <label for="nomor_surat">Nomor Surat</label>
                <input type="text" name="nomor_surat" id="nomor_surat" class="form-control" placeholder="Masukkan nomor surat">
            </div>
        
            <div class="form-group" id="asal-surat-field">
                <label for="asal_surat">Asal Surat</label>
                <input type="text" name="asal_surat" id="asal_surat" class="form-control" placeholder="Masukkan asal surat">
            </div>
        
            <div class="form-group">
                <label for="tujuan">Tujuan</label>
                <input type="text" name="tujuan" id="tujuan" class="form-control" placeholder="Masukkan tujuan surat" required>
            </div>
            
            
            <div class="mb-3">
                <label for="title" class="form-label">Judul</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea name="description" id="description" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Tanggal</label>
                <input type="date" name="date" id="date" class="form-control">
            </div>
             <div class="mb-3">
                <label for="file" class="form-label">File (PDF, DOC, DOCX, maks. 2MB)</label>
                <input type="file" name="file" id="file" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
        
        
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
    </div>
</div>
@endsection