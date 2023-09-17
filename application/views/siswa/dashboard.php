<?php
date_default_timezone_set("Asia/Jakarta");
$pukul = date("H:i:s");
// $pukul = date("15:10:00");
 ?>
<div id="lokasi_null">
	<div class="alert alert-primary alert-dismissible">
		<i class="bx bx-location-plus"></i> Fitur GPS pada perangkat belum aktif. Aktifkan GPS dan refresh ulang halaman.
	</div>
</div>
<div id="lokasi_salah">
	<div class="alert alert-primary alert-dismissible">
		<i class="bx bx-location-plus"></i> Kamu belum berada dalam jangkauan lokasi sekolah.
	</div>
</div>
<div id="lokasi_benar">
	<div class="alert alert-primary alert-dismissible">
		<?php if (($this->Absensi_model->cek_absen_pulang_now()>0) && ($pukul>=date('15:00') && ($pukul<=date('17:00')))) { ?>
		Kamu sudah melakukan absen pulang.
		<?php } elseif (($this->Absensi_model->cek_absen_masuk_now()>0) && ($pukul>=date('05:30') && ($pukul<=date('09:00')))) { ?>
		Kamu sudah melakukan absen masuk.
		<?php } else { ?>
		<i class="bx bx-location-plus"></i>Kamu sudah berada dalam jangkauan lokasi sekolah.
		<?php } ?>
	</div>
	<?php if (($pukul>=date('05:30') && ($pukul<=date('12:00')))) { ?>
	<a href="<?php echo site_url('siswa/home/masuk');?>">
		<div class="d-grid gap-2 col-lg-6 mx-auto">
			<button type="button" class="btn btn-primary">
				<span class="tf-icons bx bx-pie-chart-alt"></span>&nbsp; Absen Masuk
			</button>
		</div>
	</a>
	<?php } elseif (($pukul>=date('12:01') && ($pukul<=date('18:00')))) { ?>
	<?php if ($this->Absensi_model->cek_absen_pulang_now()==0) { ?>
	<a href="<?php echo site_url('siswa/home/pulang');?>">
		<div class="d-grid gap-2 col-lg-6 mx-auto">
			<button type="button" class="btn btn-primary">
				<span class="tf-icons bx bx-pie-chart-alt"></span>&nbsp; Absen Pulang
			</button>
		</div>
	</a>
	<?php } } ?>
</div>
<div class="d-grid gap-2 col-lg-6 mx-auto">
	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal" style="margin-top: 10px;">
		<span class="tf-icons bx bx-search"></span>&nbsp; Lihat Presensiku
	</button>
</div>
<div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel1"><span class="tf-icons bx bx-search"></span>&nbsp; Lihat
					Presensiku</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form class="modal-content" method="GET" action="<?php echo site_url('siswa/home/lihat');?>">
				<div class="modal-body">
					<div class="row g-2">
						<div class="col mb-0">
							<label for="emailBasic" class="form-label">Pilih Bulan</label>
							<input type="date" class="form-control" name="bulan" placeholder="Pilih bulan..."
								required>
						</div>
					</div> 
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Lihat Data Absen</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="row mb-3 mt-3">
  <?php if($data3<>NULL){ ?>
  <div class="col-md-12">
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
  <div class="col-md-12">
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
  <div class="col-md-12">
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
            </tr>
            <?php $no++;} ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php } ?>
</div>
<div class="col-md">
	<div id="accordionIcon" class="accordion mt-3 accordion-without-arrow">
		<div class="accordion-item card active">
			<h2 class="accordion-header text-body d-flex justify-content-between" id="accordionIconOne">
				<button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionIcon-1"
					aria-controls="accordionIcon-1" aria-expanded="true">
					Visi dan Misi SMKN 2 Karanganyar
				</button>
			</h2>
			<div id="accordionIcon-1" class="accordion-collapse collapse show" data-bs-parent="#accordionIcon" style="">
				<div class="accordion-body">
					<dl class="dl-horizontal">
						<dt>Visi</dt>
						<dd>Berkarakter, Berprestasi dan Berbudaya Lingkungan.</dd>
						<dt>Misi</dt>
						<dd>1. Menanamkan Keimanan dan Ketakwaan kepada Tuhan Yang Maha Esa</dd>
						<dd>2. Menyelenggarakan Pendidikan dan Pelatihan yang Berkualitas dan Berbudaya Lingkungan</dd>
					</dl>
				</div>
			</div>
		</div>
		<div class="accordion-item card">
			<h2 class="accordion-header text-body d-flex justify-content-between" id="accordionIconTwo">
				<button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
					data-bs-target="#accordionIcon-2" aria-controls="accordionIcon-2" aria-expanded="false">
					Lirik Mars SMKN 2 Karanganyar
				</button>
			</h2>
			<div id="accordionIcon-2" class="accordion-collapse collapse" data-bs-parent="#accordionIcon" style="">
				<div class="accordion-body">
					Kami adalah pelajar SMK <br>
					Yang siap kerja dan santun<br>
					mandiri serta kreatif.<br>
					Unggul didalam prestasi,<br>
					dan inovasi.<br>
					Berkarakter budi pekerti,<br>
					berbakti pada negeri.<br><br>

					SMK Bisa! SMK Hebat!<br>
					Santun, cermat, juga bersemangat.<br>
					Terampil serta siap bekerja<br>
					SMK Bisa Hebat!<br>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$("#datepicker").datepicker({
		format: "mm-yyyy",
		startView: "months",
		minViewMode: "months"
	});

</script>
<script>
	const lokasi_benar = document.getElementById('lokasi_benar');
	const lokasi_salah = document.getElementById('lokasi_salah');
	const lokasi_null = document.getElementById('lokasi_null');
	lokasi_benar.style.display = "none";
	lokasi_salah.style.display = "none";
	lokasi_null.style.display = "none";
	const utara = -7.589;
	const selatan = -7.591;
	const barat = 110.9495;
	const timur = 110.9516;
	const successCallback = (position) => {
		const latitude = position.coords.latitude;
		const longitude = position.coords.longitude;
		// const latitude = -7.59017784732292;
		// const longitude = 110.95072346694563;
		console.log(latitude);
		console.log(longitude);
		if ((latitude <= utara) && (latitude >= selatan) && (longitude >= barat) && (latitude <= timur)) {
			console.log('Lokasi benar');
			lokasi_benar.style.display = "block";
			lokasi_salah.style.display = "none";
			lokasi_null.style.display = "none";
		} else {
			console.log('Lokasi Salah');
			lokasi_benar.style.display = "none";
			lokasi_salah.style.display = "block";
			lokasi_null.style.display = "none";
		}
	};
	const errorCallback = (error) => {
		console.log('Lokasi tidak aktif');
		lokasi_benar.style.display = "none";
		lokasi_salah.style.display = "none";
		lokasi_null.style.display = "block";
	};
	navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
</script>
