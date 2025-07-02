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
            <h1><?= esc($toko['nama']) ?></h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Detail Toko</a></div>
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
                            <h4>List Produk</h4>
                            <div class="card-header-action">
                                <form action="<?= site_url('/admin/detail-toko/store'); ?>" method="POST" enctype="multipart/form-data">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" value="<?= $toko['id']; ?>" name="toko_id">
                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <!-- Tombol untuk membuka modal -->
                                            <button type="submit" class="btn btn-primary">
                                                Tambahkan Stok
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="float-left">
                                <form action="<?= base_url('admin/detail-toko'. '/' . $toko['id']) ?>">
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
                                            <th>Kode</th>
                                            <th>Nama Produk</th>
                                            <th>QTY</th>
                                            <th>Harga Terakhir</th>
                                            <th>Foto</th>
<!--                                            <th>Aksi</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($produkToko as $toko): ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><?= esc($toko['kode']) ?></td>
                                                <td><?= esc($toko['nama']) ?></td>
                                                <td><?= esc($toko['stok']) ?></td>
                                                <td>Rp. <?= number_format((int) $toko['harga']) ?></td>
                                                <td>
                                                    <img src="<?= base_url('uploads/produk/' . $toko['foto']) ?>" alt="" style="width: 50px; height: 50px; object-fit: cover;">
                                                </td>
<!--                                                <td>-->
<!--                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-edit---><?php //= $toko['id'] ?><!--">-->
<!--                                                        <i class="fas fa-plus"></i>-->
<!--                                                    </button>-->
<!---->
<!--                                                    <!-- Form untuk menghapus supplier -->-->
<!--                                                    <form action="--><?php //= site_url('/admin/detail-toko/delete/' . $toko['id']) ?><!--" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus toko ini?')">-->
<!--                                                        --><?php //= csrf_field() ?>
<!--                                                        <button type="submit" class="btn btn-danger btn-sm">-->
<!--                                                            <i class="fas fa-trash"></i>-->
<!--                                                        </button>-->
<!--                                                    </form>-->
<!--                                                </td>-->
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="mt-4 d-flex justify-content-center">
                            <?= $pager->links() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php //= view('components/modal', [
//    'id' => 'modal-create',
//    'title' => 'Tambah Produk',
//    'slot' => view('pages/toko-detail/form-create')
//]) ?>

<?php foreach ($produkToko as $toko): ?>
    <?= view('components/modal', [
        'id' => 'modal-edit-' . $toko['id'],
        'title' => 'Edit Toko',
        'size' => 'modal-lg',
        'slot' => view('pages/toko-detail/form-edit', ['toko' => $toko])
    ]) ?>
<?php endforeach; ?>

<?= $this->endSection() ?>