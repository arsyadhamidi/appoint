@extends('admin.layout.master')
@section('title', 'Biodata | Appoint')
@section('menuBiodataSiswa', 'active')

@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('biodata-siswa.update', $siswas->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('biodata-siswa.index') }}" class="btn btn-primary">
                            <i class="bx bx-left-arrow-alt"></i>
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i>
                            Simpan Data
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>Pilih Jurusan</label>
                                    <select name="jurusan_id" class="form-control @error('jurusan_id') is-invalid @enderror"
                                        id="selectedJurusan">
                                        <option value="" selected>Pilih Jurusan</option>
                                        @foreach ($jurusans as $jurusan)
                                            <option value="{{ $jurusan->id }}">{{ $jurusan->namajurusan ?? '-' }}</option>
                                        @endforeach
                                    </select>
                                    @error('jurusan_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>Pilih Kelas</label>
                                    <select name="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror"
                                        id="selectedKelas">
                                        <option value="" selected>Pilih Kelas</option>
                                    </select>
                                    @error('kelas_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>NISN</label>
                                    <input type="text" name="nisn"
                                        class="form-control @error('nisn') is-invalid @enderror"
                                        value="{{ old('nisn', $siswas->nisn ?? '-') }}" placeholder="Masukan NISN">
                                    @error('nisn')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="nama"
                                        class="form-control @error('nama') is-invalid @enderror"
                                        value="{{ old('nama', $siswas->nama ?? '-') }}" placeholder="Masukan nama lengkap">
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>Tempat Lahir</label>
                                    <input type="text" name="tmp_lahir"
                                        class="form-control @error('tmp_lahir') is-invalid @enderror"
                                        value="{{ old('tmp_lahir', $siswas->tmp_lahir ?? '-') }}"
                                        placeholder="Masukan tempat lahir">
                                    @error('tmp_lahir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="tgl_lahir"
                                        class="form-control @error('tgl_lahir') is-invalid @enderror"
                                        value="{{ old('tgl_lahir', $siswas->tgl_lahir) }}">
                                    @error('tgl_lahir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>Jenis Kelamin</label>
                                    <select name="jk" class="form-control @error('jk') is-invalid @enderror"
                                        id="selectedJK">
                                        <option value="" selected>Pilih Jenis Kelamin</option>
                                        <option value="Laki-Laki" {{ $siswas->jk == 'Laki-Laki' ? 'selected' : '' }}>
                                            Laki-Laki
                                        </option>
                                        <option value="Perempuan" {{ $siswas->jk == 'Perempuan' ? 'selected' : '' }}>
                                            Perempuan
                                        </option>
                                    </select>
                                    @error('jk')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>Telepon</label>
                                    <input type="number" name="telp"
                                        class="form-control @error('telp') is-invalid @enderror"
                                        value="{{ old('telp', $siswas->telp ?? '0') }}"
                                        placeholder="Masukan nomor telepon">
                                    @error('telp')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>Email Address</label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $siswas->email ?? '0') }}"
                                        placeholder="Masukan email address">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>Telepon Orang Tua</label>
                                    <input type="number" name="telp_ortu"
                                        class="form-control @error('telp_ortu') is-invalid @enderror"
                                        value="{{ old('telp_ortu', $siswas->telp_ortu ?? '0') }}"
                                        placeholder="Masukan telepon orang tua">
                                    @error('telp_ortu')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label>Alamat Domisili</label>
                                    <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="5"
                                        placeholder="Masukan alamat domisili">{{ old('alamat', $siswas->alamat ?? '-') }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label>Foto Siswa</label>
                                    <input type="file" name="foto_siswa"
                                        class="form-control @error('foto_siswa') is-invalid @enderror"
                                        value="{{ old('foto_siswa') }}">
                                    @error('foto_siswa')
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
            $('#selectedKelas').select2({
                theme: 'bootstrap4',
            });
            $('#selectedJK').select2({
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

            $('#selectedJurusan').on('change', function() {
                let id_jurusan = $(this).val();

                $.ajax({
                    type: 'POST',
                    url: "/biodata-siswa/jquerySiswaKelas",
                    data: {
                        id_jurusan: id_jurusan
                    },
                    cache: false,
                    success: function(data) {
                        $('#selectedKelas').html(data);
                    },
                    error: function(data) {
                        console.log('error: ', data);
                    }
                });
            });
        });
    </script>
@endpush
