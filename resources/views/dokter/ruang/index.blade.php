@extends('layout.dokter')

@section('title', 'Data Ruang')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Ruang</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Ruang Rumah Sakit</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Ruang</th>
                        <th>Kapasitas</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ruang as $index => $r)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $r->nama_ruang }}</td>
                        <td>{{ $r->kapasitas }} Orang</td>
                        <td>
                            @if($r->status == 'Tersedia')
                                <span class="badge badge-success">{{ $r->status }}</span>
                            @elseif($r->status == 'Penuh')
                                <span class="badge badge-danger">{{ $r->status }}</span>
                            @else
                                <span class="badge badge-warning">{{ $r->status }}</span>
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
