<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
    Hello
<?= $this->endSection() ?>

<?= $this->section('style') ?>
    <!-- CSS Libraries -->
<?= $this->endSection() ?>

<?= $this->section('main') ?>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>User</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">users</a></div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>List User</h4>
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
                                            <th class="text-center">No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <td><div class="sort-handler"><i></i></div>1</td>
                                            <td>yanto</td>
                                            <td>yanto@gmail.com</td>
                                            <td>Admin</td>
                                            <td>
                                                <div class="badge badge-success">
                                                    Aktif
                                                </div>
                                                <div class="badge badge-danger">
                                                    Nonaktif
                                                </div>
                                            </td>
                                            <td>
                                                <!-- Tombol untuk membuka modal edit -->
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-{{ $user->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <!-- Form untuk menghapus kategori -->
                                                <form action="{{ route('user.delete', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus user ini?')">

                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="mt-4 d-flex justify-content-center">
                               pagination code
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

<?= $this->endSection() ?>