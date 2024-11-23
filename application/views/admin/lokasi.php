<div class="card">
    <div class="card-header">
        <h5>Edit Lokasi Presensi</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('admin/lokasi/update') ?>" method="post">
            <div class="form-group">
                <label for="latitude">Latitude</label>
                <input type="text" class="form-control" id="latitude" name="latitude" 
                       value="<?= isset($site['latitude']) ? $site['latitude'] : '' ?>" required>
            </div>
            <div class="form-group">
                <label for="longitude">Longitude</label>
                <input type="text" class="form-control" id="longitude" name="longitude" 
                       value="<?= isset($site['longtitude']) ? $site['longtitude'] : '' ?>" required>
            </div>
            <div class="form-group">
                <label for="jangkauan">Jangkauan (dalam meter)</label>
                <input type="number" class="form-control" id="jangkauan" name="jangkauan" 
                       value="<?= isset($site['jangkauan']) ? $site['jangkauan'] : '' ?>" required>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
