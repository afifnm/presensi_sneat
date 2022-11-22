<div id="myalert">
  <?php echo $this->session->flashdata('alert', true)?>
</div>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Selamat Datang Di Aplikasi Presensi 🎉</h5>
                            <p class="mb-4">Halaman Admin ini berfungsi untuk merekap data absen tiap kelas dan data siswa tiap kelas.</p>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="<?php echo site_url('assets/vendor/sneat');?>/assets/img/illustrations/man-with-laptop-light.png" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png" height="140">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>