@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Data Peran Anggota</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('member-roles.update', $memberRole->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="member_id">Nama Anggota</label>
                <select name="member_id" id="member_id" class="form-control" required>
                    @foreach ($members as $member)
                    <option value="{{ $member->id }}" {{ $memberRole->member_id == $member->id ? 'selected' : '' }}>
                        {{ $member->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="role_id">Peran</label>
                <select name="role_id" id="role_id" class="form-control" required>
                    @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ $memberRole->role_id == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="start_year">Tahun Awal</label>
                <input type="number" name="start_year" id="start_year" class="form-control" value="{{ $memberRole->start_year }}" min="2000" max="{{ now()->year }}" required>
            </div>
            <div class="form-group">
                <label for="end_year">Tahun Akhir</label>
                <input type="number" name="end_year" id="end_year" class="form-control" value="{{ $memberRole->end_year }}" min="2000" max="{{ now()->year }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection