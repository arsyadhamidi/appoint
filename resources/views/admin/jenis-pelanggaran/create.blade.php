@extends('admin.layout.master')
@section('title', 'Jenis Pelanggaran | Appoint')
@section('menuDataPelanggaran', 'active')
@section('menuDataJenisPelanggaran', 'active')

@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('data-jenispelanggaran.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('data-jenispelanggaran.index') }}" class="btn btn-primary">
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
                                    <textarea name="jenispelanggaran" class="form-control @error('jenispelanggaran') is-invalid @enderror" rows="5"
                                        placeholder="Masukan jenis pelanggaran">{{ old('jenispelanggaran') }}</textarea>
                                    @error('jenispelanggaran')
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
