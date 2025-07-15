<form action="<?= site_url('/admin/produk-gudang/update/' . $item['id']); ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field(); ?>

    <input type="hidden" name="_method" value="PUT">

    <div class="form-group">
        <label for="nama">Nama Produk</label>
        <input type="text" class="form-control" id="nama" name="nama" value="<?= $item['nama'] ?>" required>
    </div>
    <div class="form-group">
        <label for="kode">Kode</label>
        <input type="text" class="form-control" id="kode" name="kode" value="<?= $item['kode'] ?>" required>
    </div>

    <div class="form-group">
        <label for="kategori_id">Supplier</label>
        <select class="form-control" id="kategori_id" name="kategori_id" required>
            <option value="<?= $item['id_kategori'] ?>"><?= $item['nama_kategori'] ?></option>
            <?php foreach ($kategori as $k): ?>
                <option value="<?= $k['id'] ?>"><?= $k['nama'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="harga">Harga</label>
        <input type="text" class="form-control" id="harga" name="harga" value="<?= $item['harga'] ?>" required>
    </div>

    <div class="form-group">
        <label for="foto">Foto</label>
        <?php if (!empty($item['foto'])): ?>
            <div class="mb-2">
                <img src="<?= base_url('uploads/produk-gudang/' . $item['foto']) ?>" alt="Foto Produk" width="100">
            </div>
        <?php endif; ?>
        <input type="file" class="form-control" id="foto" name="foto">
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="stok">Stok</label>
            <input type="text" class="form-control" id="stok" name="stok" value="<?= $item['stok'] ?>" required>
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