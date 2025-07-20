<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Pesanan
<?= $this->endSection() ?>

<?= $this->section('style') ?>
<!-- CSS Libraries -->
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pesanan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Pesanan</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>List Pesanan</h4>
                            <div class="card-header-action">
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="float-left">
                                <form>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Search">
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
                                            <th class="text-center">Kode</th>
                                            <th>Nama Pengguna</th>
                                            <th>Harga</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($pesanan as $pesan): ?>
                                            <tr>
                                                <td><?= esc($pesan['kode_pesanan']) ?></td>
                                                <td><?= esc($pesan['nama_user']) ?></td>
                                                <td>Rp. <?= esc(number_format($pesan['total_harga'])) ?></td>
                                                <td><?= esc(match ($pesan['status_value']) {
                                                        "1" => 'Diterima',
                                                        "2" => 'Diproses',
                                                        "3" => 'Dikirim',
                                                        "4" => 'Selesai',
                                                        default => 'Tidak diketahui'
                                                    }) ?></td>
                                                <td>
                                                    <a href="<?= site_url('/toko/pesanan/' . $pesan['pesanan_id']) ?>" type="button" class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <!-- Tombol untuk membuka modal edit -->
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-edit-<?= $pesan['pesanan_id'] ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
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

<?php foreach ($pesanan as $pesan): ?>
    <?= view('components/modal', [
        'id' => 'modal-edit-' . $pesan['pesanan_id'],
        'title' => 'Ubah Status',
        'size' => 'modal-lg',
        'slot' => view('pages/pesanan/form-edit', ['produk' => $pesan])
    ]) ?>
<?php endforeach; ?>

<?= $this->endSection() ?>