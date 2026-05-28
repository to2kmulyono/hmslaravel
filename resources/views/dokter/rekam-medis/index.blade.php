@extends('layout.dokter')

@section('title', 'Kelola Rekam Medis')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Rekam Medis Pasien</h1>
    <a href="{{ route('dokter.rekam-medis.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Rekam Medis
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Rekam Medis</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Pasien</th>
                        <th>Keluhan Utama</th>
                        <th>Diagnosa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rekamMedis as $index => $rm)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $rm->created_at->format('d M Y H:i') }}</td>
                        <td>{{ $rm->pasien->nama_user ?? 'Unknown' }}</td>
                        <td>{{ Str::limit($rm->keluhan_utama, 30) }}</td>
                        <td>{{ Str::limit($rm->diagnosa, 30) }}</td>
                        <td>
                            @if($rm->dokter_id == Auth::id())
                            <a href="{{ route('dokter.rekam-medis.edit', $rm->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('dokter.rekam-medis.destroy', $rm->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                            @else
                            <button class="btn btn-secondary btn-sm" disabled title="Hanya dokter pemeriksa yang dapat mengedit">
                                <i class="fas fa-lock"></i> Terkunci
                            </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
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
