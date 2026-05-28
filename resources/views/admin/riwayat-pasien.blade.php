@extends('layout.admin')

@section('title', 'Histori Pasien')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-history mr-2 text-primary"></i>Histori Kunjungan Pasien</h1>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-filter mr-1"></i> Filter Data</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.riwayat-pasien') }}" id="filter-form">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="small font-weight-bold">Cari Nama / Kode</label>
                        <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Nama pasien atau dokter...">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="small font-weight-bold">Tanggal Mulai</label>
                        <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="small font-weight-bold">Tanggal Akhir</label>
                        <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="small font-weight-bold">Poliklinik</label>
                        <select class="form-control" name="poliklinik">
                            <option value="">-- Semua --</option>
                            @foreach($polikliniks as $poli)
                                <option value="{{ $poli->id }}" {{ request('poliklinik') == $poli->id ? 'selected' : '' }}>
                                    {{ $poli->nama_poliklinik }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="small font-weight-bold">Dokter</label>
                        <select class="form-control" name="dokter">
                            <option value="">-- Semua --</option>
                            @foreach($dokters as $dr)
                                <option value="{{ $dr->id }}" {{ request('dokter') == $dr->id ? 'selected' : '' }}>
                                    {{ $dr->nama_dokter }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 mb-3 d-flex align-items-end">
                        <div class="btn-group w-100">
                            <button type="submit" class="btn btn-primary" title="Filter">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="{{ route('admin.riwayat-pasien') }}" class="btn btn-secondary" title="Reset">
                                <i class="fas fa-sync"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-table mr-1"></i> Data Kunjungan Pasien</h6>
            <span class="badge badge-success">Total: {{ $riwayatPasien->total() }} rekaman</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th width="4%">No</th>
                            <th>Nama Pasien</th>
                            <th>Poliklinik</th>
                            <th>Dokter</th>
                            <th>Tanggal</th>
                            <th>Waktu Mulai</th>
                            <th>Waktu Selesai</th>
                            <th width="8%" class="text-center">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayatPasien as $index => $riwayat)
                        <tr>
                            <td class="text-center">{{ ($riwayatPasien->currentPage() - 1) * $riwayatPasien->perPage() + $index + 1 }}</td>
                            <td>{{ $riwayat->pasien->nama_pasien ?? $riwayat->nama_pasien }}</td>
                            <td>{{ $riwayat->poliklinik->nama ?? $riwayat->poliklinik }}</td>
                            <td>{{ $riwayat->dokter->nama_dokter ?? $riwayat->nama_dokter }}</td>
                            <td>{{ $riwayat->tanggal_kunjungan ? $riwayat->tanggal_kunjungan->format('d/m/Y') : ($riwayat->tanggal ?? '-') }}</td>
                            <td>{{ $riwayat->waktu_mulai ? $riwayat->waktu_mulai->format('H:i') : '-' }}</td>
                            <td>{{ $riwayat->waktu_selesai ? $riwayat->waktu_selesai->format('H:i') : '-' }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-info view-details shadow-sm" data-id="{{ $riwayat->id }}" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="fas fa-search fa-2x mb-2 d-block"></i>
                                Tidak ada data kunjungan pasien ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $riwayatPasien->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="detailsModalLabel"><i class="fas fa-file-medical mr-1"></i> Detail Kunjungan Pasien</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modalSpinner" class="text-center py-4">
                    <div class="spinner-border text-info" role="status">
                        <span class="sr-only">Memuat...</span>
                    </div>
                    <p class="mt-2 text-muted small">Memuat data...</p>
                </div>
                <div id="modalContent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
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
            "paging": false,
            "searching": false,
            "info": false,
            "ordering": true,
            "responsive": true,
            "language": {
                "emptyTable": "Tidak ada data kunjungan pasien"
            }
        });
    }

    // View details
    $(document).on('click', '.view-details', function() {
        const id = $(this).data('id');
        $('#modalContent').html('');
        $('#modalSpinner').show();
        $('#detailsModal').modal('show');

        $.ajax({
            url: '/admin/riwayat-pasien/' + id,
            type: 'GET',
            success: function(response) {
                $('#modalSpinner').hide();
                $('#modalContent').html(response);
            },
            error: function() {
                $('#modalSpinner').hide();
                $('#modalContent').html('<div class="alert alert-danger">Gagal memuat detail data. Silakan coba lagi.</div>');
            }
        });
    });
});
</script>
@endpush
