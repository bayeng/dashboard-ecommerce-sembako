<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Dashboard Toko
<?= $this->endSection() ?>

<?= $this->section('style') ?>
<!-- CSS Libraries -->
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-archive"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Pesanan</h4>
                        </div>
                        <div class="card-body">
                            <?= esc($pesananCount) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Pesanan Masuk</h4>
                        </div>
                        <div class="card-body">
                            <?= esc($pesananMasuk) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Pesanan Selesai</h4>
                        </div>
                        <div class="card-body">
                            <?= esc($pesananSelesai) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Pesanan</h4>
                        <div class="card-header-action">
                            <a href="/toko/pesanan" class="btn btn-danger">View More <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive table-invoice">
                            <table class="table table-striped">
                                <tr>
                                    <th>Kode Pesanan</th>
                                    <th>Nama</th>
                                    <th>Status</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Action</th>
                                </tr>
                                <?php foreach ($pesanan as $pesan): ?>
                                    <tr>
                                        <td><?= esc($pesan['kode_pesanan']) ?></td>
                                        <td><?= esc($pesan['nama_user']) ?></td>
                                        <td><?= esc($pesan['total_harga']) ?></td>
                                        <td><?= esc(match ($pesan['status_value']) {
                                                1 => 'Diterima',
                                                2 => 'Diproses',
                                                3 => 'Dikirim',
                                                default => 'Tidak diketahui'
                                            }) ?></td>
                                        <td>
                                            <a href="<?= site_url('/toko/pesanan/' . $pesan['pesanan_id']) ?>" type="button" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <!-- Form untuk menghapus supplier -->
                                            <form action="<?= site_url('pesanan/delete/' . $pesan['pesanan_id']) ?>" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus toko ini?')">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card gradient-bottom">
                    <div class="card-header">
                        <h4>Produk</h4>
                    </div>
                    <div class="card-body" id="top-5-scroll">
                        <ul class="list-unstyled list-unstyled-border">
                            <?php foreach ($produks as $produk): ?>
                                <li class="media">
                                    <div class="media-body d-flex">
                                        <div class="col-3 mr-3">
                                            <img src="<?= base_url('uploads/produk/' . $produk['foto']) ?>" alt="" style="width: 70px; height: 70px; object-fit: cover;">
                                        </div>
                                        <div>
                                            <p class="h4 text-black"><?= esc($produk['nama']) ?></p>
                                            <td>Rp <?= esc($produk['harga']) ?></td>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<?= $this->endSection() ?>