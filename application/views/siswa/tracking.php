<div id="ngilang">
    <?= $this->session->flashdata('alert') ?>
</div>
<div class="col-lg-12 col-md-12">
    <div class="mt-1 mb-3">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter">
            Tambah Karir (Bekerja/Kuliah)
        </button>
        <!-- Modal -->
        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form action="<?= base_url('siswa/tracking/simpan') ?>" method="post">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCenterTitle">Form Tracking</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col mb-3">
                                    <select name="karir" class="form-control">
                                        <option value="Kuliah">Kuliah</option>
                                        <option value="Bekerja">Bekerja</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label">Tuliskan Dimana tempat Bekerja atau Kuliah</label>
                                    <input type="text" class="form-control" name="keterangan" required />
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
    <h5 class="card-header">Data Karir</h5>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Karir</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                <?php $no=1; foreach($data2 as $aa) { ?>
                <tr>
                    <td><?= $no; ?></td>
                    <td><?= $aa['karir'] ?></td>
                    <td><?= $aa['keterangan'] ?></td>
                    <td>
                        <a href="<?php echo site_url('siswa/tracking/delete_data/'.$aa['id_tracking']);?>"
                            class="btn btn-sm btn-danger"
                            onClick="return confirm('Apakah anda yakin membatalkan tracking ini?')"><span
                                class="tf-icons bx bx-trash-alt"></span></a>
                    </td>
                </tr>
                <?php $no++; } ?>
            </tbody>
        </table>
    </div>
</div>