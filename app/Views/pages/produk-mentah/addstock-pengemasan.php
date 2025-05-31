<form action="<?= site_url('/admin/produk-mentah/pengemasan-produk/tambah-stok'); ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field(); ?>

    <input type="text" hidden="hidden" name="produk_packing_id" value="<?= $item['id'] ?>">
    <input type="text" hidden="hidden" name="produk_mentah_id" value="<?= $item['produk_mentah_id'] ?>">

    <div class="form-group">
        <label for="stok">Tambah Stok</label>
        <input type="text" class="form-control" id="stok" name="stok" required>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>