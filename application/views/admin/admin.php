<div id="myalert">
    <?php echo $this->session->flashdata('alert', true); $this->session->set_flashdata('alert', '');?>
</div>
<div class="row mb-3">
    <div class="col-md-12">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal"
            style="margin-top: 10px;">
            <span class="tf-icons bx bx-user"></span>&nbsp; Tambah Admin
        </button>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal"
            style="margin-top: 10px;">
            <span class="tf-icons bx bx-upload"></span>&nbsp; Import Data
        </button>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <hr class="my-0">
            <div class="card-body">
                <table class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Level</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($data2 as $user) {?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['nama']; ?></td>
                            <td><?php echo $user['level']; ?></td>
                            <td align="center">
                                <a href="<?php echo site_url('admin/admin/delete_data/'.$user['id']);?>"
                                    class="btn btn-sm btn-danger"
                                    onClick="return confirm('Apakah anda yakin menghapus data ini?')"><span
                                        class="tf-icons bx bx-trash-alt"></span></a>
                                <a href="<?php echo site_url('admin/admin/reset/'.$user['id']);?>"
                                    class="btn btn-sm btn-primary"
                                    onClick="return confirm('Apakah anda yakin mereset password pada siswa?')"><span
                                        class="tf-icons bx bx-lock"></span></a>
                            </td>
                        </tr>
                        <?php $no++; } ?>
                    </tbody>
                </table>
            </div>
            <!-- /Account -->
        </div>
    </div>
</div>

<!-- Modal for Tambah Admin -->
<div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><span class="tf-icons bx bx-user"></span>&nbsp;Tambah Admin</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="<?php echo site_url('admin/admin/simpan');?>">
        <div class="modal-body">
          <div class="row g-2">
            <div class="col mb-0">
              <label class="form-label">Username</label>
              <input type="text" class="form-control" name="username" required>
            </div>
          </div>
          <div class="row g-2">
            <div class="col mb-0">
              <label class="form-label">Nama</label>
              <input type="text" class="form-control" name="nama" required>
            </div>
          </div>
          <div class="row g-2">
            <div class="col mb-0">
              <label class="form-label">Password</label>
              <input type="password" class="form-control" name="password" required>
            </div>
          </div>
          <div class="row g-2">
            <div class="col mb-0">
              <label class="form-label">Level</label>
              <select name="level" class="form-control">
                <option value="Kesiswaan">Kesiswaan</option>
                <option value="BK">BK</option>
                <option value="Guru">Guru</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><span class="tf-icons bx bx-upload"></span>&nbsp;Import Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row g-2">
          <div class="col mb-0">
            <label class="form-label">Pilih File Excel</label>
            <input type="file" class="form-control" id="file_excel" accept=".xls,.xlsx" required>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="uploadExcel()">Import</button>
      </div>
    </div>
  </div>
</div>


<script>
    function confirmDialog() {
        return confirm('Apakah anda yakin akan menghapus data ini?')
    }
</script>
<script>
  function uploadExcel() {
    const fileInput = document.getElementById('file_excel');
    const file = fileInput.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, { type: 'array' });

            // Assuming the data is on the first sheet
            const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
            const excelRows = XLSX.utils.sheet_to_json(firstSheet, { header: 1 });

            const parsedData = [];

            // Loop through rows
            excelRows.forEach((row, index) => {
                if (index === 0) return; // Skip the header row
                parsedData.push({
                    username: row[0],
                    password: row[1],
                    level: row[2],
                    nama: row[3],
                    kelas: row[4],
                    tahun_masuk: row[5]
                });
            });

            // Send data to the server using AJAX
            $.ajax({
                url: '<?php echo site_url('admin/admin/import_data'); ?>',
                method: 'POST',
                data: { data: JSON.stringify(parsedData) },
                success: function(response) {
                    alert('Data berhasil diimport!');
                    location.reload(); // Reload the page after successful import
                },
                error: function() {
                    alert('Gagal mengimport data.');
                }
            });
        };

        reader.readAsArrayBuffer(file);
    } else {
        alert('Harap pilih file Excel!');
    }
}
</script>