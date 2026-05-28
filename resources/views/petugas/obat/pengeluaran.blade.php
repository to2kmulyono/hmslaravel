@extends('layout.petugas')

@section('title', 'Proses Pengeluaran Obat')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Proses Pengeluaran Obat</h1>
    <a href="{{ route('obat.resep') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali ke Antrean</a>
</div>

<div class="row">
    <!-- Info Pasien & Rekam Medis -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Detail Pasien & Resep</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <img class="img-profile rounded-circle" style="width: 100px;" src="{{ asset('img/default.jpg') }}" alt="Profile">
                    <h5 class="mt-3 font-weight-bold text-dark">{{ $rekam->pasien->nama_user ?? 'Unknown' }}</h5>
                    <p class="text-muted mb-0">NIK: {{ $pasien->nik ?? '-' }}</p>
                </div>
                <hr>
                <div class="mb-3">
                    <p class="mb-1 text-xs font-weight-bold text-uppercase text-gray-500">Tgl Periksa</p>
                    <p class="mb-0 text-dark">{{ $rekam->created_at->format('d F Y, H:i') }}</p>
                </div>
                <div class="mb-3">
                    <p class="mb-1 text-xs font-weight-bold text-uppercase text-gray-500">Dokter Pemeriksa</p>
                    <p class="mb-0 text-dark">{{ $rekam->dokter->nama_user ?? 'Unknown' }}</p>
                </div>
                <div class="mb-3">
                    <p class="mb-1 text-xs font-weight-bold text-uppercase text-gray-500">Diagnosa</p>
                    <p class="mb-0 text-dark">{{ $rekam->diagnosa }}</p>
                </div>
                <div class="mb-3">
                    <p class="mb-1 text-xs font-weight-bold text-uppercase text-gray-500">Catatan Resep Obat</p>
                    <div class="p-3 bg-light rounded text-dark border-left-info">
                        <strong>{{ $rekam->resep_obat }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Input Pengeluaran -->
    <div class="col-xl-8 col-lg-7">
        <!-- Riwayat Obat jika ada -->
        @if(count($pengeluaran) > 0)
        <div class="card shadow mb-4 border-left-success">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Obat Yang Telah Diberikan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th>Obat</th>
                                <th>Jml</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengeluaran as $p)
                            <tr>
                                <td>{{ $p->obat->nama_obat }}</td>
                                <td>{{ $p->jumlah }} {{ $p->obat->satuan }}</td>
                                <td>{{ $p->keterangan ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <!-- Form Tambah Obat -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Form Pemberian Obat</h6>
                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalPilihObat">
                    <i class="fas fa-search"></i> Pilih Obat
                </button>
            </div>
            <div class="card-body">
                <!-- Input Temporary -->
                <div class="row mb-3 p-3 bg-light rounded mx-0">
                    <div class="col-md-5">
                        <div class="form-group mb-0">
                            <label class="text-xs font-weight-bold text-dark">Nama Obat</label>
                            <input type="text" id="temp_nama_obat" class="form-control form-control-sm" readonly placeholder="Klik Pilih Obat">
                            <input type="hidden" id="temp_obat_id">
                            <input type="hidden" id="temp_obat_kode">
                            <input type="hidden" id="temp_obat_harga">
                            <input type="hidden" id="temp_obat_stok">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-0">
                            <label class="text-xs font-weight-bold text-dark">Jumlah</label>
                            <input type="number" id="temp_jumlah" class="form-control form-control-sm" min="1" value="1">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-0">
                            <label class="text-xs font-weight-bold text-dark">Keterangan/Dosis</label>
                            <input type="text" id="temp_keterangan" class="form-control form-control-sm" placeholder="Contoh: 3x1 sesudah makan">
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" id="btnTambahList" class="btn btn-sm btn-primary w-100"><i class="fas fa-plus"></i> Tambah</button>
                    </div>
                </div>

                <!-- Form Submit Final -->
                <form action="{{ route('obat.pengeluaran.store', $rekam->id) }}" method="POST" id="formPengeluaran">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="table-obat">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Obat</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Subtotal</th>
                                    <th>Keterangan</th>
                                    <th width="50">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data diisi via jQuery -->
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <th colspan="4" class="text-right">TOTAL</th>
                                    <th colspan="3" id="total_semua" class="font-weight-bold text-danger text-lg">Rp 0</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="text-right mt-3">
                        <button type="submit" class="btn btn-success btn-lg shadow-sm" id="btnSimpan" disabled>
                            <i class="fas fa-save"></i> Simpan & Selesaikan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pilih Obat -->
<div class="modal fade" id="modalPilihObat" tabindex="-1" role="dialog" aria-labelledby="modalPilihObatLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalPilihObatLabel">Pilih Obat Tersedia</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover w-100" id="tableDataObat">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Obat</th>
                                <th>Kategori</th>
                                <th>Satuan</th>
                                <th>Stok</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($obats as $obat)
                            <tr>
                                <td>{{ $obat->kode_obat ?? '-' }}</td>
                                <td>{{ $obat->nama_obat }}</td>
                                <td>{{ $obat->kategori ?? '-' }}</td>
                                <td>{{ $obat->satuan ?? '-' }}</td>
                                <td class="{{ $obat->stok < 10 ? 'text-danger font-weight-bold' : '' }}">{{ $obat->stok }}</td>
                                <td>Rp {{ number_format($obat->harga, 0, ',', '.') }}</td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm btn-pilih" 
                                        data-id="{{ $obat->id }}" 
                                        data-kode="{{ $obat->kode_obat }}" 
                                        data-nama="{{ $obat->nama_obat }}" 
                                        data-stok="{{ $obat->stok }}" 
                                        data-harga="{{ $obat->harga }}">
                                        <i class="fas fa-check"></i> Pilih
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Init DataTables for modal
        $('#tableDataObat').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            }
        });

        // Event pilih obat dari modal
        $(document).on('click', '.btn-pilih', function() {
            let id = $(this).data('id');
            let kode = $(this).data('kode');
            let nama = $(this).data('nama');
            let stok = $(this).data('stok');
            let harga = $(this).data('harga');

            $('#temp_obat_id').val(id);
            $('#temp_obat_kode').val(kode || '-');
            $('#temp_nama_obat').val(nama);
            $('#temp_obat_stok').val(stok);
            $('#temp_obat_harga').val(harga);
            
            // Set max jumlah based on stock
            $('#temp_jumlah').attr('max', stok);
            $('#temp_jumlah').val(1);
            $('#temp_keterangan').val('');
            $('#temp_jumlah').focus();

            $('#modalPilihObat').modal('hide');
        });

        let totalKeseluruhan = 0;
        let obatIdsInCart = [];

        // Format currency helper
        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
        }

        function updateTotal() {
            $('#total_semua').text(formatRupiah(totalKeseluruhan));
            if(totalKeseluruhan > 0) {
                $('#btnSimpan').prop('disabled', false);
            } else {
                $('#btnSimpan').prop('disabled', true);
            }
        }

        // Event Tambah ke List
        $('#btnTambahList').on('click', function() {
            let id = $('#temp_obat_id').val();
            let kode = $('#temp_obat_kode').val();
            let nama = $('#temp_nama_obat').val();
            let stok = parseInt($('#temp_obat_stok').val());
            let harga = parseInt($('#temp_obat_harga').val());
            let jumlah = parseInt($('#temp_jumlah').val());
            let keterangan = $('#temp_keterangan').val();

            if (!id) {
                Swal.fire('Error', 'Silakan pilih obat terlebih dahulu!', 'error');
                return;
            }

            if (jumlah < 1 || isNaN(jumlah)) {
                Swal.fire('Error', 'Jumlah tidak valid!', 'error');
                return;
            }

            if (jumlah > stok) {
                Swal.fire('Stok Tidak Cukup', 'Stok obat tersisa: ' + stok, 'warning');
                return;
            }

            if (obatIdsInCart.includes(id)) {
                Swal.fire('Sudah Ditambahkan', 'Obat ini sudah ada di dalam list. Hapus terlebih dahulu jika ingin mengubah jumlah.', 'info');
                return;
            }

            let subtotal = harga * jumlah;
            totalKeseluruhan += subtotal;

            let rowHtml = `
                <tr>
                    <td>${kode}<input type="hidden" name="obat_id[]" value="${id}"></td>
                    <td>${nama}</td>
                    <td>${jumlah}<input type="hidden" name="jumlah[]" value="${jumlah}"></td>
                    <td>${formatRupiah(harga)}<input type="hidden" name="harga[]" value="${harga}"></td>
                    <td class="subtotal-col" data-val="${subtotal}">${formatRupiah(subtotal)}<input type="hidden" name="subtotal[]" value="${subtotal}"></td>
                    <td>${keterangan}<input type="hidden" name="keterangan[]" value="${keterangan}"></td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm btn-hapus-row" data-id="${id}" data-subtotal="${subtotal}">
                            <i class="fas fa-times"></i>
                        </button>
                    </td>
                </tr>
            `;

            $('#table-obat tbody').append(rowHtml);
            obatIdsInCart.push(id);
            updateTotal();

            // Clear temp inputs
            $('#temp_obat_id').val('');
            $('#temp_obat_kode').val('');
            $('#temp_nama_obat').val('');
            $('#temp_obat_stok').val('');
            $('#temp_obat_harga').val('');
            $('#temp_jumlah').val(1);
            $('#temp_keterangan').val('');
        });

        // Event Hapus Row
        $(document).on('click', '.btn-hapus-row', function() {
            let id = $(this).data('id');
            let subtotal = parseInt($(this).data('subtotal'));
            
            // Remove from array
            obatIdsInCart = obatIdsInCart.filter(item => item != id);
            
            // Remove row and update total
            totalKeseluruhan -= subtotal;
            $(this).closest('tr').remove();
            updateTotal();
        });

        // Form submit validation
        $('#formPengeluaran').on('submit', function(e) {
            if(obatIdsInCart.length === 0) {
                e.preventDefault();
                Swal.fire('Keranjang Kosong', 'Silakan tambahkan setidaknya satu obat.', 'warning');
            }
        });
    });
</script>
@endpush
