<?php
    $pisah=explode("-",$bulan);
    $tahun = $pisah[0];
    $month = $pisah[1];
    $this->db->select('LAST_DAY("'.$bulan.'") as tanggal');
    $end= $this->db->get()->row()->tanggal;
    $pisah=explode("-",$end);
    $date_end = $pisah[2];
?>
<?php foreach ($profil as $u) {?>
<div class="row mb-5">
  <div class="col-md-12">
    <div class="card h-100">
      <ul class="list-group list-group-flush">
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
<div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel1"><span class="tf-icons bx bx-search"></span>&nbsp; Lihat Presensi di Bulan</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form class="modal-content" method="GET" action="<?php echo site_url('admin/siswa/cek_absen_bulan');?>" target="_blank">
				<div class="modal-body">
					<div class="row g-2">
						<div class="col mb-0">
							<label for="emailBasic" class="form-label">Pilih Bulan</label>
							<input type="date" class="form-control" name="bulan" placeholder="Pilih bulan..."
								required>
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
<?php } ?>
<div class="card" style="margin-top: 10px;">
	<div class="table-responsive text-nowrap">
		<table class="table">
			<thead>
				<tr>
					<th>Tanggal</th>
					<th>Masuk</th>
					<th>Pulang</th>
				</tr>
			</thead>
			<tbody>
				<?php for ($i=1; $i<=$date_end ; $i++) { if($i>10){$no=$i;} else {$no='0'.$i;} $tanggal=$tahun.'-'.$month.'-'.$no; ?>
				<tr>
					<td><?= $i.'-'.$month.'-'.$tahun; ?></td>
					<td><?php echo $this->Absensi_model->get_masuk($username,$tanggal); ?>
					</td>
					<td><?php echo $this->Absensi_model->get_pulang($username,$tanggal); ?>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>