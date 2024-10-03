@extends('admin.layout.master')
@section('title', 'Data Guru | Appoint')
@section('menuDataMaster', 'active')
@section('menuDataGuru', 'active')

@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('data-guru.update', $gurus->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('data-guru.index') }}" class="btn btn-primary">
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
                                    <label>NIP</label>
                                    <input type="text" name="nip"
                                        class="form-control @error('nip') is-invalid @enderror"
                                        value="{{ old('nip', $gurus->nip ?? '-') }}" placeholder="Masukan nip" readonly>
                                    @error('nip')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="nama"
                                        class="form-control @error('nama') is-invalid @enderror"
                                        value="{{ old('nama', $gurus->nama ?? '-') }}" placeholder="Masukan nama lengkap">
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg">
                                <div class="row">
                                    <div class="col-lg">
                                        <div class="mb-3">
                                            <label>Tempat Lahir</label>
                                            <input type="text" name="tmp_lahir"
                                                class="form-control @error('tmp_lahir') is-invalid @enderror"
                                                value="{{ old('tmp_lahir', $gurus->tmp_lahir ?? '-') }}"
                                                placeholder="Masukan tempat lahir">
                                            @error('tmp_lahir')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg">
                                        <div class="mb-3">
                                            <label>Tanggal Lahir</label>
                                            <input type="date" name="tgl_lahir"
                                                class="form-control @error('tgl_lahir') is-invalid @enderror"
                                                value="{{ old('tgl_lahir', $gurus->tgl_lahir ?? '-') }}">
                                            @error('tgl_lahir')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Jenis Kelamin</label>
                                    <select name="jk" class="form-control @error('jk') is-invalid @enderror"
                                        id="selectedJekel">
                                        <option value="" selected>Pilih Jenis Kelamin</option>
                                        <option value="Laki-Laki" {{ $gurus->jk == 'Laki-Laki' ? 'selected' : '' }}>
                                            Laki-Laki</option>
                                        <option value="Perempuan" {{ $gurus->jk == 'Perempuan' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                    @error('jk')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $gurus->email ?? '-') }}" placeholder="Masukan email"
                                        readonly>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Nomor Telepon</label>
                                    <input type="number" name="telp"
                                        class="form-control @error('telp') is-invalid @enderror"
                                        value="{{ old('telp', $gurus->telp ?? '-') }}" placeholder="Masukan nomor telepon">
                                    @error('telp')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="ro">
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Alamat Domisili</label>
                                    <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="5"
                                        placeholder="Masukan alamat domisili">{{ old('alamat', $gurus->alamat ?? '-') }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Foto Guru</label>
                                    <input type="file" name="foto_guru"
                                        class="form-control @error('foto_guru') is-invalid @enderror">
                                    @error('foto_guru')
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
            $('#selectedJekel').select2({
                theme: 'bootstrap4',
            });
        });
    </script>
@endpush
