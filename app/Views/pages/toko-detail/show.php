<form action="<?= site_url('toko/update/' . $toko['id']); ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field(); ?>

    <div class="form-group">
        <label for="nama">Nama Toko</label>
        <input type="text" class="form-control" id="nama" name="nama" value="<?= $toko['nama'] ?>" disabled>
    </div>
    
    <div class="form-group">
        <label for="address">Alamat</label>
        <textarea class="form-control" id="address" name="alamat" rows="3" disabled><?= esc($toko['alamat']) ?></textarea>
    </div>

    <div class="form-group">
        <label for="foto" class="form-label">Foto</label>
        <input type="file" class="form-control" id="foto" name="foto" value="<?= base_url('uploads/toko/' . $toko['foto']) ?>" disabled>
    </div>
</form>