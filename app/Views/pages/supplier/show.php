<form action="<?= site_url('supplier/update/' . $supplier['id']) ?>" method="POST">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="PUT">

    <div class="form-group">
        <label for="nama">Nama Supplier</label>
        <input type="text" class="form-control" id="name" name="nama" value="<?= $supplier['nama'] ?>" disabled>
    </div>

    <div class="form-group">
        <label for="email">Email Supplier</label>
        <input type="email" class="form-control" id="email" name="email" value="<?= $supplier['email'] ?>" disabled>
    </div>

    <div class="form-group">
        <label for="no_hp">Nomor Telepon</label>
        <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= $supplier['no_hp'] ?>" disabled>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="bank">Nama Bank</label>
            <input type="text" class="form-control" id="bank" name="bank" value="<?= $supplier['bank'] ?>" disabled>
        </div>

        <div class="form-group col-md-6">
            <label for="no_rekening">No Rekening</label>
            <input type="text" class="form-control" id="no_rekening" name="no_rekening" value="<?= $supplier['no_rekening'] ?>" disabled>
        </div>
    </div>

    <div class="form-group">
        <label for="alamat">Alamat Supplier</label>
        <textarea class="form-control" id="alamat" name="alamat"  disabled><?= esc($supplier['alamat']) ?></textarea>
    </div>

</form>