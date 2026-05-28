@extends('layout.admin')

@section('title', 'Laporan Riwayat Pengeluaran Obat')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Laporan Riwayat Obat</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Riwayat Pengeluaran Obat</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Waktu Transaksi</th>
                        <th>Kode Obat</th>
                        <th>Nama Obat</th>
                        <th>Pasien</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayatObat as $item)
                    <tr>
                        <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $item->obat->kode_obat ?? '-' }}</td>
                        <td>{{ $item->obat->nama_obat ?? 'Obat Terhapus' }}</td>
                        <td>{{ $item->rekamMedis->pasien->nama_user ?? 'Unknown' }}</td>
                        <td>{{ $item->jumlah }} {{ $item->obat->satuan ?? '' }}</td>
                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td class="font-weight-bold text-danger">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $riwayatObat->links() }}
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
