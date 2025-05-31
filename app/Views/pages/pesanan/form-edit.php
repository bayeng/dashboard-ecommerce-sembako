<form action="<?= site_url('pesanan/update/' . $produk['id']); ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field(); ?>
    <input type="hidden" name="_method" value="PUT">

    <div class="form-group">
        <label for="kategori">Status</label>
        <select class="form-control" id="kategori" name="kategori_id" required>
            <option value="">Pilih Status</option>
                <option value="1" <?= $produk['status_value'] === 1 ? 'selected' : '' ?> >Diterima</option>
                <option value="2" <?= $produk['status_value'] === 2 ? 'selected' : '' ?> >Diproses</option>
                <option value="3" <?= $produk['status_value'] === 3 ? 'selected' : '' ?> >Dikirim</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>