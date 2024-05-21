<div id="myalert">
  <?php echo $this->session->flashdata('alert', true); $this->session->set_flashdata('alert', '');?>
</div>
<?php foreach ($profil as $u) {?>
<?php if($this->session->userdata('level')<>'Guru') {?>
<div class="row mb-3">
  <div class="col-md-12">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal"
      style="margin-top: 10px;">
      <span class="tf-icons bx bx-search"></span>&nbsp; Presensi di Bulan
    </button>
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#basicModal2"
      style="margin-top: 10px;">
      <span class="tf-icons bx bx-label"></span>&nbsp; Izin Absen
    </button>
    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#largeModal"
      style="margin-top: 10px;">
      <span class="tf-icons bx bx-notification-off"></span>&nbsp; Pelanggaran
    </button>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#basicModal4"
      style="margin-top: 10px;">
      <span class="tf-icons bx bx-award"></span>&nbsp; Prestasi
    </button>
  </div>
</div>
<?php } ?>
<div class="row mb-5">
  <div class="col-md-12">
    <div class="card h-100">
      <ul class="list-group list-group-flush">
        <li class="list-group-item">
          <div class="row">
            <div class="col-md-3"><b>Nama Lengkap</b></div>
            <div class="col-md-9">
              <?php echo $u->nama; ?>
            </div>
          </div>
        </li>
        <li class="list-group-item">
          <div class="row">
            <div class="col-md-3"><b>Tempat, Tgl. Lahir</b></div>
            <div class="col-md-9">
              <?php 
              if(($u->tempat_lahir)==NULL){
                echo"Tempat lahir belum dilengkapi";
              } else{
                echo $u->tempat_lahir;
              }
              ?>,
              <?php 
              if(($u->tanggal_lahir)=='0000-00-00'){
                echo"Tanggal lahir belum dilengkapi";
              } else{
                $this->load->helper('tgl_indo');
                echo date_indo($u->tanggal_lahir);
              }
            ?>
            </div>
          </div>
        </li>
        <li class="list-group-item">
          <div class="row">
            <div class="col-md-3"><b>Email</b></div>
            <div class="col-md-9">
              <?php 
              if(($u->email)==NULL){ echo"Email belum dilengkapi";} else{ echo $u->email;} ?>
            </div>
          </div>
        </li>
        <li class="list-group-item">
          <div class="row">
            <div class="col-md-3"><b>Kelas</b></div>
            <div class="col-md-9">
              <?php 
              if(($u->kelas)==NULL){ echo"Kelas belum dilengkapi";} else{ echo $this->Absensi_model->cek_kelas($u->tahun_masuk).' '.$u->kelas; } ?>
            </div>
          </div>
        </li>
        <li class="list-group-item">
          <div class="row">
            <div class="col-md-3"><b>Nomor HP</b></div>
            <div class="col-md-9">
              <?php 
              if(($u->no_hp)==NULL){ echo"Nomo HP belum dilengkapi";} else{ echo $u->no_hp;} ?>
            </div>
          </div>
        </li>
        <li class="list-group-item">
          <div class="row">
            <div class="col-md-3"><b>Alamat</b></div>
            <div class="col-md-9">
              <?php 
              if(($u->alamat)==NULL){ echo"Alamat belum dilengkapi";} else{ echo $u->alamat;} ?>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</div>
<div class="row mb-3">
  <?php if($data3<>NULL){ ?>
  <div class="col-md-10">
    <div class="card">
      <h5 class="card-header">Izin Tidak Masuk</h5>
      <div class="table-responsive text-nowrap">
        <table class="table">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Keterangan</th>
              <th>Alasan</th>
              <?php if($this->session->userdata('level')<>'Guru') {?>
              <th>Aksi</th>
              <?php } ?>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            <?php $no=1; foreach ($data3 as $uu) {  ?>
            <tr class="table-default">
              <td><i class="fab fa-sketch fa-lg text-warning me-3"></i> <strong><?= $no; ?></strong></td>
              <td><?=  DATE_FORMAT(date_create($uu['tanggal']),"d-M-Y");  ?></td>
              <?php if($uu['keterangan']=="I"){ ?>
              <td><span class="badge bg-label-primary">Izin</span></td>
              <?php } else if($uu['keterangan']=="S"){ ?>
              <td><span class="badge bg-label-warning">Sakit</span></td>
              <?php } else { ?>
              <td><span class="badge bg-label-danger">Alpha</span></td>
              <?php } ?>
              <td><?= $uu['alasan']; ?></td>
              <?php if($this->session->userdata('level')<>'Guru') {?>
              <td>
                <a href="<?php echo site_url('admin/siswa/hapus_izin/'.$uu['id_izin'].'/'.$uu['username']);?>"
                  class="btn btn-sm btn-danger" onClick="return confirm('Apakah anda yakin menghapus izin ini?')"><span
                    class="tf-icons bx bx-trash-alt"></span></a>
              </td>
              <?php } ?>
            </tr>
            <?php $no++;} ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php } ?>
</div>
<div class="row mb-3">
  <?php if($data4<>NULL){ ?>
  <div class="col-md-10">
    <div class="card">
      <h5 class="card-header">Pelanggaran Siswa</h5>
      <div class="table-responsive text-nowrap">
        <table class="table">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Pelanggaran</th>
              <th>Keterangan</th>
              <th>Poin</th>
              <?php if($this->session->userdata('level')<>'Guru') {?>
              <th>Aksi</th>
              <?php } ?>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            <?php $sum=0; $no=1; foreach ($data4 as $uu) {  ?>
            <tr class="table-default">
              <td><i class="fab fa-sketch fa-lg text-warning me-3"></i> <strong><?= $no; ?></strong></td>
              <td><?=  DATE_FORMAT(date_create($uu['tanggal']),"d-M-Y");  ?></td>
              <td><?= $uu['pelanggaran']; ?></td>
              <td><?= $uu['keterangan']; ?></td>
              <td><?= $poin=$uu['poin']; ?></td>
              <?php if($this->session->userdata('level')<>'Guru') {?>
              <td>
                <a href="<?php echo site_url('admin/siswa/hapus_pelanggaran/'.$uu['id_pelanggaran'].'/'.$uu['username']);?>"
                  class="btn btn-sm btn-danger"
                  onClick="return confirm('Apakah anda yakin menghapus pelanggaran ini?')"><span
                    class="tf-icons bx bx-trash-alt"></span></a>
              </td>
              <?php } ?>
            </tr>
            <?php $sum= $sum+$poin; $no++;} ?>
            <tr class="table-default">
              <td colspan="4">Jumlah Poin</td>
              <td><?= $sum; ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php } ?>
</div>
<div class="row mb-3">
  <?php if($data5<>NULL){ ?>
  <div class="col-md-10">
    <div class="card">
      <h5 class="card-header">Prestasi Siswa</h5>
      <div class="table-responsive text-nowrap">
        <table class="table">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Nama Perlombaan</th>
              <th>Juara Ke-</th>
              <th>Keterangan</th>
              <?php if($this->session->userdata('level')<>'Guru') {?>
              <th>Aksi</th>
              <?php } ?>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            <?php $no=1; foreach ($data5 as $uu) {  ?>
            <tr class="table-default">
              <td><i class="fab fa-sketch fa-lg text-warning me-3"></i> <strong><?= $no; ?></strong></td>
              <td><?=  DATE_FORMAT(date_create($uu['tanggal']),"d-M-Y");  ?></td>
              <td><?= $uu['nama']; ?></td>
              <td><?= $uu['juara']; ?></td>
              <td><?= $uu['keterangan']; ?></td>
              <?php if($this->session->userdata('level')<>'Guru') {?>
              <td>
                <a href="<?php echo site_url('admin/siswa/hapus_prestasi/'.$uu['id_prestasi'].'/'.$uu['username']);?>"
                  class="btn btn-sm btn-danger"
                  onClick="return confirm('Apakah anda yakin menghapus prestasi ini?')"><span
                    class="tf-icons bx bx-trash-alt"></span></a>
              </td>
              <?php } ?>
            </tr>
            <?php $no++;} ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php } ?>
</div>

<div class="row mb-3">
  <?php if($data7<>NULL){ ?>
  <div class="col-md-10">
    <div class="card">
      <h5 class="card-header">Karir</h5>
      <div class="table-responsive text-nowrap">
        <table class="table">
          <thead>
            <tr>
              <th>No</th>
              <th>Karir</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            <?php $no=1; foreach ($data7 as $uu) {  ?>
            <tr class="table-default">
              <td><i class="fab fa-sketch fa-lg text-warning me-3"></i> <strong><?= $no; ?></strong></td>
              <td><?= $uu['karir']; ?></td>
              <td><?= $uu['keterangan']; ?></td>
            </tr>
            <?php $no++;} ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php } ?>
</div>

<div class="row mb-3">
  <?php if($data8<>NULL){ ?>
  <div class="col-md-10">
    <div class="card">
      <h5 class="card-header">Pengajuan Pengambilan</h5>
      <div class="table-responsive text-nowrap">
        <table class="table">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Keperluan</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            <?php $no=1; foreach ($data8 as $uu) {  ?>
            <tr class="table-default">
              <td><i class="fab fa-sketch fa-lg text-warning me-3"></i> <strong><?= $no; ?></strong></td>
              <td><?= $uu['tanggal_keperluan']; ?></td>
              <td><?= $uu['keperluan']; ?></td>
            </tr>
            <?php $no++;} ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php } ?>
</div>

<div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1"><span class="tf-icons bx bx-search"></span>&nbsp; Lihat Presensi
          di Bulan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form class="modal-content" method="GET" action="<?php echo site_url('admin/siswa/cek_absen_bulan');?>"
        target="_blank">
        <div class="modal-body">
          <div class="row g-2">
            <div class="col mb-0">
              <label for="emailBasic" class="form-label">Pilih Bulan</label>
              <input type="date" class="form-control" name="bulan" placeholder="Pilih bulan..." required>
              <input type="hidden" name="username" value="<?= $u->username ?>" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Lihat Absen</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="basicModal2" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1"><span class="tf-icons bx bx-search"></span>&nbsp; Izin Absen
          Tidak Masuk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form class="modal-content" method="POST" action="<?php echo site_url('admin/siswa/simpan_izin');?>">
        <div class="modal-body">
          <div class="row g-2">
            <div class="col mb-0">
              <label for="emailBasic" class="form-label">Keterangan</label>
              <select name="keterangan" class="form-control">
                <option value="I">Izin</option>
                <option value="S">Sakit</option>
                <option value="A">Alpha</option>
              </select>
            </div>
          </div>
          <div class="row g-2">
            <div class="col mb-0">
              <label for="emailBasic" class="form-label">Alasan Izin</label>
              <input type="text" class="form-control" name="alasan">
            </div>
          </div>
          <div class="row g-2">
            <div class="col mb-0">
              <label for="emailBasic" class="form-label">Tanggal</label>
              <input type="date" class="form-control" name="tanggal" placeholder="Pilih tanggal..." required>
              <input type="hidden" name="username" value="<?= $u->username ?>" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit Izin</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="largeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1"><span class="tf-icons bx bx-search"></span>&nbsp;Pelanggaran
          Siswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form class="modal-content" method="POST" action="<?php echo site_url('admin/siswa/simpan_pelanggaran');?>">
        <div class="modal-body">
          <div class="row g-2">
            <div class="col mb-0">
              <label for="emailBasic" class="form-label">Pelanggaran</label>
              <select name="id_daftar_pelanggaran" class="form-control pilih">
                <?php foreach($data6 as $pp){ ?>
                  <option value="<?= $pp['id_daftar_pelanggaran'] ?>"><?= $pp['pelanggaran'] ?> (<?= $pp['poin'] ?> poin)</option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="row g-2">
            <div class="col mb-0">
              <label for="emailBasic" class="form-label">Keterangan</label>
              <input type="text" class="form-control" name="keterangan">
            </div>
          </div>
          <div class="row g-2">
            <div class="col mb-0">
              <label for="emailBasic" class="form-label">Tanggal</label>
              <input type="date" class="form-control" name="tanggal" placeholder="Pilih tanggal..." required>
              <input type="hidden" name="username" value="<?= $u->username ?>" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit Pelanggaran</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="basicModal4" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1"><span class="tf-icons bx bx-search"></span>&nbsp;Prestasi
          Siswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form class="modal-content" method="POST" action="<?php echo site_url('admin/siswa/simpan_prestasi');?>">
        <div class="modal-body">
          <div class="row g-2">
            <div class="col mb-0">
              <label for="emailBasic" class="form-label">Nama Perlombaan</label>
              <input type="text" class="form-control" name="nama">
            </div>
          </div>
          <div class="row g-2">
            <div class="col mb-0">
              <label for="emailBasic" class="form-label">Keterangan</label>
              <input type="text" class="form-control" name="keterangan">
            </div>
          </div>
          <div class="row g-2">
            <div class="col mb-0">
              <label for="emailBasic" class="form-label">juara</label>
              <input type="text" class="form-control" name="juara">
            </div>
          </div>
          <div class="row g-2">
            <div class="col mb-0">
              <label for="emailBasic" class="form-label">Tanggal</label>
              <input type="date" class="form-control" name="tanggal" placeholder="Pilih tanggal..." required>
              <input type="hidden" name="username" value="<?= $u->username ?>" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit Prestasi</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php } ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/styles/choices.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>
<script>
  new Choices(document.querySelector(".pilih"));
</script>