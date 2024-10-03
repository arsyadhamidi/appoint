@extends('admin.layout.master')
@section('title', 'Status Autentikas | Appoint')
@section('menuDataLevel', 'active')

@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('data-level.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('data-level.index') }}" class="btn btn-primary">
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
                                    <label>Status Autentikasi</label>
                                    <input type="text" name="namalevel"
                                        class="form-control @error('namalevel') is-invalid @enderror"
                                        value="{{ old('namalevel') }}" placeholder="Masukan nama status">
                                    @error('namalevel')
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
