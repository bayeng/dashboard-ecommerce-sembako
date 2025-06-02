<form action="<?= site_url('toko/update/' . $toko['id']); ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field(); ?>

    <div class="form-group">
        <label for="nama">Nama Toko</label>
        <input type="text" class="form-control" id="nama" name="nama" value="<?= $toko['nama'] ?>" disabled>
    </div>

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" value="<?= $toko['username'] ?>" name="username" disabled>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" disabled>
    </div>

    <div class="form-group">
        <label for="no_hp">No. Handphone</label>
        <input type="text" class="form-control" id="no_hp" value="<?= $toko['no_hp'] ?>" name="no_hp" disabled>
    </div>
    
    <div class="form-group">
        <label for="address">Alamat</label>
        <textarea class="form-control" id="address" name="alamat" rows="3" disabled><?= esc($toko['alamat']) ?></textarea>
    </div>

    <div class="form-group">
        <label for="foto" class="form-label">Foto</label>
        <?php if (!empty($produk['foto'])): ?>
            <div class="mb-2">
                <img src="<?= base_url('uploads/produk/' . $produk['foto']) ?>" alt="Foto Produk" width="100">
            </div>
        <?php endif; ?>
        <input type="file" class="form-control" id="foto" name="foto" value="<?= base_url('uploads/toko/' . $toko['foto']) ?>" disabled>
    </div>
</form>