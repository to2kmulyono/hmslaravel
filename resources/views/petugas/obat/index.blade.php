@extends('layout.petugas')

@section('title', 'Data Obat')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Manajemen Data Obat</h1>
    <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#modalTambah">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Obat
    </button>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Obat</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Foto</th>
                        <th>Nama Obat</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>BPJS</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($obats as $obat)
                    <tr>
                        <td>{{ $obat->kode_obat ?? '-' }}</td>
                        <td>
                            @if($obat->foto)
                                <img src="{{ asset('storage/foto_obat/' . $obat->foto) }}" alt="Foto Obat" width="50" class="img-thumbnail">
                            @else
                                <span class="text-muted small">No Image</span>
                            @endif
                        </td>
                        <td>{{ $obat->nama_obat }}</td>
                        <td>{{ $obat->kategori ?? '-' }}</td>
                        <td>{{ $obat->satuan ?? '-' }}</td>
                        <td>{{ $obat->stok }}</td>
                        <td>Rp {{ number_format($obat->harga, 0, ',', '.') }}</td>
                        <td>
                            @if($obat->is_bpjs)
                                <span class="badge badge-success">BPJS</span>
                            @else
                                <span class="badge badge-secondary">Umum</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm btn-edit" data-id="{{ $obat->id }}" data-kode="{{ $obat->kode_obat }}" data-nama="{{ $obat->nama_obat }}" data-kategori="{{ $obat->kategori }}" data-satuan="{{ $obat->satuan }}" data-stok="{{ $obat->stok }}" data-harga="{{ $obat->harga }}" data-deskripsi="{{ $obat->deskripsi }}" data-bpjs="{{ $obat->is_bpjs }}" data-toggle="modal" data-target="#modalEdit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('obat.destroy', $obat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus obat ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                <!-- Laravel pagination links removed for DataTables -->
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('obat.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Obat Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode Obat</label>
                        <input type="text" name="kode_obat" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Nama Obat</label>
                        <input type="text" name="nama_obat" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <input type="text" name="kategori" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Satuan</label>
                        <input type="text" name="satuan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" name="stok" class="form-control" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Foto Obat (Opsional)</label>
                        <input type="file" name="foto" class="form-control-file" accept="image/*">
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="isBpjsTambah" name="is_bpjs" value="1" checked>
                            <label class="custom-control-label" for="isBpjsTambah">Ditanggung BPJS</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="" method="POST" id="formEdit" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Obat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode Obat</label>
                        <input type="text" name="kode_obat" id="edit_kode" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Nama Obat</label>
                        <input type="text" name="nama_obat" id="edit_nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <input type="text" name="kategori" id="edit_kategori" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Satuan</label>
                        <input type="text" name="satuan" id="edit_satuan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" name="stok" id="edit_stok" class="form-control" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Harga (Rp)</label>
                        <input type="number" name="harga" id="edit_harga" class="form-control" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Update Foto Obat (Biarkan kosong jika tidak ingin mengubah)</label>
                        <input type="file" name="foto" class="form-control-file" accept="image/*">
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="isBpjsEdit" name="is_bpjs" value="1">
                            <label class="custom-control-label" for="isBpjsEdit">Ditanggung BPJS</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" id="edit_deskripsi" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // DataTables init
        if (!$.fn.dataTable.isDataTable('#dataTable')) {
            $('#dataTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
                },
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true
            });
        }

        // Script untuk modal edit
        $('.btn-edit').on('click', function() {
            let id = $(this).data('id');
            let formUrl = "{{ route('obat.update', ':id') }}".replace(':id', id);
            
            $('#formEdit').attr('action', formUrl);
            $('#edit_kode').val($(this).data('kode'));
            $('#edit_nama').val($(this).data('nama'));
            $('#edit_kategori').val($(this).data('kategori'));
            $('#edit_satuan').val($(this).data('satuan'));
            $('#edit_stok').val($(this).data('stok'));
            $('#edit_harga').val($(this).data('harga'));
            $('#edit_deskripsi').val($(this).data('deskripsi'));
            
            if($(this).data('bpjs') == 1) {
                $('#isBpjsEdit').prop('checked', true);
            } else {
                $('#isBpjsEdit').prop('checked', false);
            }
        });
    });
</script>
@endpush
