<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="<?php echo base_url('assets');?>/vendor/sneat/assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Login | <?php echo $site['nama_website']?></title>
    <meta name="description" content="" />
    <link rel="icon" type="image/x-icon"
        href="<?php echo base_url('assets');?>/vendor/sneat/assets/img/favicon/favicon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url('assets');?>/vendor/sneat/assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="<?php echo base_url('assets');?>/vendor/sneat/assets/vendor/css/core.css"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?php echo base_url('assets');?>/vendor/sneat/assets/vendor/css/theme-default.css"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?php echo base_url('assets');?>/vendor/sneat/assets/css/demo.css" />
    <link rel="stylesheet"
        href="<?php echo base_url('assets');?>/vendor/sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?php echo base_url('assets');?>/vendor/sneat/assets/vendor/css/pages/page-auth.css" />
    <script src="<?php echo base_url('assets');?>/vendor/sneat/assets/vendor/js/helpers.js"></script>
    <script src="<?php echo base_url('assets');?>/vendor/sneat/assets/js/config.js"></script>
</head>

<body>
    <!-- Content -->

    <div class="container-xxl">
        <div id="ngilang">
            <?= $this->session->flashdata('alert') ?>
        </div>
        <div class="card" style="margin: 20px;">
            <h5 class="card-header">Hasil Pencarian Dengan nama siswa : "<?= $nama ?>"</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-striped" id="example">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php $no=1; foreach($cari as $aa) { ?>
                        <tr>
                            <td><?= $no; ?></td>
                            <td><?= $aa['username'] ?></td>
                            <td><?= $aa['nama'] ?></td>
                            <td><?= $this->Absensi_model->cek_kelas($aa['tahun_masuk']).' '.$aa['kelas']; ?></td>
                        </tr>
                        <?php $no++; } ?>
                    </tbody>
                </table>
            </div>
        </div>
            <a class="btn btn-primary" href="<?php echo base_url('auth/login');?>">Klik disini untuk kembali. . .</a>
    </div>
    <!-- build:js assets/vendor/js/core.js -->
    <script src="<?php echo base_url('assets');?>/vendor/sneat/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="<?php echo base_url('assets');?>/vendor/sneat/assets/vendor/libs/popper/popper.js"></script>
    <script src="<?php echo base_url('assets');?>/vendor/sneat/assets/vendor/js/bootstrap.js"></script>
    <script
        src="<?php echo base_url('assets');?>/vendor/sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js">
    </script>
    <script src="<?php echo base_url('assets');?>/vendor/sneat/assets/vendor/js/menu.js"></script>
    <script src="<?php echo base_url('assets');?>/vendor/sneat/assets/js/main.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
        $('#myalert').delay('slow').slideDown('slow').delay(6500).slideUp(600);
    </script>
</body>

</html>