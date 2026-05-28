@extends('layout.dokter')

@section('title', 'Tambah Rekam Medis')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Rekam Medis</h1>
    <a href="{{ route('dokter.rekam-medis.index') }}" class="btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Rekam Medis Baru</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('dokter.rekam-medis.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="pasien_id">Pasien <span class="text-danger">*</span></label>
                <select name="pasien_id" id="pasien_id" class="form-control @error('pasien_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Pasien --</option>
                    @foreach($pasien as $p)
                        <option value="{{ $p->user_id }}" {{ old('pasien_id') == $p->user_id ? 'selected' : '' }}>
                            {{ $p->nama_pasien }} (NIK: {{ $p->nik ?? '-' }})
                        </option>
                    @endforeach
                </select>
                @error('pasien_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="keluhan_utama">Keluhan Utama <span class="text-danger">*</span></label>
                <textarea name="keluhan_utama" id="keluhan_utama" rows="3" class="form-control @error('keluhan_utama') is-invalid @enderror" required>{{ old('keluhan_utama') }}</textarea>
                @error('keluhan_utama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="diagnosa">Diagnosa <span class="text-danger">*</span></label>
                <textarea name="diagnosa" id="diagnosa" rows="3" class="form-control @error('diagnosa') is-invalid @enderror" required>{{ old('diagnosa') }}</textarea>
                @error('diagnosa')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="tindakan">Tindakan</label>
                <textarea name="tindakan" id="tindakan" rows="3" class="form-control @error('tindakan') is-invalid @enderror">{{ old('tindakan') }}</textarea>
                @error('tindakan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="resep_obat" class="d-flex justify-content-between align-items-center">
                    <span>Resep Obat</span>
                    <button type="button" class="btn btn-sm btn-info shadow-sm" data-toggle="modal" data-target="#spkModal">
                        <i class="fas fa-magic"></i> Rekomendasi Obat (SPK)
                    </button>
                </label>
                <textarea name="resep_obat" id="resep_obat" rows="3" class="form-control @error('resep_obat') is-invalid @enderror">{{ old('resep_obat') }}</textarea>
                @error('resep_obat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Simpan Rekam Medis</button>
        </form>
    </div>
</div>

<!-- Modal SPK TOPSIS -->
<div class="modal fade" id="spkModal" tabindex="-1" role="dialog" aria-labelledby="spkModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="spkModalLabel"><i class="fas fa-magic"></i> Rekomendasi Obat (Metode TOPSIS)</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formSpk">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Bobot Kepentingan Stok (1-5)</label>
                                <input type="number" id="bobot_stok" class="form-control" value="3" min="1" max="5">
                                <small class="text-muted">Benefit: Semakin besar stok semakin baik.</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Bobot Kepentingan Harga (1-5)</label>
                                <input type="number" id="bobot_harga" class="form-control" value="4" min="1" max="5">
                                <small class="text-muted">Cost: Semakin murah semakin baik.</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Bobot Status BPJS (1-5)</label>
                                <input type="number" id="bobot_bpjs" class="form-control" value="5" min="1" max="5">
                                <small class="text-muted">Benefit: Obat BPJS lebih direkomendasikan.</small>
                            </div>
                        </div>
                    </div>
                    <div class="text-right mb-3">
                        <button type="button" class="btn btn-primary" id="btnHitungSpk"><i class="fas fa-calculator"></i> Hitung Rekomendasi</button>
                    </div>
                </form>

                <div class="table-responsive d-none" id="hasilSpkContainer">
                    <table class="table table-bordered table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>Ranking</th>
                                <th>Nama Obat</th>
                                <th>Stok</th>
                                <th>Harga</th>
                                <th>BPJS</th>
                                <th>Nilai (V)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="hasilSpkBody">
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
    $('#btnHitungSpk').on('click', function() {
        let btn = $(this);
        btn.html('<i class="fas fa-spinner fa-spin"></i> Menghitung...');
        btn.prop('disabled', true);

        $.ajax({
            url: '{{ route("dokter.rekam-medis.spk-obat") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                bobot_stok: $('#bobot_stok').val(),
                bobot_harga: $('#bobot_harga').val(),
                bobot_bpjs: $('#bobot_bpjs').val(),
            },
            success: function(response) {
                if (response.status === 'success') {
                    let html = '';
                    if (response.data.length === 0) {
                        html = '<tr><td colspan="7" class="text-center">Tidak ada data obat tersedia.</td></tr>';
                    } else {
                        response.data.forEach((obat, index) => {
                            let bpjsBadge = obat.is_bpjs ? '<span class="badge badge-success">Ya</span>' : '<span class="badge badge-secondary">Tidak</span>';
                            let hargaFormat = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(obat.harga);
                            
                            html += `
                                <tr>
                                    <td class="text-center font-weight-bold">${index + 1}</td>
                                    <td>${obat.nama}</td>
                                    <td>${obat.stok}</td>
                                    <td>${hargaFormat}</td>
                                    <td>${bpjsBadge}</td>
                                    <td>${obat.score}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success btn-pilih-obat" data-nama="${obat.nama}">
                                            <i class="fas fa-check"></i> Gunakan
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });
                    }
                    
                    $('#hasilSpkBody').html(html);
                    $('#hasilSpkContainer').removeClass('d-none');
                }
            },
            error: function(err) {
                alert('Terjadi kesalahan saat menghitung SPK.');
                console.error(err);
            },
            complete: function() {
                btn.html('<i class="fas fa-calculator"></i> Hitung Rekomendasi');
                btn.prop('disabled', false);
            }
        });
    });

    $(document).on('click', '.btn-pilih-obat', function() {
        let namaObat = $(this).data('nama');
        let resepField = $('#resep_obat');
        let currentVal = resepField.val();
        
        if (currentVal.trim() === '') {
            resepField.val(namaObat);
        } else {
            resepField.val(currentVal + ', ' + namaObat);
        }
        
        $('#spkModal').modal('hide');
    });
});
</script>
@endpush
