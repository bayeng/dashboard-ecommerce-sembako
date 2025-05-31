<?php $role = session()->get('role'); ?>
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Dashboard</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header bold">Admin Gudang</li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="index-0.html">General Dashboard</a></li>
                    <li><a class="nav-link" href="index.html">Ecommerce Dashboard</a></li>
                </ul>
            </li>
            <?php if ($role === 'admin'): ?>
                <li class="menu-header">Admin Gudang</li>
                <li class="nav"><a class="nav-link" href="/toko"><i class="fa fa-store"></i> <span>Toko</span></a></li>
                <li class="nav"><a class="nav-link" href="/supplier"><i class="fa fa-truck"></i> <span>Supplier</span></a></li>
                <li class="nav"><a class="nav-link" href="/produk-mentah"><i class="fa fa-box-open"></i> <span>Produk Mentah</span></a></li>
                <li class="nav"><a class="nav-link" href="/produk-gudang"><i class="fa fa-box"></i> <span>Produk Gudang</span></a></li>
                <li class="nav"><a class="nav-link" href="/kategori-gudang"><i class="fa fa-tag"></i> <span>Kategori Produk</span></a></li>
                <li class="nav"><a class="nav-link" href="/pengguna"><i class="fa fa-user"></i> <span>Pengguna</span></a></li>
                <li class="nav"><a class="nav-link" href="blank.html"><i class="far fa-square"></i> <span>Blank Page</span></a></li>
            <?php endif; ?>
            <?php if ($role === 'penjual'): ?>
                <li class="menu-header">Admin Toko</li>
                <li class="nav"><a class="nav-link" href="/produk"><i class="fa fa-box"></i> <span>Produk</span></a></li>
            <?php endif; ?>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-th"></i> <span>Bootstrap</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="<?= base_url('bootstrap-alert.html') ?>">Alert</a></li>
                    <li><a class="nav-link" href="bootstrap-badge.html">Badge</a></li>
                    <li><a class="nav-link" href="bootstrap-breadcrumb.html">Breadcrumb</a></li>
                    <li><a class="nav-link" href="bootstrap-buttons.html">Buttons</a></li>
                    <li><a class="nav-link" href="bootstrap-card.html">Card</a></li>
                    <li><a class="nav-link" href="bootstrap-carousel.html">Carousel</a></li>
                    <li><a class="nav-link" href="bootstrap-collapse.html">Collapse</a></li>
                    <li><a class="nav-link" href="bootstrap-dropdown.html">Dropdown</a></li>
                    <li><a class="nav-link" href="bootstrap-form.html">Form</a></li>
                    <li><a class="nav-link" href="bootstrap-list-group.html">List Group</a></li>
                    <li><a class="nav-link" href="bootstrap-media-object.html">Media Object</a></li>
                    <li><a class="nav-link" href="bootstrap-modal.html">Modal</a></li>
                    <li><a class="nav-link" href="bootstrap-nav.html">Nav</a></li>
                    <li><a class="nav-link" href="bootstrap-navbar.html">Navbar</a></li>
                    <li><a class="nav-link" href="bootstrap-pagination.html">Pagination</a></li>
                    <li><a class="nav-link" href="bootstrap-popover.html">Popover</a></li>
                    <li><a class="nav-link" href="bootstrap-progress.html">Progress</a></li>
                    <li><a class="nav-link" href="bootstrap-table.html">Table</a></li>
                    <li><a class="nav-link" href="bootstrap-tooltip.html">Tooltip</a></li>
                    <li><a class="nav-link" href="bootstrap-typography.html">Typography</a></li>
                </ul>
            </li>
    </aside>
</div>

<?= $this->section('script') ?>
<script>
    let pathname = window.location.pathname;
    const navItems = document.querySelectorAll('li.nav');

    navItems.forEach(item => {
        const link = item.querySelector('a.nav-link');
        if (link) {
            const linkPath = link.getAttribute('href');
            if (pathname === linkPath || pathname.startsWith(linkPath)) {
                item.classList.add('active');
            }
        }
    });
</script>
<?= $this->endSection() ?>