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
            <?php if ($role === 'admin'): ?>
                <li class="nav"><a class="nav-link" href="/admin"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fa fa-box"></i> <span>Produk</span></a></a>
                    <ul class="dropdown-menu">
                        <li class="nav"><a class="nav-link" href="/admin/produk-gudang"><i class="fa fa-box"></i> <span>Produk</span></a></li>
                        <li class="nav"><a class="nav-link" href="/admin/pengemasan-stok"><i class="fa fa-box"></i> <span>Pengemasan Stok</span></a></li>
                        <li class="nav"><a class="nav-link" href="/admin/kategori"><i class="fa fa-tag"></i> <span>Kategori</span></a></li>
                    </ul>
                </li>
                <li class="nav"><a class="nav-link" href="/admin/toko"><i class="fa fa-store"></i> <span>Toko</span></a></li>
                <li class="nav"><a class="nav-link" href="/admin/resep"><i class="fa fa-utensils"></i> <span>Resep</span></a></li>
                <li class="nav"><a class="nav-link" href="/admin/supplier"><i class="fa fa-truck"></i> <span>Supplier</span></a></li>
<!--                <li class="nav"><a class="nav-link" href="/admin/kurir"><i class="fa fa-paper-plane"></i> <span>Kurir</span></a></li>-->
                <li class="nav"><a class="nav-link" href="/admin/pengguna"><i class="fa fa-user"></i> <span>Pengguna</span></a></li>
                <?php endif; ?>
                <?php if ($role === 'penjual'): ?>
                    <li class="nav"><a class="nav-link" href="/toko"><i class="fa fa-home"></i>Dashboard</a></li>
                    <li class="nav"><a class="nav-link" href="/toko/pesanan"><i class="fa fa-inbox"></i> <span>Pesanan</span></a></li>
                    <li class="nav"><a class="nav-link" href="/toko/produk"><i class="fa fa-box"></i> <span>Produk</span></a></li>
                    <li class="nav"><a class="nav-link" href="/toko/kategori"><i class="fa fa-tag"></i> <span>Kategori</span></a></li>
                    <li class="nav"><a class="nav-link" href="/toko/kurir"><i class="fa fa-paper-plane"></i> <span>Kurir</span></a></li>
            <?php endif; ?>
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
            if (pathname === linkPath) {
                item.classList.add('active');
            }
        }
    });
</script>
<?= $this->endSection() ?>