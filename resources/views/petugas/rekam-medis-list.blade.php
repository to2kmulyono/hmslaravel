@extends('layout.petugas')

@section('title', 'Daftar Rekam Medis')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Rekam Medis</h1>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Rekam Medis Pasien</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama Pasien</th>
                                <th>Dokter</th>
                                <th>Keluhan Utama</th>
                                <th>Diagnosa</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rekamMedis as $index => $rm)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $rm->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $rm->pasien->name ?? 'Unknown' }}</td>
                                <td>{{ $rm->dokter->name ?? 'Unknown' }}</td>
                                <td>{{ Str::limit($rm->keluhan_utama, 30) }}</td>
                                <td>{{ Str::limit($rm->diagnosa, 30) }}</td>
                                <td>
                                    <a href="{{ route('petugas.rekam-medis', $rm->pasien_id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Lihat Riwayat
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
