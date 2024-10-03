@extends('admin.layout.master')
@section('title', 'Nama Pelanggaran | Appoint ')
@section('menuDataPelanggaran', 'active')
@section('menuDataNamaPelanggaran', 'active')

@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('data-namapelanggaran.update', $nama->id) }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('data-namapelanggaran.index') }}" class="btn btn-primary">
                            <i class="bx bx-left-arrow-alt"></i>
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bx bx-save"></i>
                            Simpan Data
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Jenis Pelanggaran</label>
                                    <select name="jenispelanggaran_id"
                                        class="form-control @error('jenispelanggaran_id') is-invalid @enderror"
                                        id="selectedJenis">
                                        <option value="" selected>Pilih Jenis Pelanggaran</option>
                                        @foreach ($jenis as $data)
                                            <option value="{{ $data->id }}"
                                                {{ $nama->jenispelanggaran_id == $data->id ? 'selected' : '' }}>
                                                {{ $data->jenispelanggaran ?? '-' }}</option>
                                        @endforeach
                                    </select>
                                    @error('jenispelanggaran_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label>Nama Pelanggaran</label>
                                    <textarea name="nama" class="form-control @error('nama') is-invalid @enderror" rows="5"
                                        placeholder="Masukan nama pelanggaran">{{ old('nama', $nama->nama ?? '-') }}</textarea>
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label>Point Pelanggaran</label>
                                    <textarea name="point" class="form-control @error('point') is-invalid @enderror" rows="5"
                                        placeholder="Masukan point pelanggaran">{{ old('point', $nama->point ?? '-') }}</textarea>
                                    @error('point')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label>Sanksi Pelanggaran</label>
                                    <textarea name="sanksi" class="form-control @error('sanksi') is-invalid @enderror" rows="5"
                                        placeholder="Masukan sanksi pelanggaran">{{ old('sanksi', $nama->sanksi ?? '-') }}</textarea>
                                    @error('sanksi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('custom-script')
    <script>
        $(document).ready(function() {
            $('#selectedJenis').select2({
                theme: 'bootstrap4',
            });
        });
    </script>
@endpush
