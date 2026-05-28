@extends('layout.dokter')

@section('title', 'Data Pasien')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Pasien</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Pasien</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No. Berobat</th>
                        <th>Nama Pasien</th>
                        <th>NIK</th>
                        <th>Jenis Kelamin</th>
                        <th>No. Telp</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pasien as $index => $p)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $p->no_kberobat ?? '-' }}</td>
                        <td>{{ $p->nama_pasien }}</td>
                        <td>{{ $p->nik ?? '-' }}</td>
                        <td>{{ $p->jenis_kelamin ?? '-' }}</td>
                        <td>{{ $p->no_telp ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Belum ada data pasien.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        }
    });
});
</script>
@endpush
