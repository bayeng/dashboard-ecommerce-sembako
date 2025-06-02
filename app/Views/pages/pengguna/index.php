<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
    Pengguna
<?= $this->endSection() ?>

<?= $this->section('style') ?>
    <!-- CSS Libraries -->
<?= $this->endSection() ?>

<?= $this->section('main') ?>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Pengguna</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Pengguna</a></div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>List Pengguna</h4>
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
                                    <form action="<?= site_url('admin/pengguna') ?>">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Search" name="keyword" value="<?= esc($keyword) ?>">
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
                                            <th>Nama</th>
                                            <th>Username</th>
                                            <th>No. Telepon</th>
                                            <th>Toko</th>
                                            <th>Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $no = 1; foreach ($users as $user): ?>
                                                <tr>
                                                    <td class="text-center"><?= $no++ ?></td>
                                                    <td><?= esc($user['nama']) ?></td>
                                                    <td><?= esc($user['username']) ?></td>
                                                    <td><?= esc($user['no_hp']) ?></td>
                                                    <td><?= esc($user['nama_toko']) ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-show-<?= $user['id'] ?>">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <!-- Tombol untuk membuka modal edit -->
                                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-edit-<?= $user['id'] ?>">
                                                            <i class="fas fa-edit"></i>
                                                        </button>

                                                        <!-- Form untuk menghapus supplier -->
                                                        <form action="<?= site_url('/admin/pengguna/delete/' . $user['id']) ?>" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus toko ini?')">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?= view('components/modal', [
        'id' => 'modal-create',
        'title' => 'Tambah Pengguna',
        'slot' => view('pages/pengguna/form-create')
    ]) ?>

    
    <?php foreach ($users as $user): ?>
        <?= view('components/modal', [
            'id' => 'modal-show-' . $user['id'],
            'title' => 'Detail Pengguna',
            'size' => 'modal-lg',
            'slot' => view('pages/pengguna/show', ['user' => $user])
        ]) ?>
    <?php endforeach; ?>
    
    <?php foreach ($users as $user): ?>
        <?= view('components/modal', [
            'id' => 'modal-edit-' . $user['id'],
            'title' => 'Perbarui Pengguna',
            'size' => 'modal-lg',
            'slot' => view('pages/pengguna/form-edit', ['user' => $user])
        ]) ?>
    <?php endforeach; ?>

<?= $this->endSection() ?>

