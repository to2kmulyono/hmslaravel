@extends('layout.petugas')

@section('title', 'Detail Riwayat Rekam Medis')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Riwayat Rekam Medis Pasien</h1>
    <a href="{{ route('petugas.rekam-medis') }}" class="btn btn-sm btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Riwayat Medis</h6>
            </div>
            <div class="card-body">
                @if($riwayat->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-file-medical-alt fa-3x text-gray-300 mb-3"></i>
                        <p class="text-gray-600">Belum ada riwayat rekam medis untuk pasien ini.</p>
                    </div>
                @else
                    <div class="mb-4">
                        <table class="table table-sm table-borderless w-auto">
                            <tr>
                                <th>Nama Pasien</th>
                                <td>: {{ $riwayat->first()->pasien->name ?? 'Unknown' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Dokter</th>
                                    <th>Keluhan Utama</th>
                                    <th>Diagnosa</th>
                                    <th>Tindakan</th>
                                    <th>Resep Obat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayat as $index => $rm)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $rm->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $rm->dokter->name ?? 'Unknown' }}</td>
                                    <td>{{ $rm->keluhan_utama }}</td>
                                    <td>{{ $rm->diagnosa }}</td>
                                    <td>{{ $rm->tindakan ?? '-' }}</td>
                                    <td>{{ $rm->resep_obat ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        }
    });
});
</script>
@endpush
