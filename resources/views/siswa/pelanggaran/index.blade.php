@extends('admin.layout.master')
@section('title', 'Pelanggaran | Appoint')
@section('menuPelanggaranSiswa', 'active')

@section('content')
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th style="width: 5%; text-align:center">No.</th>
                                <th style="text-align:center">Siswa</th>
                                <th style="text-align:center">Jurusan</th>
                                <th style="text-align:center">Kelas</th>
                                <th style="text-align:center">Guru</th>
                                <th style="text-align:center">Jenis</th>
                                <th style="text-align:center">Point</th>
                                <th style="text-align:center">Status</th>
                                <th style="text-align:center">Bukti</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pelanggarans as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->siswa->nama ?? '-' }}</td>
                                    <td>{{ $data->jurusan->namajurusan ?? '-' }}</td>
                                    <td>{{ $data->kelas->kelas ?? '-' }}</td>
                                    <td>{{ $data->guru->nama ?? '-' }}</td>
                                    <td>{{ $data->jenis->jenispelanggaran ?? '-' }}</td>
                                    <td>{{ $data->nama->point ?? '-' }}</td>
                                    <td>{{ $data->status ?? '-' }}</td>
                                    <td>
                                        @if ($data->bukti)
                                            <img src="{{ asset('storage/' . $data->bukti) }}" class="img-fluid"
                                                style="width: 100px; height: 100px; object-fit:cover" alt="">
                                        @else
                                            -
                                        @endif
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
            $('#selectedJenis').select2({
                theme: 'bootstrap4',
            });
            $('#selectedNama').select2({
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
                    url: "/data-pelanggaran/jqueryNamaPelanggaran",
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
                icon: 'info',
                title: 'Hapus Data Pelanggaran ?',
                text: 'Anda yakin untuk menghapus data ini ?',
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
                                title: 'Berhasil',
                                text: 'Data Berhasil Dihapus.',
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
