@extends('layout.petugas')

@section('title', 'Data Ruang')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Ruang</h1>
    <a href="{{ route('ruang.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Ruang</a>
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

                        <th>Aksi</th>
                    </tr>
                </thead>
    @foreach($ruangs as $index => $r)
                <tbody>
                    
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

                        <td>
                            <a href="{{ route('ruang.edit', $r->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('ruang.destroy', $r->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Hapus ruang ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
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
