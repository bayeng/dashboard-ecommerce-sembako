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
                <div class="breadcrumb-item active"><a href="/admin">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="/admin/resep">Resep</a></div>
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
                            <h4>List Resep</h4>
                            <div class="card-header-action">
                                <form>
                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <!-- Tombol untuk membuka modal -->
                                            <a href="<?= base_url('admin/resep/create') ?>" class="btn btn-primary">
                                                Tambah
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="float-left">
                                <form action="<?= base_url('admin/resep') ?>">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="keyword" placeholder="Search">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table-striped table" id="sortable-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center col-2">Foto</th>
                                            <th class="col-8">Nama Resep</th>
                                            <th class="text-center col-2">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($reseps as $resep): ?>
                                            <tr>
                                                <td>
                                                    <img src="<?= base_url('uploads/resep/' . $resep['foto']) ?>" alt="" style="width: 50px; height: 50px; object-fit: cover;">
                                                </td>
                                                <td><?= esc($resep['nama']) ?></td>
                                                <td class="text-center">

                                                    <a href="<?= base_url('admin/resep/edit/' . $resep['id']) ?>" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <!-- Form untuk menghapus supplier -->
                                                    <form action="<?= site_url('/admin/resep/delete/' . $resep['id']) ?>" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus toko ini?')">
                                                        <?= csrf_field() ?>
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection() ?>