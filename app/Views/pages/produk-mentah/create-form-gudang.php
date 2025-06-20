<form action="<?= site_url('/admin/produk-gudang/store'); ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field(); ?>
    <input type="hidden" name="status" value="2">
    <input type="hidden" name="produk_gudang_id" value="<?= $produkMentah['id'] ?>">

    <div class="form-group">
        <label for="nama">Nama Produk</label>
        <input type="text" class="form-control" id="nama" name="nama" required>
    </div>

    <div class="form-group">
        <label for="kode">Kode Produk</label>
        <input type="text" class="form-control" id="kode" name="kode" required>
    </div>

    <div class="form-group">
        <label for="kategori_id">Kategori Produk</label>
        <select class="form-control" id="kategori_id" name="kategori_id" required>
            <option value="">-- Kategori Produk --</option>
            <?php foreach ($kategori as $item): ?>
                <option value="<?= $item['id'] ?>"><?= $item['nama'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="supplier_id">Supplier</label>
        <select class="form-control" id="supplier_id" name="supplier_id">
            <option value="">-- Pilih Supplier --</option>
            <?php foreach ($supplier as $s): ?>
                <option value="<?= $s['id'] ?>"><?= $s['nama'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="harga">Harga</label>
        <input type="text" class="form-control" id="harga" name="harga" required>
    </div>

    <div class="form-group">
        <label for="foto">Foto</label>
        <input type="file" class="form-control" id="foto" name="foto" required>
    </div>

    <div class="form-group">
        <label for="tanggal_masuk">Tanggal Masuk</label>
        <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" required>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="stok">Stok</label>
            <input type="text" class="form-control" id="stok" name="stok" required>
        </div>

        <div class="form-group col-md-6">
            <label for="satuan_stok">Satuan Stok</label>
            <input type="text" class="form-control" id="satuan_stok" name="satuan_stok" required>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>