<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard E-Commerce</title>

  <link rel="stylesheet" href="<?= base_url('assets/modules/bootstrap/css/bootstrap.min.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/modules/fontawesome/css/all.min.css') ?>" />

  <style>
    html,
    body {
      margin: 0;
      padding: 0;
      height: 100%;
    }

    body {
      background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)),
        url('<?= base_url('assets/img/unsplash/background.jpg'); ?>') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', sans-serif;
    }

    .glass-card {
      background: rgba(255, 255, 255, 0.15);
      border-radius: 16px;
      padding: 3rem 2rem;
      text-align: center;
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
      color: #fff;
      width: 90%;
      max-width: 500px;
    }

    .glass-card h1 {
      font-size: 2.8rem;
      font-weight: 800;
    }

    .glass-card p {
      font-size: 1.5rem;
      font-weight: 500;
    }

    .btn-custom {
      padding: 0.75rem 2rem;
      font-size: 1.1rem;
      border-radius: 50px;
      transition: all 0.3s ease;
    }

    .btn-custom:hover {
      background-color: #fff;
      color: #000;
      border-color: #fff;
    }

    @media (max-width: 576px) {
      .glass-card h1 {
        font-size: 2rem;
      }

      .glass-card p {
        font-size: 1.2rem;
      }
    }
  </style>
</head>

<body>
  <div class="glass-card">
    <p>Selamat Datang</p>
    <h1>Dashboard Saktoko</h1>
    <a href="/login" class="btn btn-outline-light btn-custom mt-4">Masuk</a>
  </div>

  <script src="<?= base_url('assets/modules/bootstrap/js/bootstrap.min.js') ?>"></script>
</body>

</html>
