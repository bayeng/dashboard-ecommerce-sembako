<form action="<?= site_url('kategori/update/' . $kategori['id']) ?>" method="POST">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="PUT">

    <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" class="form-control" id="name" name="nama" value="<?= $kategori['nama'] ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>