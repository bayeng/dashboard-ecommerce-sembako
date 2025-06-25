<form action="<?= site_url('/admin/produk-mentah/pengemasan-produk'); ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field(); ?>

    <input type="text" hidden="hidden" name="produk_mentah_id" value="<?= $produkMentah['id'] ?>">
    <div class="form-group">
        <label for="produk_gudang_id">Produk Mentah</label>
        <select class="form-control" id="produk_gudang_id" name="produk_gudang_id" required>
            <option value="">-- Pilih Produk Gudang --</option>
            <?php foreach ($produkGudang as $item): ?>
                <option value="<?= $item['id'] ?>"><?= $item['nama'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>


    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="stok">Stok</label>
            <input type="text" class="form-control" id="stok" name="stok" required>
        </div>

        <div class="form-group">
            <label for="satuan_stok">Satuan Stok</label>
            <select class="form-control" id="satuan_stok" name="satuan_stok">
                <option value="">-- Pilih Satuan --</option>
                <?php foreach ($satuanStok as $ss): ?>
                    <option value="<?= $ss['nama'] ?>"><?= $ss['nama'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>