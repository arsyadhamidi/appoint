<div class="row">
    <div class="col-lg">
        @php
            $siswas = \App\Models\Siswa::where('id', Auth()->user()->siswa_id)->first();
        @endphp
        <div class="card">
            <div class="card-header">
                <a href="{{ route('edit-biodatasiswa.editbiodatasiswa', $siswas->id) }}" class="btn btn-primary">
                    <i class="bx bx-edit"></i>
                    Edit Biodata
                </a>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th colspan="3">Biodata Siswa</th>
                    </tr>
                    <tr>
                        <td>NISN</td>
                        <td style="width: 3%">:</td>
                        <td>{{ $siswas->nisn ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Nama Lengkap</td>
                        <td style="width: 3%">:</td>
                        <td>{{ $siswas->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>TTL</td>
                        <td style="width: 3%">:</td>
                        <td>{{ $siswas->tmp_lahir ?? '-' }}, {{ $siswas->tgl_lahir ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td style="width: 3%">:</td>
                        <td>{{ $siswas->jk ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Jurusan</td>
                        <td style="width: 3%">:</td>
                        <td>{{ $siswas->jurusan->namajurusan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Kelas</td>
                        <td style="width: 3%">:</td>
                        <td>{{ $siswas->kelas->kelas ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Telepon</td>
                        <td style="width: 3%">:</td>
                        <td>{{ $siswas->telp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td style="width: 3%">:</td>
                        <td>{{ $siswas->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Telepon Orang Tua</td>
                        <td style="width: 3%">:</td>
                        <td>{{ $siswas->telp_ortu ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td style="width: 3%">:</td>
                        <td>{{ $siswas->alamat ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

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
