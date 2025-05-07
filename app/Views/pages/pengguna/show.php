<form action="<?= site_url('pengguna/store'); ?>" method="POST">
    <?= csrf_field(); ?>

    <div class="form-group">
        <label for="nama">Nama Lengkap</label>
        <input type="text" class="form-control" id="nama" name="nama" value="<?= esc($user['nama']) ?>" disabled required>
    </div>

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" value="<?= esc($user['username']) ?>" disabled required>
    </div>
    
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" disabled required>
    </div>
    
        <div class="form-group">
            <label for="no_hp">No. Telepon</label>
            <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= esc($user['no_hp']) ?>" disabled required>
        </div>
    
    <div class="form-group">
        <label for="address">Alamat</label>
        <textarea class="form-control" id="address" name="alamat" rows="3" disabled required><?= esc($user['nama']) ?></textarea>
    </div>

    <div class="form-group">
        <label for="role">Role</label>
        <select class="form-control" id="role" name="role" value="<?= esc($user['role']) ?>" disabled required>
            <option value="">Pilih Role</option>
            <option value="admin">Pengguna</option>
            <option value="user">Pegawai Toko</option>
            <option value="user">Supplier</option>
            <option value="user">Admin</option>
        </select>
    </div>

    <div class="form-group">
        <label for="toko">Toko</label>
        <select class="form-control" id="toko" name="toko_id" value="<?= esc($user['toko_id']) ?>" disabled>
            <option value="">Pilih Toko</option>
            <?php foreach ($tokos as $toko): ?>
                <option value="<?= $toko['id']; ?>"><?= $toko['nama']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- <button type="submit" class="btn btn-primary">Simpan</button> -->
</form>