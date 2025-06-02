<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Toko
<?= $this->endSection() ?>

<?= $this->section('style') ?>
<!-- CSS Libraries -->
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Toko</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Toko</a></div>
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
                            <h4>List Toko</h4>
                            <div class="card-header-action">
                                <form>
                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <!-- Tombol untuk membuka modal -->
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create">
                                                Tambah
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="float-left">
                                <form action="<?= base_url('admin/toko') ?>">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="keyword" placeholder="Search">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table-striped table" id="sortable-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Nama Toko</th>
                                            <th>Alamat</th>
                                            <th>Foto</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($tokos as $toko): ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><?= esc($toko['nama']) ?></td>
                                                <td><?= esc($toko['alamat']) ?></td>
                                                <td>
                                                    <img src="<?= base_url('uploads/toko/' . $toko['foto']) ?>" alt="" style="width: 50px; height: 50px; object-fit: cover;">
                                                </td>
                                                <td>
                                                    <a href="/admin/detail-toko/<?= $toko['id'] ?>" class="btn btn-primary btn-sm">
                                                        Lihat Toko
                                                    </a>

                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-show-<?= $toko['id'] ?>">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <!-- Tombol untuk membuka modal edit -->
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-edit-<?= $toko['id'] ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    <!-- Form untuk menghapus supplier -->
                                                    <form action="<?= site_url('/admin/toko/delete/' . $toko['id']) ?>" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus toko ini?')">
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

<?= view('components/modal', [
    'id' => 'modal-create',
    'title' => 'Tambah Toko',
    'slot' => view('pages/toko/form-create')
]) ?>

<?php foreach ($tokos as $toko): ?>
    <?= view('components/modal', [
        'id' => 'modal-show-' . $toko['id'],
        'title' => 'Detail Toko',
        'size' => 'modal-lg',
        'slot' => view('pages/toko/show', ['toko' => $toko])
    ]) ?>
<?php endforeach; ?>

<?php foreach ($tokos as $toko): ?>
    <?= view('components/modal', [
        'id' => 'modal-edit-' . $toko['id'],
        'title' => 'Edit Toko',
        'size' => 'modal-lg',
        'slot' => view('pages/toko/form-edit', ['toko' => $toko])
    ]) ?>
<?php endforeach; ?>

<?= $this->endSection() ?>