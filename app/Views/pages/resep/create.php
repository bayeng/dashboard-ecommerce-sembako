<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Resep
<?= $this->endSection() ?>

<?= $this->section('style') ?>
<!-- CSS Libraries -->
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Resep</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Resep</a></div>
            </div>
        </div>

        <?php if (session()->has('error')) : ?>
            <div class="alert alert-danger">
                <?= session('error') ?>
            </div>
        <?php elseif (session()->has('success')) : ?>
            <div class="alert alert-info">
                <?= session('success') ?>
            </div>
        <?php endif; ?>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Resep Baru</h4>
                            <div class="card-header-action">

                            </div>
                        </div>

                        <div class="card-body">
                            <form action="<?= site_url('/admin/resep/store'); ?>" method="POST" enctype="multipart/form-data">
                                <?= csrf_field(); ?>

                                <div class="form-group">
                                    <label for="nama">Nama Resep</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mb-1">
                                        <label for="bahan">Bahan</label>
                                        <button type="button" class="btn btn-sm btn-primary" id="addBahan">Tambah Bahan</button>
                                    </div>
                                    <div id="bahanContainer" class="p-2 border rounded">
                                        <div class="d-flex mb-1">
                                            <input type="text" class="form-control col-11" id="bahan" name="bahan[]" required>
                                            <button type="button" class="btn btn-sm btn-danger col-1 ml-1" id="removeBahan"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mb-1">
                                        <label for="bumbu">Bumbu</label>
                                        <button type="button" class="btn btn-sm btn-primary" id="addBumbu">Tambah Bumbu</button>
                                    </div>
                                    <div id="bumbuContainer" class="p-2 border rounded">
                                        <div class="d-flex mb-1">
                                            <input type="text" class="form-control col-11" id="bumbu" name="bumbu[]" required>
                                            <button type="button" class="btn btn-sm btn-danger col-1 ml-1" id="removeBumbu"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mb-1">
                                        <label for="prosedur">Langkah Pembuatan</label>
                                        <button type="button" class="btn btn-sm btn-primary" id="addProsedur">Tambah Prosedur</button>
                                    </div>
                                    <div id="prosedurContainer" class="p-2 border rounded">
                                        <div class="d-flex mb-1">
                                            <input type="text" class="form-control col-11" id="prosedur" name="prosedur[]" required>
                                            <button type="button" class="btn btn-sm btn-danger col-1 ml-1" id="removeProsedur"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="foto" class="form-label">Foto</label>
                                    <input type="file" class="form-control" id="foto" name="foto" value="">
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addBahanButton = document.getElementById('addBahan');
        const removeBahanButton = document.getElementById('removeBahan');
        const bahanContainer = document.getElementById('bahanContainer');

        addBahanButton.addEventListener('click', function() {
            const bahan = document.createElement('div');
            bahan.className = 'd-flex mb-1';

            const bahanInput = document.createElement('input');
            bahanInput.type = 'text';
            bahanInput.className = 'form-control col-11';
            bahanInput.name = 'bahan[]';
            bahanInput.required = true;

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-sm btn-danger col-1 ml-1';
            removeButton.innerHTML = '<i class="fas fa-trash"></i>';

            removeButton.addEventListener('click', function() {
                bahanContainer.removeChild(bahan);
            });

            bahan.appendChild(bahanInput);
            bahan.appendChild(removeButton);

            bahanContainer.appendChild(bahan);
        });

        const addBumbuButton = document.getElementById('addBumbu');
        const removeBumbuButton = document.getElementById('removeBumbu');
        const bumbuContainer = document.getElementById('bumbuContainer');

        addBumbuButton.addEventListener('click', function() {
            const bumbu = document.createElement('div');
            bumbu.className = 'd-flex mb-1';

            const bumbuInput = document.createElement('input');
            bumbuInput.type = 'text';
            bumbuInput.className = 'form-control col-11';
            bumbuInput.name = 'bumbu[]';
            bumbuInput.required = true;

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-sm btn-danger col-1 ml-1';
            removeButton.innerHTML = '<i class="fas fa-trash"></i>';

            removeButton.addEventListener('click', function() {
                bumbuContainer.removeChild(bumbu);
            });

            bumbu.appendChild(bumbuInput);
            bumbu.appendChild(removeButton);

            bumbuContainer.appendChild(bumbu);
        });

        const addProsedurButton = document.getElementById('addProsedur');
        const removeProsedurButton = document.getElementById('removeProsedur');
        const prosedurContainer = document.getElementById('prosedurContainer');

        addProsedurButton.addEventListener('click', function() {
            const prosedur = document.createElement('div');
            prosedur.className = 'd-flex mb-1';

            const prosedurInput = document.createElement('input');
            prosedurInput.type = 'text';
            prosedurInput.className = 'form-control col-11';
            prosedurInput.name = 'prosedur[]';
            prosedurInput.required = true;

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-sm btn-danger col-1 ml-1';
            removeButton.innerHTML = '<i class="fas fa-trash"></i>';

            removeButton.addEventListener('click', function() {
                prosedurContainer.removeChild(prosedur);
            });

            prosedur.appendChild(prosedurInput);
            prosedur.appendChild(removeButton);

            prosedurContainer.appendChild(prosedur);
        });

    });
</script>

<?= $this->endSection() ?>