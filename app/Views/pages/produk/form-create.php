<form action="<?= site_url('/toko/produk/store'); ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field(); ?>

    <div class="form-group">
        <label for="nama">Nama Produk</label>
        <input type="text" class="form-control" id="nama" name="nama" required>
    </div>
    
    <div class="form-group">
        <label for="kode">Kode</label>
        <input type="text" class="form-control" id="kode" name="kode" required>
    </div>

    <div class="form-group">
        <label for="harga">Harga</label>
        <input type="number" class="form-control" id="harga" name="harga" required>
    </div>
    
    <div class="form-group">
        <label for="stok">Stok</label>
        <input type="number" class="form-control" id="stok" name="stok" required>
    </div>
    
    <div class="form-group">
        <label for="deskripsi">Deskripsi</label>
        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
    </div>

    <div class="form-group">
        <label for="kategori">Kategori</label>
        <select class="form-control" id="kategori" name="kategori_id" required>
            <option value="">Pilih Kategori</option>
            <?php foreach ($kategoris as $kategori): ?>
                <option value="<?= $kategori['id']; ?>"><?= $kategori['nama']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="foto" class="form-label">Foto</label>
        <input type="file" class="form-control" id="foto" name="foto"  required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>