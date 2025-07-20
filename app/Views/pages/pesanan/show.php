<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Detail Pesanan
<?= $this->endSection() ?>

<?= $this->section('style') ?>
<!-- CSS Libraries -->
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Pesanan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Pesanan</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <table class="w-100">
                                        <tr>
                                            <td class="w-50">Kode Pesanan</td>
                                            <td class="w-50">: <?= esc($pesanan['kode_pesanan']) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Nama Pengguna</td>
                                            <td>: <?= esc($pesanan['nama_user']) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ongkir</td>
                                            <td>: Rp. <?= $pesanan['ongkir'] ? esc(number_format($pesanan['ongkir'])) : 'Gratis' ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Total Harga</td>
                                            <td>: Rp. <?= esc(number_format($pesanan['total_harga'])) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>: <?= esc(match ($pesanan['status_value']) {
                                                        "1" => 'Diterima',
                                                        "2" => 'Diproses',
                                                        "3" => 'Dikirim',
                                                        "4" => 'Selesai',
                                                        default => 'Tidak diketahui'
                                                    }) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Metode Pembayaran</td>
                                            <td>: <?= esc($pesanan['metode_pembayaran']) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Nama Kurir</td>
                                            <td>: <?= esc($pesanan['nama_kurir']) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Pesanan</td>
                                            <td>: <?= esc(date('d F Y', strtotime($pesanan['created_at']))) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Diterima</td>
                                            <td>: <?= esc(date('d F Y', strtotime($pesanan['updated_at']))) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Bukti Diterima</td>
                                            <td>: <img src="<?= base_url('uploads/pesanan/' . $pesanan['foto']) ?>" alt="" style="width: 50px; height: 50px; object-fit: cover;"></td>
                                        </tr>
                                        <tr>
                                            <td>Catatan Pelanggan</td>
                                            <td>: <?= esc($pesanan['catatan']) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Catatan Kurir</td>
                                            <td>: <?= esc($pesanan['catatan_kurir']) ?>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                                <div class="table-responsive w-full mt-5">
                                    <table class="table-striped table" id="sortable-table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Produk</th>
                                                <th>Jumlah</th>
                                                <th>Harga</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php foreach ($pesanan['produk'] as $produk) : ?>
                                                <tr>
                                                    <td><?= esc($produk['produk']) ?></td>
                                                    <td><?= esc($produk['qty']) ?></td>
                                                    <td>Rp. <?= esc(number_format($produk['harga'])) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>

                                    <div class="w-full d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <form action="<?= site_url('/toko/pesanan/update/' . $pesanan['pesanan_id']) ?>" method="POST" style="display:inline; margin-right:20px">
                                                <?= csrf_field() ?>
                                                <input type="text" hidden="hidden" name="_method" value="PUT">
                                                <input type="text" hidden="hidden" name="status" value="2">
                                                <button type="submit" class="btn btn-warning">
                                                    Diproses
                                                </button>
                                            </form>
                                            <form action="<?= site_url('/toko/pesanan/update/' . $pesanan['pesanan_id']) ?>" method="POST" style="display:inline; margin-right:20px">
                                                <?= csrf_field() ?>
                                                <input type="text" hidden="hidden" name="_method" value="PUT">
                                                <input type="text" hidden="hidden" name="status" value="3">
                                                <button type="submit" class="btn btn-info">
                                                    Dikirim
                                                </button>
                                            </form>
                                        </div>

                                        <div class="btn-group">
                                            <a href="<?= base_url('/toko/pesanan') ?>" class="btn btn-primary">Kembali</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection() ?>