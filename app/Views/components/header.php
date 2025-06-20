<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li>
                <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="<?= base_url('assets/img/avatar/avatar-1.png') ?>" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block"><?= esc(session()->get('nama')) ?></div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <form action="<?= site_url('auth/logout') ?>" method="post" style="display: inline;">
                    <?= csrf_field() ?>
                    <button type="submit" class="dropdown-item has-icon text-danger" style="border: none; background: none; cursor: pointer;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>

