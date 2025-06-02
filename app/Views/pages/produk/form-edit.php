<form action="<?= site_url('/toko/produk/update/' . $produk['id']); ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field(); ?>
    <input type="hidden" name="_method" value="PUT">

    <div class="form-group">
        <label for="nama">Nama Produk</label>
        <input type="text" class="form-control" id="nama" name="nama" value="<?= esc($produk['nama']) ?>" required>
    </div>
    
    <div class="form-group">
        <label for="kode">Kode</label>
        <input type="text" class="form-control" id="kode" name="kode" value="<?= esc($produk['kode']) ?>" disabled required>
    </div>

    <div class="form-group">
        <label for="harga">Harga</label>
        <input type="number" class="form-control" id="harga" name="harga" value="<?= esc($produk['harga']) ?>" required>
    </div>
    
    <div class="form-group">
        <label for="stok">Stok</label>
        <input type="number" class="form-control" id="stok" name="stok" value="<?= esc($produk['stok']) ?>" required>
    </div>
    
    <div class="form-group">
        <label for="deskripsi">Deskripsi</label>
        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?= esc($produk['deskripsi']) ?></textarea>
    </div>

    <div class="form-group">
        <label for="kategori">Kategori</label>
        <select class="form-control" id="kategori" name="kategori_id" required>
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
        <input type="file" class="form-control" id="foto" name="foto" value="<?= base_url('/uploads/produk/' . $produk['nama']) ?>">
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>