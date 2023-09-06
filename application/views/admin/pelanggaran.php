<div id="ngilang">
    <?= $this->session->flashdata('alert') ?>
</div>
<div class="col-lg-12 col-md-12">
    <div class="mt-1 mb-3">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter">
            Tambah Jenis Pelanggaran
        </button>
        <!-- Modal -->
        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <form action="<?= base_url('admin/pelanggaran/simpan') ?>" method="post">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCenterTitle">Tambah Jenis Pelanggaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label">Nama Pelanggaran</label>
                                    <input type="text" class="form-control" placeholder="Nama Pelanggaran"
                                        name="pelanggaran" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label">Poin</label>
                                    <input type="number" class="form-control" placeholder="Poin Pelanggaran"
                                        name="poin" required />
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
    <h5 class="card-header">Daftar Jenis Pelanggaran</h5>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pelanggaran</th>
                    <th>Poin</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                <?php $no=1; foreach($data2 as $aa) { ?>
                <tr>
                    <td><?= $no; ?></td>
                    <td><?= $aa['pelanggaran'] ?></td>
                    <td><?= $aa['poin'] ?></td>
                    <td>
                        <a href="<?php echo site_url('admin/pelanggaran/delete_data/'.$aa['id_daftar_pelanggaran']);?>"
                            class="btn btn-sm btn-danger"
                            onClick="return confirm('Apakah anda yakin menghapus data ini?')"><span
                                class="tf-icons bx bx-trash-alt"></span></a>
                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                            data-bs-target="#edit<?= $aa['id_daftar_pelanggaran'] ?>">
                            <span class="tf-icons bx bx-edit"></span>
                        </button>
                        <div class="modal fade" id="edit<?= $aa['id_daftar_pelanggaran'] ?>" tabindex="-1"
                            aria-hidden="true">
                            <div class="modal-dialog modal-md" role="document">
                                <form action="<?= base_url('admin/pelanggaran/update') ?>" method="post">
                                    <input type="hidden" name="id_daftar_pelanggaran"
                                        value="<?= $aa['id_daftar_pelanggaran'] ?>">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalCenterTitle">Perbarui Pelanggaran</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                        <div class="row">
                                                <div class="col mb-3">
                                                    <label class="form-label">Nama Pelanggaran</label>
                                                    <input type="text" class="form-control"
                                                        value="<?= $aa['pelanggaran'] ?>" name="pelanggaran" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                    <label class="form-label">Poin</label>
                                                    <input type="number" class="form-control"
                                                        value="<?= $aa['poin'] ?>" name="poin" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">
                                                Close
                                            </button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php $no++; } ?>
            </tbody>
        </table>
    </div>
</div>