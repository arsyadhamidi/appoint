@extends('admin.layout.master')
@section('title', 'Data Kelas | Appoint')
@section('menuDataMaster', 'active')
@section('menuDataKelas', 'active')

@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('data-kelas.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('data-kelas.index') }}" class="btn btn-primary">
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
                                    <label>Jurusan</label>
                                    <select name="jurusan_id" class="form-control @error('jurusan_id') is-invalid @enderror"
                                        id="selectedJurusan">
                                        <option value="" selected>Pilih Jurusan</option>
                                        @foreach ($jurusans as $data)
                                            <option value="{{ $data->id }}"
                                                {{ old('jurusan_id') == $data->id ? 'selected' : '' }}>
                                                {{ $data->namajurusan ?? '-' }}</option>
                                        @endforeach
                                    </select>
                                    @error('jurusan_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label>Kelas</label>
                                    <input type="text" name="kelas"
                                        class="form-control @error('kelas') is-invalid @enderror"
                                        placeholder="Masukan nama kelas" value="{{ old('kelas') }}">
                                    @error('kelas')
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
            $('#selectedJurusan').select2({
                theme: 'bootstrap4',
            });
        });
    </script>
@endpush
