<form action="<?= site_url('/admin/pengemasan-stok'); ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field(); ?>

    <div class="form-group">
        <label for="produk_gudang_id">Produk Gudang</label>
        <select class="form-control" id="produk_gudang_id" name="produk_gudang_id" required>
            <option value="">-- Pilih Produk Gudang --</option>
            <?php foreach ($produkGudang as $item): ?>
                <option value="<?= $item['id'] ?>"><?= $item['nama'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <select class="form-control" id="toko_id" name="toko_id" required>
            <option value="">-- Pilih Tujuan Toko --</option>
            <?php foreach ($toko as $t): ?>
                <option value="<?= $t['id'] ?>"><?= $t['nama'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="stok">Stok</label>
        <input type="text" class="form-control" id="stok" name="stok" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>