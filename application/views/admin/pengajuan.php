<div id="ngilang">
    <?= $this->session->flashdata('alert') ?>
</div>
<div class="card">
    <h5 class="card-header">Rekap Data Tracking</h5>
    <div class="table-responsive text-nowrap">
        <table class="table table-striped" id="example">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Keperluan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                <?php
                $no=1; foreach($data2 as $aa) {
                ?>
                <tr>
                    <td><?= $no; ?></td>
                    <td><?= $aa['username'] ?></td>
                    <td><?= $aa['nama'] ?></td>
                    <td><?= $this->Absensi_model->cek_kelas($aa['tahun_masuk']).' '.$aa['kelas']; ?></td>
                    <td><?php if($aa['status']==0){ echo "Dalam proses"; } else { echo "Selesai"; } ?></td>
                    <td><?= $aa['keperluan'] ?></td>
                    <td><?= mediumdate_indo($aa['tanggal_keperluan']) ?></td>
                    <td>
                        <a href="<?php echo site_url('admin/siswa/profil/'.$aa['username']);?>"
                            class="btn btn-sm btn-info"><span class="tf-icons bx bx-search"></span></a>
                        <a href="<?php echo site_url('admin/pengajuan/delete_data/'.$aa['id_pengajuan']);?>"
                            class="btn btn-sm btn-danger"
                            onClick="return confirm('Apakah anda yakin membatalkan pengajuan ini?')"><span
                                class="tf-icons bx bx-trash-alt"></span></a>
                        <?php if($aa['status']==0) { ?>
                        <a href="<?php echo site_url('admin/pengajuan/edit/'.$aa['id_pengajuan']);?>"
                            class="btn btn-sm btn-success"
                            onClick="return confirm('Apakah anda yakin telah menyelesaikan pengajuan ini?')"><span
                                class="tf-icons bx bx-check"></span></a>
                        <?php } ?>
                    </td>
                </tr>
                <?php $no++; } ?>
            </tbody>
        </table>
    </div>
</div>