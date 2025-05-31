<form action="<?= site_url('/admin/supplier/store'); ?>" method="POST">
    <?= csrf_field(); ?>

    <div class="form-group">
        <label for="nama">Nama Supplier</label>
        <input type="text" class="form-control" id="name" name="nama" required>
    </div>

    <div class="form-group">
        <label for="email">Email Supplier</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>

    <div class="form-group">
        <label for="no_hp">Nomor Telepon</label>
        <input type="text" class="form-control" id="no_hp" name="no_hp" required>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="bank">Nama Bank</label>
            <input type="text" class="form-control" id="bank" name="bank" required>
        </div>

        <div class="form-group col-md-6">
            <label for="no_rekening">No Rekening</label>
            <input type="text" class="form-control" id="no_rekening" name="no_rekening" required>
        </div>
    </div>

    <div class="form-group">
        <label for="address">Alamat Supplier</label>
        <textarea class="form-control" id="address" name="alamat" rows="3" required></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>