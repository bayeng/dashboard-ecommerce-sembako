<form action="<?= site_url('produk-mentah/update/' . $item['id']); ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field(); ?>

    <input type="hidden" name="_method" value="PUT">

    <div class="form-group">
        <label for="nama">Nama Produk</label>
        <input type="text" class="form-control" id="nama" name="nama" value="<?= $item['nama'] ?>" disabled required>
    </div>

    <div class="form-group">
        <label for="kode">Kode Produk</label>
        <input type="text" class="form-control" id="kode" name="kode" value="<?= $item['kode'] ?>" disabled required>
    </div>

    <div class="form-group">
        <label for="kategori_id">Kategori</label>
        <select class="form-control" id="kategori_id" name="kategori_id" disabled required>
            <option value="<?= $item['id_kategori'] ?>"><?= $item['nama_kategori'] ?></option>
            <?php foreach ($kategori as $k): ?>
                <option value="<?= $k['id'] ?>"><?= $k['nama'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="harga">Harga</label>
        <input type="text" class="form-control" id="harga" name="harga" value="<?= $item['harga'] ?>" disabled required>
    </div>

    <div class="form-group">
        <label for="foto">Foto</label>
        <?php if (!empty($item['foto'])): ?>
            <div class="mb-2">
                <img src="<?= base_url('uploads/produk-gudang/' . $item['foto']) ?>" alt="Foto Produk" width="100">
            </div>
        <?php endif; ?>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="stok">Stok</label>
            <input type="text" class="form-control" id="stok" name="stok" value="<?= $item['stok'] ?>" disabled required>
        </div>

        <div class="form-group col-md-6">
            <label for="satuan_stok">Satuan Stok</label>
            <input type="text" class="form-control" id="satuan_stok" name="satuan_stok" value="<?= $item['satuan_stok'] ?>" disabled required>
        </div>
    </div>

</form>