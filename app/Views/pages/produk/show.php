<form action="<?= site_url('produk/store'); ?>" method="POST">
    <?= csrf_field(); ?>

    <div class="form-group">
        <label for="nama">Nama Produk</label>
        <input type="text" class="form-control" id="nama" name="nama" value="<?= esc($produk['nama']) ?>" disabled required>
    </div>
    
    <div class="form-group">
        <label for="kode">Kode</label>
        <input type="text" class="form-control" id="kode" name="kode" value="<?= esc($produk['kode']) ?>" disabled required>
    </div>

    <div class="form-group">
        <label for="harga">Harga</label>
        <input type="number" class="form-control" id="harga" name="harga" value="<?= esc($produk['harga']) ?>" disabled required>
    </div>
    
    <div class="form-group">
        <label for="stok">Stok</label>
        <input type="number" class="form-control" id="stok" name="stok" value="<?= esc($produk['stok']) ?>" disabled required>
    </div>
    
    <div class="form-group">
        <label for="deskripsi">Deskripsi</label>
        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" disabled required><?= esc($produk['deskripsi']) ?></textarea>
    </div>

    <div class="form-group">
        <label for="kategori">Kategori</label>
        <select class="form-control" id="kategori" name="kategori_id" disabled required>
            <option value="">Pilih Kategori</option>
            <?php foreach ($kategoris as $kategori): ?>
                <option value="<?= $kategori['id']; ?>" <?= $kategori['id'] ? 'selected' : '' ?> ><?= $kategori['nama']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="foto" class="form-label">Foto</label>
        <?php if (!empty($produk['foto'])): ?>
            <div class="mb-2">
                <img src="<?= base_url('uploads/produk/' . $produk['foto']) ?>" alt="Foto Produk" width="100">
            </div>
        <?php endif; ?>
        <input type="file" class="form-control" id="foto" name="foto" value="<?= base_url('/uploads/produk/' . $produk['nama']) ?>" disabled required>
    </div>

    <!-- <button type="submit" class="btn btn-primary">Simpan</button> -->
</form>