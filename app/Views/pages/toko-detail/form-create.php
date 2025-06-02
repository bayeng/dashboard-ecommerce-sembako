<form action="<?= site_url('/admin/detail-toko/store'); ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field(); ?>
    <input type="hidden" value="<?= $toko['id']; ?>" name="toko_id">

    <div class="form-group">
        <label for="kategori">Produk</label>
        <select class="form-control" id="kategori" name="produk_gudang_id" required>
            <option value="">Pilih Produk</option>
            <?php foreach ($produkGudang as $produk): ?>
                <option value="<?= $produk['id']; ?>"><?= $produk['nama']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="stok">Stok</label>
        <input type="text" class="form-control" id="stok" name="stok" value="" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>