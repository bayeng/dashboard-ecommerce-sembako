<form action="<?= site_url('kurir/update/' . $item['id']); ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field(); ?>

    <input type="hidden" name="_method" value="PUT">

    <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" class="form-control" id="nama" name="nama" value="<?= $item['nama'] ?>" disabled required>
    </div>

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" value="<?= $item['username'] ?>" disabled required>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="text" class="form-control" id="password" name="password" value="" disabled required>
    </div>

    <div class="form-group">
        <label for="no_hp">No Handphone</label>
        <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= $item['no_hp'] ?>" disabled required>
    </div>

    <div class="form-group">
        <label for="kontak_person">Kontak Person</label>
        <input type="text" class="form-control" id="kontak_person" name="kontak_person" value="<?= $item['kontak_person'] ?>" disabled required>
    </div>

    <div class="form-group">
        <label for="alamat">Alamat</label>
        <textarea type="text" class="form-control" id="alamat" name="alamat" disabled required><?= $item['kontak_person'] ?></textarea>
    </div>

    <div class="form-group">
        <label for="foto">Foto</label>
        <?php if (!empty($item['foto'])): ?>
            <div class="mb-2">
                <img src="<?= base_url('uploads/kurir/' . $item['foto']) ?>" alt="Foto Produk" width="100">
            </div>
        <?php endif; ?>
    </div>
</form>