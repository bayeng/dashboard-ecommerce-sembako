<form action="<?= site_url('toko/store'); ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field(); ?>

    <div class="form-group">
        <label for="nama">Nama Toko</label>
        <input type="text" class="form-control" id="nama" name="nama" required>
    </div>
    
    <div class="form-group">
        <label for="address">Alamat</label>
        <textarea class="form-control" id="address" name="alamat" rows="3" required></textarea>
    </div>

    <div class="form-group">
        <label for="foto" class="form-label">Foto</label>
        <input type="file" class="form-control" id="foto" name="foto"  required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>