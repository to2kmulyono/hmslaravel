@extends('layout.dokter')

@section('title', 'Dashboard Dokter')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard Dokter</h1>
</div>

<div class="row">
    <!-- Total Pasien -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pasien</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPasien }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Rekam Medis Saya -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Rekam Medis Saya</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalRekamMedis }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-medical fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Ruang -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Ruang</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalRuang }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-procedures fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Obat -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Jenis Obat</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalObat }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-pills fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Profil Dokter</h6>
            </div>
            <div class="card-body">
                @if($dokter)
                <p><strong>Nama:</strong> {{ $dokter->nama_dokter }}</p>
                <p><strong>Spesialis:</strong> {{ $dokter->spesialis ?? '-' }}</p>
                <p><strong>Poliklinik:</strong> {{ $dokter->poliklinik->nama_poli ?? '-' }}</p>
                @else
                <p>Profil dokter Anda belum diatur oleh Admin.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
