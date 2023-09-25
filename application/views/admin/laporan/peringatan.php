<div id="ngilang">
    <?= $this->session->flashdata('alert') ?>
</div>
<div class="card">
    <h5 class="card-header">Rekap Poin Pelanggaran</h5>
    <div class="table-responsive text-nowrap">
        <table class="table table-striped" id="example">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Total Poin</th>
                    <th>Tindakan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                <?php
                $no=1; foreach($pelanggaran as $aa) {
                $poin = $this->Absensi_model->total_poin($aa['username']);
                if($poin>=30){
                ?>
                <tr>
                    <td><?= $no; ?></td>
                    <td><?= $aa['username'] ?></td>
                    <td><?= $aa['nama'] ?></td>
                    <td><?= $this->Absensi_model->cek_kelas($aa['tahun_masuk']).' '.$aa['kelas']; ?></td>
                    <td><?= $poin; ?></td>
                    <td>
                        <?php
                        if(($poin>=30) AND ($poin<50)) {
                            echo "Peringatan tertulis dan teguran oleh wali kelas / Guru BK";
                        } else if(($poin>=50) AND ($poin<90)) {
                            echo "Pembinaan (I) pernyataan tertulis (1) panggilan Orangtua (1)";
                        } else if(($poin>=90) AND ($poin<130)) {
                            echo "Pembinaan (II) pernyataan tertulis (2) panggilan Orangtua (2)";
                        } else if(($poin>=130) AND ($poin<150)) {
                            echo "Pembinaan (III) pernyataan tertulis (3) pemanggilan Orangtua (3) diketahui oleh Wali kelas, Guru BK, Waka Kesiswaan";
                        } else if($poin>=150) {
                            echo "Dikembalikan kepada orang tua/wali siswa (dikeluarkan tidak hormat)";
                        } 
                        ?>
                    </td>
                    <td>
                        <a href="<?php echo site_url('admin/siswa/profil/'.$aa['username']);?>"
                            class="btn btn-sm btn-danger"><span
                                class="tf-icons bx bx-search"></span></a>
                    </td>
                </tr>
                <?php $no++; }} ?>
            </tbody>
        </table>
    </div>
</div>