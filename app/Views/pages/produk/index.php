<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
    Produk
<?= $this->endSection() ?>

<?= $this->section('style') ?>
    <!-- CSS Libraries -->
<?= $this->endSection() ?>

<?= $this->section('main') ?>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Produk</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Produk</a></div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>List Produk</h4>
                                <div class="card-header-action">
                                    
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="float-left">
                                    <form action="<?= base_url('toko/produk') ?>">
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
                                            <th class="text-center">Kode</th>
                                            <th>Nama Produk</th>
                                            <th>Harga</th>
                                            <th>Stok</th>
                                            <th>Foto</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($produks as $produk): ?>
                                                <tr>
                                                    <td><?= esc($produk['kode']) ?></td>
                                                    <td><?= esc($produk['nama']) ?></td>
                                                    <td>Rp. <?= esc(number_format($produk['harga'])) ?></td>
                                                    <td><?= esc($produk['stok']) ?></td>
                                                    <td>
                                                        <img src="<?= base_url('uploads/produk/' . $produk['foto']) ?>" alt="" style="width: 50px; height: 50px; object-fit: cover;">
                                                    </td>
                                                    <td class="text-center w-25">

                                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-show-<?= $produk['id'] ?>">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <!-- Tombol untuk membuka modal edit -->
                                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-edit-<?= $produk['id'] ?>">
                                                            <i class="fas fa-edit"></i>
                                                        </button>

                                                        <!-- Form untuk menghapus supplier -->
                                                        <form action="<?= site_url('/toko/produk/delete/' . $produk['id']) ?>" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus toko ini?')">
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
        'title' => 'Tambah Produk',
        'slot' => view('pages/produk/form-create', ['kategoris' => $kategoris, 'produkGudangs' => $produkGudangs])
    ]) ?>

    <?php foreach ($produks as $produk): ?>
        <?= view('components/modal', [
            'id' => 'modal-show-' . $produk['id'],
            'title' => 'Detail Produk',
            'size' => 'modal-lg',
            'slot' => view('pages/produk/show', ['produk' => $produk])
        ]) ?>
    <?php endforeach; ?>

    <?php foreach ($produks as $produk): ?>
        <?= view('components/modal', [
            'id' => 'modal-edit-' . $produk['id'],
            'title' => 'Detail Produk',
            'size' => 'modal-lg',
            'slot' => view('pages/produk/form-edit', ['produk' => $produk])
        ]) ?>
    <?php endforeach; ?>

<?= $this->endSection() ?>

