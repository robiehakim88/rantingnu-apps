@extends('layouts.app')

@section('title', 'Dashboard Ranting NU Pelem')

@section('content')
<div class="row">
    <!-- Total Anggota -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalMembers }}</h3>
                <p>Total Anggota</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ url('/members') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- Total Surat -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $totalLetters ?? 0 }}</h3>
                <p>Total Surat</p>
            </div>
            <div class="icon">
                <i class="fas fa-envelope"></i>
            </div>
            <a href="{{ url('/letters') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- Total Transaksi -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $totalFinances ?? 0 }}</h3>
                <p>Total Transaksi</p>
            </div>
            <div class="icon">
                <i class="fas fa-money-bill"></i>
            </div>
            <a href="{{ url('/finances') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- Total Kegiatan -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $totalEvents ?? 0 }}</h3>
                <p>Total Kegiatan</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar"></i>
            </div>
            <a href="{{ url('/events') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- Total Masjid & Musholla -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $totalPlaces }}</h3>
                <p>Total Masjid & Musholla</p>
            </div>
            <div class="icon">
                <i class="fas fa-mosque"></i>
            </div>
            <a href="{{ url('/places') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- Total Masjid -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>{{ $totalMosques }}</h3>
                <p>Total Masjid</p>
            </div>
            <div class="icon">
                <i class="fas fa-mosque"></i>
            </div>
            <a href="{{ url('/places') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- Total Musholla -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>{{ $totalMushollas }}</h3>
                <p>Total Musholla</p>
            </div>
            <div class="icon">
                <i class="fas fa-place-of-worship"></i>
            </div>
            <a href="{{ url('/places') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- Total Anak Yatim Piatu -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-gradient-purple">
            <div class="inner">
                <h3>{{ $totalOrphans }}</h3>
                <p>Total Anak Yatim Piatu</p>
            </div>
            <div class="icon">
                <i class="fas fa-child"></i>
            </div>
            <a href="{{ url('/orphans') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- Total Anak Yatim Laki-laki -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-gradient-blue">
            <div class="inner">
                <h3>{{ $totalMaleOrphans }}</h3>
                <p>Anak Yatim Laki-laki</p>
            </div>
            <div class="icon">
                <i class="fas fa-male"></i>
            </div>
            <a href="{{ url('/orphans') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- Total Anak Yatim Perempuan -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-gradient-pink">
            <div class="inner">
                <h3>{{ $totalFemaleOrphans }}</h3>
                <p>Anak Yatim Perempuan</p>
            </div>
            <div class="icon">
                <i class="fas fa-female"></i>
            </div>
            <a href="{{ url('/orphans') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
@endsection