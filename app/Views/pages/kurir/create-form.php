<form action="<?= site_url('/toko/kurir/store'); ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field(); ?>

    <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" class="form-control" id="nama" name="nama" value="" required>
    </div>

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" value="" required>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" value="" required>
    </div>

    <div class="form-group">
        <label for="no_hp">No Handphone</label>
        <input type="text" class="form-control" id="no_hp" name="no_hp" value="" required>
    </div>

    <div class="form-group">
        <label for="kontak_person">Kontak Person</label>
        <input type="text" class="form-control" id="kontak_person" name="kontak_person" value="" required>
    </div>

    <div class="form-group">
        <label for="alamat">Alamat</label>
        <textarea type="text" class="form-control" id="alamat" name="alamat" required></textarea>
    </div>

    <div class="form-group">
        <label for="foto">Foto</label>
        <input type="file" class="form-control" id="foto" name="foto">
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>