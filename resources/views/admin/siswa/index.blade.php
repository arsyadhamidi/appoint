@extends('admin.layout.master')
@section('title', 'Data Siswa | Appoint')
@section('menuDataMaster', 'active')
@section('menuDataSiswa', 'active')

@section('content')
    <div class="row mb-4">
        <div class="col-lg">
            <form action="{{ route('data-siswa.index') }}" method="GET">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Filter Jurusan dan Kelas</h4>
                        <div class="row">
                            <div class="col-lg-4">
                                <select name="jurusan_id" class="form-control @error('jurusan_id') is-invalid @enderror"
                                    id="selectedJurusan">
                                    <option value="" selected>Pilih Jurusan</option>
                                    @foreach ($jurusans as $data)
                                        <option value="{{ $data->id }}"
                                            {{ request('jurusan_id') == $data->id ? 'selected' : '' }}>
                                            {{ $data->namajurusan ?? '-' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
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
                            <div class="col-lg">
                                <button type="submit" class="btn btn-info">
                                    <i class="bx bx-search"></i>
                                    Cari
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('data-siswa.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus"></i>
                        Tambahkan Data Siswa
                    </a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th style="width: 5%">No.</th>
                                <th>Nama</th>
                                <th>TTL</th>
                                <th>JK</th>
                                <th>Jurusan</th>
                                <th>Kelas</th>
                                <th>Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswas as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->nama ?? '-' }}</td>
                                    <td>
                                        {{ $data->tmp_lahir ?? '-' }} ,
                                        {{ \Carbon\Carbon::parse($data->tgl_lahir)->format('d F Y') ?? '-' }}
                                    </td>
                                    <td>{{ $data->jk ?? '-' }}</td>
                                    <td>{{ $data->jurusan->namajurusan ?? '-' }}</td>
                                    <td>{{ $data->kelas->kelas ?? '-' }}</td>
                                    <td>
                                        @if ($data->foto_siswa)
                                            <img src="{{ asset('storage/' . $data->foto_siswa) }}"
                                                style="width: 80px; height:80px; object-fit:cover"
                                                class="img-fluid rounded-circle" alt="">
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('data-siswa.destroy', $data->id) }}" method="POST"
                                            class="d-flex flex-wrap">
                                            @csrf
                                            <a href="{{ route('data-siswa.edit', $data->id) }}"
                                                class="btn btn-sm btn-outline-info mx-2">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            <button type="submit" class="btn btn-sm btn-outline-danger" id="hapusData">
                                                <i class="bx bx-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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
                    url: "/data-siswa/jquerySiswaKelas",
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
    <script>
        $(document).ready(function() {
            @if (Session::has('success'))
                toastr.success("{{ Session::get('success') }}");
            @endif

            @if (Session::has('error'))
                toastr.error("{{ Session::get('error') }}");
            @endif
        });
    </script>
    <script>
        // Mendengarkan acara klik tombol hapus
        $(document).on('click', '#hapusData', function(event) {
            event.preventDefault(); // Mencegah perilaku default tombol

            // Ambil URL aksi penghapusan dari atribut 'action' formulir
            var deleteUrl = $(this).closest('form').attr('action');

            // Tampilkan SweetAlert saat tombol di klik
            Swal.fire({
                icon: 'question',
                title: 'Hapus Data Siswa?',
                text: 'Apakah anda yakin untuk menghapus data ini?',
                showCancelButton: true, // Tampilkan tombol batal
                confirmButtonText: 'Ya',
                confirmButtonColor: '#28a745', // Warna hijau untuk tombol konfirmasi
                cancelButtonText: 'Tidak',
                cancelButtonColor: '#dc3545' // Warna merah untuk tombol pembatalan
            }).then((result) => {
                // Lanjutkan jika pengguna mengkonfirmasi penghapusan
                if (result.isConfirmed) {
                    // Kirim permintaan AJAX DELETE ke URL penghapusan
                    $.ajax({
                        url: deleteUrl,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}" // Kirim token CSRF untuk keamanan
                        },
                        success: function(response) {
                            // Tampilkan pesan sukses jika penghapusan berhasil
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Data successfully deleted.',
                                showConfirmButton: false,
                                timer: 1500 // Durasi pesan success (dalam milidetik)
                            });

                            // Refresh halaman setelah pesan sukses ditampilkan
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500);
                        },
                        error: function(xhr, status, error) {
                            // Tampilkan pesan error jika penghapusan gagal
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Terjadi kesalahan saat menghapus data.',
                                showConfirmButton: false,
                                timer: 1500 // Durasi pesan error (dalam milidetik)
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
