<div class="row">
    <div class="col-lg-3">
        <div class="mb-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Status Autentikasi</h4>
                    <h1>{{ $levelAdmins ?? '0' }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="mb-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Users Registrasi</h4>
                    <h1>{{ $usersAdmins ?? '0' }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="mb-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Jurusan</h4>
                    <h1>{{ $jurusanAdmins ?? '0' }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="mb-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Kelas</h4>
                    <h1>{{ $kelasAdmins ?? '0' }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="mb-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Guru</h4>
                    <h1>{{ $guruAdmins ?? '0' }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="mb-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Siswa</h4>
                    <h1>{{ $siswaAdmins ?? '0' }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="mb-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Jenis Pelanggaran</h4>
                    <h1>{{ $jenisAdmins ?? '0' }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="mb-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Kategori</h4>
                    <h1>{{ $namaAdmins ?? '0' }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="mb-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Pelanggaran</h4>
                    <h1>{{ $pelanggaranAdmins ?? '0' }}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                Data Pelanggaran Perbulan
            </div>
            <div class="card-body">
                <canvas id="pelanggaranChart"></canvas>
            </div>
        </div>
    </div>
</div>

@push('custom-script')
    <script>
        var ctx = document.getElementById('pelanggaranChart').getContext('2d');
        var pelanggaranChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($bulan),
                datasets: [{
                    label: 'Jumlah Pelanggaran',
                    data: @json($data),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush
