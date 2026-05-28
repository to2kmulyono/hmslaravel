@extends('layout.pasien')

@section('title', 'Riwayat Resep')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Riwayat Resep Obat</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Resep Obat Anda</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Tanggal</th>
                        <th width="15%">Dokter</th>
                        <th width="20%">Diagnosa</th>
                        <th width="25%">Detail Resep</th>
                        <th width="20%">Status Penebusan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatResep as $index => $resep)
                    <tr>
                        <td class="text-center">{{ $riwayatResep->firstItem() + $index }}</td>
                        <td>{{ $resep->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $resep->dokter->nama_user ?? 'Unknown' }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($resep->diagnosa, 50) }}</td>
                        <td>
                            <span class="text-info">{{ $resep->resep_obat }}</span>
                        </td>
                        <td>
                            @if($resep->pengeluaranObat->count() > 0)
                                <div class="badge badge-success mb-2 px-3 py-2 shadow-sm"><i class="fas fa-check-circle"></i> Sudah Ditebus</div>
                                <ul class="list-unstyled small mb-0 pl-3 border-left-success">
                                    @foreach($resep->pengeluaranObat as $po)
                                        <li>• {{ $po->obat->nama_obat ?? 'Obat' }} ({{ $po->jumlah }} {{ $po->obat->satuan ?? '' }})</li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="badge badge-warning px-3 py-2 shadow-sm"><i class="fas fa-clock"></i> Belum Ditebus / Diproses</div>
                                <div class="small text-muted mt-1">
                                    Silakan tebus resep ini di Apotek/Farmasi.
                                </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <img src="{{ asset('img/undraw_medicine_b1ol.svg') }}" alt="No Data" width="150" class="mb-3 opacity-50">
                            <p class="text-muted mb-0">Belum ada riwayat resep obat untuk Anda.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $riwayatResep->links() }}
        </div>
    </div>
</div>
@endsection
