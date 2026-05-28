@extends('layout.petugas')

@section('title', 'Tambah Ruang')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Data Ruang</h1>
    <a href="{{ route('ruang.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('ruang.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_ruang">Nama Ruang</label>
                <input type="text" class="form-control" id="nama_ruang" name="nama_ruang" required placeholder="Contoh: Kamar Operasi" value="{{ old('nama_ruang') }}">
            </div>
            <div class="form-group">
                <label for="kapasitas">Kapasitas (orang)</label>
                <input type="number" class="form-control" id="kapasitas" name="kapasitas" required min="1" placeholder="Contoh: 4" value="{{ old('kapasitas') }}">
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="Tersedia" {{ old('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="Penuh" {{ old('status') == 'Penuh' ? 'selected' : '' }}>Penuh</option>
                    <option value="Maintenance" {{ old('status') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
        </form>
    </div>
</div>
@endsection
