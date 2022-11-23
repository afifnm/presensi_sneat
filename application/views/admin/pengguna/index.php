<div id="myalert">
  <?php echo $this->session->flashdata('alert', true)?>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card mb-4">
      <div class="card-body">
        <div class="row">
          <div class="col-md-8">
            <h4> Kelas <?php echo $this->Absensi_model->cek_kelas($tahun_masuk).' '.$kelas; ?></h4>
          </div>
          <div class="col-md-4">
            <button type="button" class="btn btn-primary pull-right" data-bs-toggle="modal"
              data-bs-target="#backDropModal" style="float: right;">
              <span class="tf-icons bx bx-search"></span>&nbsp; Lihat Absen Pada Tanggal
            </button>
          </div>
        </div>
      </div>
      <hr class="my-0">
      <div class="card-body">
        <table class="table table-striped" style="width:100%">
          <thead>
            <tr>
              <th>No</th>
              <th>NIS</th>
              <th>Nama</th>
              <th>Masuk</th>
              <th>Pulang</th>
              <th style="text-align: center;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            date_default_timezone_set("Asia/Jakarta");
            $tanggal = date("Y-m-d");
            $no = 1;
            foreach ($data2 as $user) {?>
            <tr>
              <td><?php echo $no; ?></td>
              <td><?php echo $user['username']; ?></td>
              <td><?php echo $user['nama']; ?></td>
              <td><?php echo $this->Absensi_model->get_masuk($user['username'],$tanggal); ?></td>
              <td><?php echo $this->Absensi_model->get_pulang($user['username'],$tanggal); ?></td>
              <td align="center">
                <?php if($this->session->userdata('level')=='Admin'){ ?>
                <a href="<?php echo site_url('admin/siswa/delete_data/'.$user['id'].'/'.$tahun_masuk.'/'.$kelas);?>"
                  class="btn btn-sm btn-danger" onClick="return confirm('Apakah anda yakin menghapus data ini?')"><span
                    class="tf-icons bx bx-trash-alt"></span></a>
                <?php } ?>
                <a href="<?php echo site_url('admin/siswa/profil/'.$user['username']);?>"
                  class="btn btn-sm btn-warning"><span class="tf-icons bx bx-search"></span></a>
              </td>
            </tr>
            <?php $no++; } ?>
          </tbody>
        </table>
      </div>
      <!-- /Account -->
    </div>
  </div>
</div>

<script>
  function confirmDialog() {
    return confirm('Apakah anda yakin akan menghapus data ini?')
  }
</script>
<div class="modal fade" id="backDropModal" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <form class="modal-content" method="get" action="<?php echo site_url('admin/siswa/lihat');?>" target="_blank">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          <span class="tf-icons bx bx-search"></span>&nbsp; Lihat Absen Pada Tanggal
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Tanggal</label>
            <input type="date" class="form-control" placeholder="Tanggal" name="tanggal" required>
            <input type="hidden" name="tahun_masuk" value="<?= $tahun_masuk ?>">
            <input type="hidden" name="kelas" value="<?= $kelas ?>">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Close
          </button>
          <button type="submit" class="btn btn-primary">Lihat</button>
        </div>
    </form>
  </div>
</div>