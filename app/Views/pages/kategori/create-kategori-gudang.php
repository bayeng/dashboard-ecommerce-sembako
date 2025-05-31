<form action="<?= site_url('kategori/store'); ?>" method="POST">
    <?= csrf_field(); ?>

    <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" class="form-control" id="name" name="nama" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>