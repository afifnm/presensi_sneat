<div id="ngilang">
    <?= $this->session->flashdata('alert') ?>
</div>
<div class="card">
    <h5 class="card-header">Rekap Prestasi Semua Siswa</h5>
    <div class="table-responsive text-nowrap">
        <table class="table table-striped" id="example">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Nama Lomba</th>
                    <th>Juara Ke-</th>
                    <th>Keterangan</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                <?php $no=1; foreach($prestasi as $aa) { ?>
                <tr>
                    <td><?= $no; ?></td>
                    <td><?= $aa['username'] ?></td>
                    <td><?= $aa['nama_siswa'] ?></td>
                    <td><?= $this->Absensi_model->cek_kelas($aa['tahun_masuk']).' '.$aa['kelas']; ?></td>
                    <td><?= $aa['nama'] ?></td>
                    <td><?= $aa['juara'] ?></td>
                    <td><?= $aa['keterangan'] ?></td>
                    <td><?= date_indo($aa['tanggal']) ?></td>
                    <td>
                        <a href="<?php echo site_url('admin/siswa/profil/'.$aa['username']);?>"
                            class="btn btn-sm btn-danger"><span
                                class="tf-icons bx bx-search"></span></a>
                    </td>
                </tr>
                <?php $no++; } ?>
            </tbody>
        </table>
    </div>
</div>