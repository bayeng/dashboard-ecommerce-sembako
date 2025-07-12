<form action="<?= site_url('toko/pesanan/update/' . $produk['id']); ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field(); ?>
    <input type="hidden" name="_method" value="PUT">

    <div class="form-group">
        <label for="kurir">Kurir</label>
        <select class="form-control" id="kurir" name="kurir_id" required>
            <option value="">Pilih Kurir</option>
            <?php foreach ($kurirs as $kurir) : ?>
                <option value="<?= $kurir['id'] ?>" <?= $produk['kurir_id'] === $kurir['id'] ? 'selected' : '' ?>><?= $kurir['nama'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="kategori">Status</label>
        <select class="form-control" id="kategori" name="status" required>
            <option value="">Pilih Status</option>
                <option value="1" <?= $produk['status_value'] === 1 ? 'selected' : '' ?> >Diterima</option>
                <option value="2" <?= $produk['status_value'] === 2 ? 'selected' : '' ?> >Diproses</option>
                <option value="3" <?= $produk['status_value'] === 3 ? 'selected' : '' ?> >Dikirim</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>