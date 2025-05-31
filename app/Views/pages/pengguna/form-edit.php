<form action="<?= site_url('/admin/pengguna/update/' . $user['id']); ?>" method="POST">
    <?= csrf_field(); ?>
    <input type="hidden" name="_method" value="PUT">

    <div class="form-group">
        <label for="nama">Nama Lengkap</label>
        <input type="text" class="form-control" id="nama" name="nama" value="<?= esc($user['nama']) ?>" >
    </div>

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" value="<?= esc($user['username']) ?>" >
    </div>
    
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" >
    </div>
    
        <div class="form-group">
            <label for="no_hp">No. Telepon</label>
            <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= esc($user['no_hp']) ?>" >
        </div>
    
    <div class="form-group">
        <label for="address">Alamat</label>
        <textarea class="form-control" id="address" name="alamat" rows="3" ><?= esc($user['nama']) ?></textarea>
    </div>

    <div class="form-group">
        <label for="role">Role</label>
        <select class="form-control" id="role" name="role" >
            <option <?= $user['role'] === '' ? 'selected' : '' ?> value="">Pilih Role</option>
            <option <?= $user['role'] === 'user' ? 'selected' : '' ?> value="user">Pengguna</option>
            <option <?= $user['role'] === 'penjual' ? 'selected' : '' ?> value="penjual">Pegawai Toko</option>
            <option <?= $user['role'] === 'supplier' ? 'selected' : '' ?> value="supplier">Supplier</option>
            <option <?= $user['role'] === 'admin' ? 'selected' : '' ?> value="admin">Admin</option>
        </select>
    </div>

    <div class="form-group">
        <label for="toko">Toko</label>
        <select class="form-control" id="toko" name="toko_id" >
            <option value="">Pilih Toko</option>
            <?php foreach ($tokos as $toko): ?>
                <option value="<?= $toko['id']; ?>" <?= $user['toko_id'] === $toko['id'] ? 'selected' : '' ?> ><?= $toko['nama']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>