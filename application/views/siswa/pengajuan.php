<div id="ngilang">
    <?= $this->session->flashdata('alert') ?>
</div>
<div class="col-lg-12 col-md-12">
    <div class="mt-1 mb-3">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter">
            Form Pengajuan Ijazah, Raport, Legalisir
        </button>
        <!-- Modal -->
        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form action="<?= base_url('siswa/pengajuan/simpan') ?>" method="post">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCenterTitle">Form Pengajuan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label">Tuliskan Keperluan Anda! (Seperti pengambilan ijazah,
                                        legalisir, dll)</label>
                                    <textarea name="keperluan" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label">Tanggal Rencana Keperluan</label>
                                    <input type="date" class="form-control" name="tanggal_keperluan" required />
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<div class="card">
    <h5 class="card-header">Daftar Pengajuan</h5>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Keperluan</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                <?php $no=1; foreach($data2 as $aa) { ?>
                <tr>
                    <td><?= $no; ?></td>
                    <td><?= $aa['keperluan'] ?></td>
                    <td><?= mediumdate_indo($aa['tanggal_keperluan']); ?></td>
                    <td><?php if($aa['status']==0){ echo "Dalam proses"; } else { echo "Selesai"; } ?></td>
                    <td>
                        <a href="<?php echo site_url('siswa/pengajuan/delete_data/'.$aa['id_pengajuan']);?>"
                            class="btn btn-sm btn-danger"
                            onClick="return confirm('Apakah anda yakin membatalkan pengajuan ini?')"><span
                                class="tf-icons bx bx-trash-alt"></span></a>
                    </td>
                </tr>
                <?php $no++; } ?>
            </tbody>
        </table>
    </div>
</div>