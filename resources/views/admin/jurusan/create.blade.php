@extends('admin.layout.master')
@section('title', 'Data Jurusan | Appoint')
@section('menuDataMaster', 'active')
@section('menuDataJurusan', 'active')

@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('data-jurusan.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('data-jurusan.index') }}" class="btn btn-primary">
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
                                    <label>Kode Jurusan</label>
                                    <input type="text" name="kodejurusan"
                                        class="form-control @error('kodejurusan') is-invalid @enderror"
                                        value="{{ old('kodejurusan') }}" placeholder="Masukan kode jurusan">
                                    @error('kodejurusan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label>Nama Jurusan</label>
                                    <input type="text" name="namajurusan"
                                        class="form-control @error('namajurusan') is-invalid @enderror"
                                        value="{{ old('namajurusan') }}" placeholder="Masukan nama jurusan">
                                    @error('namajurusan')
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
