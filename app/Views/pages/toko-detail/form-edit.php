<form action="<?= site_url('/admin/detail-toko/update/' . $toko['id']); ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field(); ?>
    <input type="hidden" name="_method" value="PUT">

    <input type="hidden" value="<?= $toko['id']; ?>" name="toko_id">

    <div class="form-group">
        <label for="stok">Kuantiti</label>
        <input type="text" class="form-control" id="stok" name="stok" value="<?= $toko['stok']; ?>" required>
    </div>

    <div class="form-group">
        <label for="harga">Harga</label>
        <input type="text" class="form-control" id="harga" name="harga" value="<?= $toko['harga']; ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>