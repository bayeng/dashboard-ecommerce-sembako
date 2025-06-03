<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Kurir
<?= $this->endSection() ?>

<?= $this->section('style') ?>
<!-- CSS Libraries -->
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Kurir</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Kurir</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>List Kurir</h4>
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
                                <form action="<?= base_url('toko/kurir') ?>">
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
                                        <th class="text-center">No</th>
                                        <th>Foto</th>
                                        <th>Nama</th>
                                        <th>No. HP</th>
                                        <th>Alamat</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $no = 1; foreach ($kurir as $item): ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td>
                                                <?php if (!empty($item['foto'])): ?>
                                                    <img src="<?= base_url('uploads/kurir/' . $item['foto']) ?>" width="100px" height="100px" alt="">
                                                <?php endif; ?>
                                            </td>
                                            <td><?= esc($item['nama']) ?></td>
                                            <td><?= esc($item['no_hp']) ?></td>
                                            <td><?= esc($item['alamat']) ?></td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-show-<?= $item['id'] ?>">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <!-- Tombol untuk membuka modal edit -->
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-edit-<?= $item['id'] ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <!-- Form untuk menghapus supplier -->
                                                <form action="<?= site_url('/toko/kurir/delete/' . $item['id']) ?>" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus supplier ini?')">
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
    'title' => 'Tambah Kurir',
    //    'size' => 'modal-lg', // opsional
    'slot' => view('pages/kurir/create-form')
]) ?>

<?php foreach ($kurir as $item): ?>
    <?= view('components/modal', [
        'id' => 'modal-edit-' . $item['id'],
        'title' => 'Edit Kurir',
        'size' => 'modal-lg',
        'slot' => view('pages/kurir/edit-form', ['item' => $item])
    ]) ?>
<?php endforeach; ?>

<?php foreach ($kurir as $item): ?>
    <?= view('components/modal', [
        'id' => 'modal-show-' . $item['id'],
        'title' => 'Detail Kurir',
        'size' => 'modal-lg',
        'slot' => view('pages/kurir/show', ['$item' => $item])
    ]) ?>
<?php endforeach; ?>

<?= $this->endSection() ?>

