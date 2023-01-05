<?php
    $pisah=explode("-",$bulan);
    $tahun = $pisah[0];
    $month = $pisah[1];
    $this->db->select('LAST_DAY("'.$bulan.'") as tanggal');
    $end= $this->db->get()->row()->tanggal;
    $pisah=explode("-",$end);
    $date_end = $pisah[2];
?>
<table border="1">
    <tr>
        <th>No</th>
        <th>NIS</th>
        <th>Nama</th>
        <?php for ($i=1; $i<=$date_end ; $i++) {  ?>
        <th><?= $i; ?></th>
        <?php } ?>
    </tr>
    <?php $no = 1;  foreach ($data2 as $user) {?>
    <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $user['username']; ?></td>
        <td><?php echo $user['nama']; ?></td>
        <?php for ($i=1; $i<=$date_end ; $i++) { if($i>9){ $tanggal=$tahun.'-'.$month.'-'.$i; } else { $tanggal=$tahun.'-'.$month.'-'.'0'.$i; }  ?>
        <td><?php echo $this->Absensi_model->get_masuk($user['username'],$tanggal); ?></td>
        <?php } ?>
    </tr>
    <?php $no++; } ?>
</table>