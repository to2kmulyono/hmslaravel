@extends('layout.dokter')

@section('title', 'Data Obat')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Obat</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Obat Tersedia</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Obat</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($obat as $index => $o)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $o->nama_obat }}</td>
                        <td>{{ $o->kategori ?? '-' }}</td>
                        <td>
                            @if($o->stok > 10)
                                <span class="badge badge-success">{{ $o->stok }}</span>
                            @elseif($o->stok > 0)
                                <span class="badge badge-warning">{{ $o->stok }}</span>
                            @else
                                <span class="badge badge-danger">Habis</span>
                            @endif
                        </td>
                        <td>Rp {{ number_format($o->harga, 0, ',', '.') }}</td>
                        <td>{{ $o->deskripsi ?? '-' }}</td>
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
