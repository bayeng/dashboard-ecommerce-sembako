<form action="<?= site_url('/toko/kurir/update/' . $item['id']); ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field(); ?>

    <input type="hidden" name="_method" value="PUT">

    <div class="form-group">
        <label for="nama">Nama Produk</label>
        <input type="text" class="form-control" id="nama" name="nama" value="<?= $item['nama'] ?>" required>
    </div>

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" value="<?= $item['username'] ?>" required>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" value="">
    </div>

    <div class="form-group">
        <label for="no_hp">No Handphone</label>
        <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= $item['no_hp'] ?>" required>
    </div>

    <div class="form-group">
        <label for="kontak_person">Kontak Person</label>
        <input type="text" class="form-control" id="kontak_person" name="kontak_person" value="<?= $item['kontak_person'] ?>" required>
    </div>

    <div class="form-group">
        <label for="alamat">Alamat</label>
        <textarea type="text" class="form-control" id="alamat" name="alamat" required><?= esc($item['alamat']) ?></textarea>
    </div>

    <div class="form-group">
        <label for="foto">Foto</label>
        <?php if (!empty($item['foto'])): ?>
            <div class="mb-2">
                <img src="<?= base_url('uploads/kurir/' . $item['foto']) ?>" alt="Foto Produk" width="100">
            </div>
        <?php endif; ?>
        <input type="file" class="form-control" id="foto" name="foto">
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>