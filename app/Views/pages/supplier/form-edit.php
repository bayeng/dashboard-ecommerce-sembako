<form action="<?= site_url('supplier/update/' . $supplier['id']) ?>" method="POST">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="PUT">

    <div class="form-group">
        <label>Nama Supplier</label>
        <input type="text" name="name" class="form-control" value="<?= esc($supplier['nama']) ?>" required>
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="<?= esc($supplier['email']) ?>" required>
    </div>

    <div class="form-group">
        <label>Nomor HP</label>
        <input type="text" name="phone" class="form-control" value="<?= esc($supplier['no_hp']) ?>" required>
    </div>

    <div class="form-group">
        <label>Alamat</label>
        <textarea name="address" class="form-control" rows="3"><?= esc($supplier['alamat']) ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>