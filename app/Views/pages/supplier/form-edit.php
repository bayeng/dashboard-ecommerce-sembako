<form action="<?= site_url('/admin/supplier/update/' . $supplier['id']) ?>" method="POST">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="PUT">

    <div class="form-group">
        <label for="nama">Nama Supplier</label>
        <input type="text" class="form-control" id="name" name="nama" value="<?= $supplier['nama'] ?>" required>
    </div>

    <div class="form-group">
        <label for="email">Email Supplier</label>
        <input type="email" class="form-control" id="email" name="email" value="<?= $supplier['email'] ?>" required>
    </div>

    <div class="form-group">
        <label for="no_hp">Nomor Telepon</label>
        <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= $supplier['no_hp'] ?>" required>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="bank">Nama Bank</label>
            <input type="text" class="form-control" id="bank" name="bank" value="<?= $supplier['bank'] ?>" required>
        </div>

        <div class="form-group col-md-6">
            <label for="no_rekening">No Rekening</label>
            <input type="text" class="form-control" id="no_rekening" name="no_rekening" value="<?= $supplier['no_rekening'] ?>" required>
        </div>
    </div>

    <div class="form-group">
        <label for="address">Alamat Supplier</label>
        <textarea class="form-control" id="address" name="alamat" rows="3" required><?= esc($supplier['alamat']) ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>