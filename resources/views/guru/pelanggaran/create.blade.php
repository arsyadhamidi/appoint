@extends('admin.layout.master')
@section('title', 'Pelanggaran | Appoint')
@section('menuPelanggaranGuru', 'active')

@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('guru-pelanggaran.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('guru-pelanggaran.index') }}" class="btn btn-primary">
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
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>Tanggal</label>
                                    <input type="date" name="tanggal"
                                        class="form-control @error('tanggal') is-invalid @enderror"
                                        value="{{ old('tanggal', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                                    @error('tanggal')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>Pilih Jenis Pelanggaran</label>
                                    <select name="jenispelanggaran_id"
                                        class="form-control @error('jenispelanggaran_id') is-invalid @enderror"
                                        id="selectedJenis">
                                        <option value="" selected>Pilih Jenis Pelanggaran</option>
                                        @foreach ($jenis as $data)
                                            <option value="{{ $data->id }}">{{ $data->jenispelanggaran ?? '-' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('jenispelanggaran_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>Pilih Nama Pelanggaran</label>
                                    <select name="namapelanggaran_id"
                                        class="form-control @error('namapelanggaran_id') is-invalid @enderror"
                                        id="selectedNama">
                                        <option value="" selected>Pilih Nama Pelanggaran</option>
                                    </select>
                                    @error('namapelanggaran_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>Pilih Siswa</label>
                                    <select name="siswa_id" class="form-control @error('siswa_id') is-invalid @enderror"
                                        id="selectedSiswa">
                                        <option value="" selected>Pilih Siswa</option>
                                        @foreach ($siswas as $data)
                                            <option value="{{ $data->id }}"
                                                {{ old('siswa_id') == $data->id ? 'selected' : '' }}>
                                                {{ $data->nisn ?? '-' }}
                                                - {{ $data->nama ?? '-' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('siswa_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label>Keterangan</label>
                                    <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="5"
                                        placeholder="Masukan keterangan">{{ old('keterangan') }}</textarea>
                                    @error('keterangan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label>Bukti Pelanggaran</label>
                                    <input type="file" name="bukti"
                                        class="form-control @error('bukti') is-invalid @enderror">
                                    @error('bukti')
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
            $('#selectedNama').select2({
                theme: 'bootstrap4',
            });
            $('#selectedGuru').select2({
                theme: 'bootstrap4',
            });
            $('#selectedSiswa').select2({
                theme: 'bootstrap4',
            });
            $('#selectedStatus').select2({
                theme: 'bootstrap4',
            });
        });
    </script>
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#selectedJenis').on('change', function() {
                let id_jenis = $(this).val();

                $.ajax({
                    type: 'POST',
                    url: "/guru-pelanggaran/jqueryNamaPelanggaran",
                    data: {
                        id_jenis: id_jenis
                    },
                    cache: false,
                    success: function(data) {
                        $('#selectedNama').html(data);
                    },
                    error: function(data) {
                        console.log('error: ', data);
                    }
                });
            });
        });
    </script>
@endpush
