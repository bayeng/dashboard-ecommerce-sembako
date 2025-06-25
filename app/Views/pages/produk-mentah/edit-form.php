<form action="<?= site_url('/admin/produk-mentah/update/' . $kategori['id']); ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field(); ?>

    <input type="hidden" name="_method" value="PUT">

    <div class="form-group">
        <label for="nama">Nama Produk</label>
        <input type="text" class="form-control" id="nama" name="nama" value="<?= $kategori['nama'] ?>" required>
    </div>

    <div class="form-group">
        <label for="supplier_id">Supplier</label>
        <select class="form-control" id="supplier_id" name="supplier_id" required>
            <option value="<?= $kategori['id_supplier'] ?>"><?= $kategori['nama_supplier'] ?></option>
            <?php foreach ($supplier as $item): ?>
                <option value="<?= $item['id'] ?>"><?= $item['nama'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="harga">Harga</label>
        <input type="text" class="form-control" id="harga" name="harga" value="<?= $kategori['harga'] ?>" required>
    </div>

    <div class="form-group">
        <label for="foto">Foto</label>
        <?php if (!empty($kategori['foto'])): ?>
            <div class="mb-2">
                <img src="<?= base_url('uploads/produk-mentah/' . $kategori['foto']) ?>" alt="Foto Produk" width="100">
            </div>
        <?php endif; ?>
        <input type="file" class="form-control" id="foto" name="foto">
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="stok">Kuantiti</label>
            <input type="text" class="form-control" id="stok" name="stok" value="<?= $kategori['stok'] ?>" required>
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