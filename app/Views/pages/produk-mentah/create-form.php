<form action="<?= site_url('produk-mentah/store'); ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field(); ?>

    <div class="form-group">
        <label for="nama">Nama Produk</label>
        <input type="text" class="form-control" id="nama" name="nama" required>
    </div>

    <div class="form-group">
        <label for="supplier_id">Supplier</label>
        <select class="form-control" id="supplier_id" name="supplier_id" required>
            <option value="">-- Pilih Supplier --</option>
            <?php foreach ($supplier as $item): ?>
                <option value="<?= $item['id'] ?>"><?= $item['nama'] ?></option>
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

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="kuantiti">Kuantiti</label>
            <input type="text" class="form-control" id="kuantiti" name="kuantiti" required>
        </div>

        <div class="form-group col-md-6">
            <label for="satuan_kuantiti">Satuan Kuantiti</label>
            <input type="text" class="form-control" id="satuan_kuantiti" name="satuan_kuantiti" required>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>