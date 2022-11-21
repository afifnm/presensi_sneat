<h3 align="center"> Rekap Presensi
<?php echo date_indo($tanggal); $no = 1;?>
</h3>
<table border="1" >
	<tr>
		<td>No.</td>
		<td>NIS</td>
		<td>Nama</td>
		<td>Masuk</td>
		<td>Pulang</td>
		<td>Keterangan</td>
	</tr>
<?php	foreach ($data4 as $u) { ?>
	<tr>
		<td><?php echo $no; ?></td>
		<td><?php echo $u['username']; ?></td>
		<td><?php echo $u['nama']; ?></td>
		<td><?php echo $this->Absensi_model->get_masuk($u['username'],$tanggal); ?></td>
		<td><?php echo $this->Absensi_model->get_pulang($u['username'],$tanggal); ?></td>	
		<td> </td>		
	</tr>
<?php $no++; } ?>

</table>