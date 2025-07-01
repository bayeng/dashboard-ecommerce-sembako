<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title> <?= $this->renderSection('title') ?> &mdash; Saktoko</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?= base_url('assets/modules/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/modules/fontawesome/css/all.min.css') ?>">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="<?= base_url('assets/modules/jqvmap/dist/jqvmap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/modules/weather-icon/css/weather-icons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/modules/weather-icon/css/weather-icons-wind.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/modules/summernote/summernote-bs4.css') ?>">

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/components.css') ?>">

    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->
</head>

<body>

    <div id="app">
        <div class="main-wrapper">

            <!-- Header -->
            <?= view('components/header') ?>

            <!-- Sidebar -->
            <?= view('components/sidebar') ?>

            <!-- Content -->
            <?= $this->renderSection('main') ?>

            <!-- Footer -->
            <?= view('components/footer') ?>
        </div>
    </div>

    <!-- script -->

    <!-- Scripts -->
    <script src="<?= base_url('assets/modules/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/modules/popper.js') ?>"></script>
    <script src="<?= base_url('assets/modules/tooltip.js') ?>"></script>
    <script src="<?= base_url('assets/modules/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('assets/modules/nicescroll/jquery.nicescroll.min.js') ?>"></script>
    <script src="<?= base_url('assets/modules/moment.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/stisla.js') ?>"></script>

    <!-- JS Libraries -->
    <script src="<?= base_url('assets/modules/simple-weather/jquery.simpleWeather.min.js') ?>"></script>
    <script src="<?= base_url('assets/modules/chart.min.js') ?>"></script>
    <script src="<?= base_url('assets/modules/jqvmap/dist/jquery.vmap.min.js') ?>"></script>
    <script src="<?= base_url('assets/modules/jqvmap/dist/maps/jquery.vmap.world.js') ?>"></script>
    <script src="<?= base_url('assets/modules/summernote/summernote-bs4.js') ?>"></script>
    <script src="<?= base_url('assets/modules/chocolat/dist/js/jquery.chocolat.min.js') ?>"></script>

    <!-- Page Specific JS File -->
    <script src="<?= base_url('assets/js/page/index-0.js') ?>"></script>

    <!-- Template JS File -->
    <script src="<?= base_url('assets/js/scripts.js') ?>"></script>
    <script src="<?= base_url('assets/js/custom.js') ?>"></script>
    <?= $this->renderSection('script') ?>
</body>

</html>