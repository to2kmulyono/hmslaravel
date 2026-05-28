@extends('layout.admin')

@section('title', 'Laporan Riwayat Resep')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Laporan Riwayat Resep Obat</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Rekam Medis (Dengan Resep Obat)</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Waktu Periksa</th>
                        <th>Nama Pasien</th>
                        <th>Dokter</th>
                        <th>Diagnosa</th>
                        <th>Catatan Resep Dokter</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayatResep as $resep)
                    <tr>
                        <td>{{ $resep->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $resep->pasien->nama_user ?? 'Unknown' }}</td>
                        <td>{{ $resep->dokter->nama_user ?? 'Unknown' }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($resep->diagnosa, 50) }}</td>
                        <td class="text-info font-weight-bold">{{ $resep->resep_obat }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $riwayatResep->links() }}
            </div>
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
            },
            "paging": false,
            "info": false,
            "order": [[0, "desc"]]
        });
    });
</script>
@endpush
