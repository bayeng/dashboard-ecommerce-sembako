<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Produk Gudang
<?= $this->endSection() ?>

<?= $this->section('style') ?>
<!-- CSS Libraries -->
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Produk Gudang</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Produk Gudang</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>List Produk Gudang</h4>
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
                            <div class="float-left d-flex justify-content-between w-100 mb-3">
                                <form method="get" action="<?= base_url('/admin/produk-gudang') ?>">
                                    <div class="input-group">
                                        <input name="keyword" type="text" class="form-control mr-3" placeholder="Search" value="<?= esc($keyword) ?>">
                                        <select name="kategori_id" class="form-control mr-3" style="max-width: 180px;">
                                            <option value="">Semua Kategori</option>
                                            <?php foreach ($kategori as $k): ?>
                                                <option value="<?= $k['id'] ?>" <?= ($kategori == $k['id']) ? 'selected' : '' ?>>
                                                    <?= $k['nama'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary rounded"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                                <div>
                                    <a href="/admin/produk-mentah" class="btn btn-primary">Pengemasan Stok</a>
                                    <a href="/admin/produk-mentah" class="btn btn-primary">Produk Mentah</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table-striped table" id="sortable-table">
                                    <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Foto</th>
                                        <th>Nama Produk</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $no = 1; foreach ($produkGudang as $item): ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td>
                                                <?php if (!empty($item['foto'])): ?>
                                                    <img src="<?= base_url('uploads/produk-gudang/' . $item['foto']) ?>" width="100px" height="100px" alt="">
                                                <?php endif; ?>
                                            </td>
                                            <td><?= esc($item['nama']) ?></td>
                                            <td>Rp. <?= esc(number_format($item['harga'])) ?></td>
                                            <td><?= esc($item['stok']) ?> <?= esc($item['satuan_stok']) ?></td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-show-<?= $item['id'] ?>">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <!-- Tombol untuk membuka modal edit -->
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-edit-<?= $item['id'] ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <!-- Form untuk menghapus supplier -->
                                                <form action="<?= site_url('/admin/produk-gudang/delete/' . $item['id']) ?>" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus supplier ini?')">
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
    'id' => 'modal-create',
    'title' => 'Tambah Produk Gudang',
//        'size' => 'modal-lg', // opsional
    'slot' => view('pages/produk-gudang/create-form', ['produkMentah' => $produkMentah, 'kategori' => $kategori, 'satuanStok' => $satuanStok])
]) ?>

<?php foreach ($produkGudang as $item): ?>
    <?= view('components/modal', [
        'id' => 'modal-edit-' . $item['id'],
        'title' => 'Edit Produk Gudang',
        'size' => 'modal-lg',
        'slot' => view('pages/produk-gudang/edit-form', ['item' => $item, 'produkMentah' => $produkMentah, 'satuanStok' => $satuanStok])
    ]) ?>
<?php endforeach; ?>

<?php foreach ($produkGudang as $item): ?>
    <?= view('components/modal', [
        'id' => 'modal-show-' . $item['id'],
        'title' => 'Detail Produk Gudang',
        'size' => 'modal-lg',
        'slot' => view('pages/produk-gudang/show', ['$item' => $item, 'produkMentah' => $produkMentah, 'kategori' => $kategori])
    ]) ?>
<?php endforeach; ?>

<?= $this->endSection() ?>

