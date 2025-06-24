<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Pengemasan Produk
<?= $this->endSection() ?>

<?= $this->section('style') ?>
<!-- CSS Libraries -->
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pengemasan Produk Mentah</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Produk Mentah</a></div>
                <div class="breadcrumb-item active font-weight-bold"><a href="#">Pengemasan Produk</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>List Pengemasan Produk - <?= $produkMentah['nama'] ?></h4>
                            <div class="card-header-action">
                                <form>
                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <!-- Tombol untuk membuka modal -->
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create-<?= $produkMentah['id'] ?>">
                                                Tambah
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="float-left d-flex justify-content-between w-100 mb-3">
                                <form>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>

                                
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create-gudang">
                                    Pengemasan Baru
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table-striped table" id="sortable-table">
                                    <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Foto</th>
                                        <th>Nama Produk</th>
                                        <th>Stok</th>
                                        <th>Tanggal Pengemasan</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $no = 1; foreach ($produkPacking as $item): ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td>
                                                <?php if (!empty($item['foto_produk_gudang'])): ?>
                                                    <img src="<?= base_url('uploads/produk-gudang/' . $item['foto_produk_gudang']) ?>" width="100px" height="100px" alt="">
                                                <?php endif; ?>
                                            </td>
                                            <td><?= esc($item['nama_produk_gudang']) ?></td>
                                            <td><?= esc($item['stok']) ?> <?= esc($item['satuan_stok']) ?></td>
                                            <td><?= esc($item['created_at']) ?></td>
<!--                                            <td>-->
<!--                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-add---><?php //= $item['id'] ?><!--">-->
<!--                                                    <i class="fas fa-cart-plus"></i>-->
<!--                                                </button>-->
<!---->
<!--                                                <!-- Form untuk menghapus supplier -->-->
<!--                                                <form action="--><?php //= site_url('/admin/produk-mentah/delete/' . $item['id']) ?><!--" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus supplier ini?')">-->
<!--                                                    --><?php //= csrf_field() ?>
<!--                                                    <button type="submit" class="btn btn-danger btn-sm">-->
<!--                                                        <i class="fas fa-trash"></i>-->
<!--                                                    </button>-->
<!--                                                </form>-->
<!--                                            </td>-->
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
<?= view('components/modal', [
    'id' => 'modal-create-' . $produkMentah['id'],
    'title' => 'Tambah Produk Mentah',
//        'size' => 'modal-lg', // opsional
    'slot' => view('pages/produk-mentah/create-pengemasan', ['produkMentah' => $produkMentah, 'produkGudang' => $produkGudang])
]) ?>

<?= view('components/modal', [
    'id' => 'modal-create-gudang',
    'title' => 'Tambah Produk Gudang',
    //        'size' => 'modal-lg', // opsional
    'slot' => view('pages/produk-mentah/create-form-gudang', ['supplier' => $supplier])
]) ?>

<!---->
<?php //foreach ($produkMentah as $item): ?>
<!--    --><?php //= view('components/modal', [
//        'id' => 'modal-edit-' . $item['id'],
//        'title' => 'Edit Produk Mentah',
//        'size' => 'modal-lg',
//        'slot' => view('pages/produk-mentah/edit-form', ['kategori' => $item, 'supplier' => $supplier])
//    ]) ?>
<?php //endforeach; ?>
<!---->
<?php foreach ($produkPacking as $item): ?>
    <?= view('components/modal', [
        'id' => 'modal-add-' . $item['id'],
        'title' => 'Tambah Pengemasan',
//        'size' => 'modal-lg',
        'slot' => view('pages/produk-mentah/addstock-pengemasan', ['item' => $item, 'produkPacking' => $produkPacking])
    ]) ?>
<?php endforeach; ?>

<?= $this->endSection() ?>

