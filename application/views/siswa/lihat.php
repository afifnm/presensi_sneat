<?php
    $pisah=explode("-",$bulan);
    $tahun = $pisah[0];
    $month = $pisah[1];
    $this->db->select('LAST_DAY("'.$bulan.'") as tanggal');
    $end= $this->db->get()->row()->tanggal;
    $pisah=explode("-",$end);
    $date_end = $pisah[2];
?>
<div class="card">
	<div class="table-responsive text-nowrap">
		<table class="table">
			<thead>
				<tr> no
					<th>Tanggal</th>
					<th>Masuk</th>
					<th>Pulang</th>
				</tr>
			</thead>
			<tbody>
                <?php for ($i=1; $i<=$date_end ; $i++) { $tanggal=$tahun.'-'.$month.'-'.$i; ?>
				<tr>
					<td><?= $i.'-'.$month.'-'.$tahun; ?></td>
					<td><?php echo $this->Absensi_model->get_masuk($this->session->userdata('username'),$tanggal); ?></td>
					<td><?php echo $this->Absensi_model->get_pulang($this->session->userdata('username'),$tanggal); ?></td>
				</tr>
                <?php } ?>
			</tbody>
		</table>
	</div>
</div>
