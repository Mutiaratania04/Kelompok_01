<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Gudang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .navbar-brand {
      font-weight: 600;
      font-size: 1.5rem;
    }
    .card {
      transition: all 0.2s ease-in-out;
      min-height: 160px;
    }
    .card:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
    }
    .card i {
      font-size: 2rem;
      color: #0d6efd;
    }
    footer {
      text-align: center;
      padding: 1rem;
      margin-top: 2rem;
      color: #6c757d;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
    <div class="container">
      <a class="navbar-brand" href="#">Gudang Elektronik</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="supplier.php">Supplier</a></li>
          <li class="nav-item"><a class="nav-link" href="barang.php">Barang</a></li>
          <li class="nav-item"><a class="nav-link" href="pelanggan.php">Pelanggan</a></li>
          <li class="nav-item"><a class="nav-link" href="pembayaran.php">Pembayaran</a></li>
          <li class="nav-item"><a class="nav-link" href="transaksi.php">Transaksi</a></li>
          <li class="nav-item"><a class="nav-link" href="detail.php">Detail</a></li>
          <li class="nav-item"><a class="nav-link" href="pemasokan">Pemasokan</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">
    <h2 class="mb-4 text-center">Selamat Datang di Sistem Gudang</h2>

    <div class="row g-4 justify-content-center">

      <div class="col-10 col-sm-6 col-lg-5">
        <div class="card p-4 shadow-sm h-100">
            <div class="d-flex align-items-center justify-content-center h-100">
            <div class="d-flex align-items-center">
                <i class="fas fa-boxes me-3" style="font-size: 2rem; color: #0d6efd;"></i>
                <div>
                <h5 class="mb-0">Data Barang</h5>
                <a href="data_barang.php" class="stretched-link"></a>
                </div>
            </div>
            </div>
        </div>
      </div>


      <div class="col-10 col-sm-6 col-lg-5">
        <div class="card p-4 shadow-sm h-100">
            <div class="d-flex align-items-center justify-content-center h-100">
            <div class="d-flex align-items-center">
                <i class="fas fa-truck me-3" style="font-size: 2rem; color: #0d6efd;"></i>
                <div>
                <h5 class="mb-0">Log Barang</h5>
                <a href="trigger_log.php" class="stretched-link"></a>
                </div>
            </div>
            </div>
        </div>
        </div>

        <div class="col-10 col-sm-6 col-lg-5">
        <div class="card p-4 shadow-sm h-100">
            <div class="d-flex align-items-center justify-content-center h-100">
            <div class="d-flex align-items-center">
                <i class="fas fa-file-alt me-3" style="font-size: 2rem; color: #0d6efd;"></i>
                <div>
                <h5 class="mb-0">Laporan</h5>
                <a href="view.php" class="stretched-link"></a>
                </div>
            </div>
            </div>
        </div>
        </div>

        <div class="col-10 col-sm-6 col-lg-5">
        <div class="card p-4 shadow-sm h-100">
            <div class="d-flex align-items-center justify-content-center h-100">
            <div class="d-flex align-items-center">
                <i class="fas fa-database me-3" style="font-size: 2rem; color: #0d6efd;"></i>
                <div>
                <h5 class="mb-0">Stored Procedure</h5>
                <a href="procedure.php" class="stretched-link"></a>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
  </div>

  <footer class="mt-5">
    &copy; 2025 Sistem Gudang Elektronik. Dibuat untuk Proyek SMBD.
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
