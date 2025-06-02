<form action="<?= site_url('/admin/pengguna/store'); ?>" method="POST">
    <?= csrf_field(); ?>

    <div class="form-group">
        <label for="nama">Nama Lengkap</label>
        <input type="text" class="form-control" id="nama" name="nama" required>
    </div>

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>
    
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    
        <div class="form-group">
            <label for="no_hp">No. Telepon</label>
            <input type="text" class="form-control" id="no_hp" name="no_hp" required>
        </div>
    
    <div class="form-group">
        <label for="address">Alamat</label>
        <textarea class="form-control" id="address" name="alamat" rows="3" required></textarea>
    </div>

    <div class="form-group">
        <label for="role">Role</label>
        <select class="form-control" id="role" name="role" required>
            <option value="">Pilih Role</option>
            <option value="user">Pengguna</option>
            <option value="penjual">Pegawai Toko</option>
            <option value="supplier">Supplier</option>
            <option value="admin">Admin</option>
        </select>
    </div>

    <div class="form-group">
        <label for="toko">Toko</label>
        <select class="form-control" id="toko" name="toko_id">
            <option value="">Pilih Toko</option>
            <?php foreach ($tokos as $toko): ?>
                <option value="<?= $toko['id']; ?>"><?= $toko['nama']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>