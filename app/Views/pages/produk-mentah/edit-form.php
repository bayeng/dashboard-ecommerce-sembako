<form action="<?= site_url('produk-mentah/update/' . $kategori['id']); ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field(); ?>

    <input type="hidden" name="_method" value="PUT">

    <div class="form-group">
        <label for="nama">Nama Produk</label>
        <input type="text" class="form-control" id="nama" name="nama" value="<?= $kategori['nama'] ?>" required>
    </div>

    <div class="form-group">
        <label for="supplier_id">Supplier</label>
        <select class="form-control" id="supplier_id" name="supplier_id" required>
            <option value="<?= $kategori['supplier_id'] ?>"><?= $kategori['nama_supplier'] ?></option>
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
            <label for="kuantiti">Kuantiti</label>
            <input type="text" class="form-control" id="kuantiti" name="kuantiti" value="<?= $kategori['kuantiti'] ?>" required>
        </div>

        <div class="form-group col-md-6">
            <label for="satuan_kuantiti">Satuan Kuantiti</label>
            <input type="text" class="form-control" id="satuan_kuantiti" name="satuan_kuantiti" value="<?= $kategori['satuan_kuantiti'] ?>" required>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>