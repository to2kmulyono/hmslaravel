@extends('layout.admin')

@section('title', 'Riwayat Kunjungan')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-calendar-check mr-2 text-primary"></i>Riwayat Kunjungan Harian</h1>
        <div class="d-flex align-items-center">
            <form action="{{ route('admin.riwayat-antrian') }}" method="GET" class="form-inline mr-2">
                <div class="input-group">
                    <input type="date" class="form-control" name="date" value="{{ $date ?? '' }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
            <button class="btn btn-sm btn-outline-primary shadow-sm" onclick="printData()">
                <i class="fas fa-print fa-sm"></i> Cetak
            </button>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Kunjungan</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $summary['total'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-calendar fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Selesai Dilayani</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $summary['dilayani'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-check-circle fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Sedang Diproses</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $summary['diproses'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-spinner fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $summary['menunggu'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-clock fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list mr-1"></i> Daftar Kunjungan &mdash; {{ \Carbon\Carbon::parse($date)->isoFormat('dddd, D MMMM Y') }}
            </h6>
            <span class="badge badge-primary">{{ $summary['total'] ?? 0 }} kunjungan</span>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th>No. Antrian</th>
                            <th>Nama Pasien</th>
                            <th>Poliklinik</th>
                            <th>Dokter</th>
                            <th>Waktu Mulai</th>
                            <th>Waktu Selesai</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $item)
                        <tr>
                            <td class="font-weight-bold">{{ $item['no_antrian'] }}</td>
                            <td>{{ $item['nama_pasien'] }}</td>
                            <td>{{ $item['poli'] }}</td>
                            <td>{{ $item['dokter'] }}</td>
                            <td>{{ $item['waktu_mulai'] }}</td>
                            <td>{{ $item['waktu_selesai'] }}</td>
                            <td class="text-center">
                                @if($item['status'] == 'Menunggu')
                                    <span class="badge badge-warning px-2 py-1"><i class="fas fa-clock mr-1"></i>Menunggu</span>
                                @elseif($item['status'] == 'Diproses')
                                    <span class="badge badge-info px-2 py-1"><i class="fas fa-spinner mr-1"></i>Diproses</span>
                                @elseif($item['status'] == 'Dilayani')
                                    <span class="badge badge-success px-2 py-1"><i class="fas fa-check mr-1"></i>Selesai</span>
                                @else
                                    <span class="badge badge-secondary px-2 py-1">{{ $item['status'] }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="fas fa-calendar-times fa-2x mb-2 d-block"></i>
                                Tidak ada data kunjungan pada tanggal ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    if (!$.fn.DataTable.isDataTable('#dataTable')) {
        $('#dataTable').DataTable({
            "order": [],
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            }
        });
    }
});

function printData() {
    var tableEl = document.getElementById("dataTable");
    var style = '<style>table{border-collapse:collapse;width:100%}th,td{border:1px solid #ddd;padding:8px;text-align:left}th{background-color:#f2f2f2}h2{text-align:center}</style>';
    var html = style + '<h2>Laporan Kunjungan Pasien &mdash; {{ \Carbon\Carbon::parse($date)->format("d/m/Y") }}</h2>' + tableEl.outerHTML;
    var win = window.open('', 'Print');
    win.document.open();
    win.document.write('<html><head><title>Laporan Kunjungan</title></head><body>' + html + '</body></html>');
    win.document.close();
    setTimeout(function() { win.print(); win.close(); }, 500);
}
</script>
@endpush
