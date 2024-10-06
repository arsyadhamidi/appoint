@extends('admin.layout.master')
@section('title', 'Biodata | Appoint')
@section('menuBiodataGuru', 'active')

@section('content')
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('biodata-guru.edit', $gurus->id) }}" class="btn btn-primary">
                        <i class="bx bx-edit"></i>
                        Edit Biodata
                    </a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th colspan="3">Biodata Guru</th>
                        </tr>
                        <tr>
                            <td>NIP</td>
                            <td style="width: 3%">:</td>
                            <td>{{ $gurus->nip ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Nama Lengkap</td>
                            <td style="width: 3%">:</td>
                            <td>{{ $gurus->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>TTL</td>
                            <td style="width: 3%">:</td>
                            <td>{{ $gurus->tmp_lahir ?? '-' }}, {{ $gurus->tgl_lahir ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td style="width: 3%">:</td>
                            <td>{{ $gurus->jk ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Telepon</td>
                            <td style="width: 3%">:</td>
                            <td>{{ $gurus->telp ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td style="width: 3%">:</td>
                            <td>{{ $gurus->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td style="width: 3%">:</td>
                            <td>{{ $gurus->alamat ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-script')
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
@endpush
