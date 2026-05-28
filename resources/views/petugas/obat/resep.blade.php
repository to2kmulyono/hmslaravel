@extends('layout.petugas')

@section('title', 'Antrean Resep')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Antrean Resep Obat</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Pasien Menunggu Resep</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tgl Periksa</th>
                        <th>Nama Pasien</th>
                        <th>Dokter</th>
                        <th>Diagnosa & Catatan Resep</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($resep as $index => $r)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $r->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $r->pasien->nama_user ?? 'Unknown' }}</td>
                        <td>{{ $r->dokter->nama_user ?? 'Unknown' }}</td>
                        <td>
                            <strong>Diagnosa:</strong> {{ \Illuminate\Support\Str::limit($r->diagnosa, 50) }}<br>
                            <strong>Resep:</strong> <span class="text-info">{{ $r->resep_obat }}</span>
                        </td>
                        <td>
                            @if($r->pengeluaran_obat_exists)
                                <span class="badge badge-success px-3 py-2 shadow-sm"><i class="fas fa-check-circle"></i> Selesai</span>
                            @else
                                <a href="{{ route('obat.pengeluaran', $r->id) }}" class="btn btn-primary btn-sm shadow-sm">
                                    <i class="fas fa-pills"></i> Proses Obat
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $resep->links() }}
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
            "info": false
        });
    });
</script>
@endpush
