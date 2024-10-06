<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Selamat Datang {{ Auth()->user()->name ?? '-' }}! 🎉</h5>
                        <p class="mb-4">
                            Senang bertemu lagi! 🌈 Semangat untuk hasil luar biasa di depan mata.
                        </p>
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <img src="{{ asset('admin/assets/img/illustrations/man-with-laptop-light.png') }}"
                            height="140" alt="View Badge User"
                            data-app-dark-img="illustrations/man-with-laptop-dark.png"
                            data-app-light-img="illustrations/man-with-laptop-light.png" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="mb-3">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th style="width: 5%; text-align:center">No.</th>
                                <th style="text-align:center">Jenis</th>
                                <th style="text-align:center">Nama</th>
                                <th style="text-align:center">Point</th>
                                <th style="text-align:center">Sanksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($namaGurus as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->jenis->jenispelanggaran ?? '-' }}</td>
                                    <td>{{ $data->nama ?? '-' }}</td>
                                    <td>{{ $data->point ?? '-' }}</td>
                                    <td>{{ $data->sanksi ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
