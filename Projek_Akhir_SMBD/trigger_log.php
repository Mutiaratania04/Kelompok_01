<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Log Trigger</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .navbar-brand {
      font-weight: 600;
      font-size: 1.5rem;
    }
    footer {
      text-align: center;
      padding: 1rem;
      margin-top: 2rem;
      color: #6c757d;
      font-size: 0.9rem;
    }
    .card {
      border: none;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
    <div class="container">
      <a class="navbar-brand" href="index.php">Gudang Elektronik</a>
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
    <div class="card p-4">
      <h2 class="text-center mb-4">Log Aksi Barang</h2>

      <div class="d-flex justify-content-end mb-3">
        <form method="GET" class="d-flex">
          <label class="me-2 fw-semibold">Filter Aksi:</label>
          <select name="aksi" class="form-select me-2" onchange="this.form.submit()">
            <option value="">Semua</option>
            <option value="INSERT" <?= isset($_GET['aksi']) && $_GET['aksi'] == 'INSERT' ? 'selected' : '' ?>>INSERT</option>
            <option value="UPDATE" <?= isset($_GET['aksi']) && $_GET['aksi'] == 'UPDATE' ? 'selected' : '' ?>>UPDATE</option>
            <option value="DELETE" <?= isset($_GET['aksi']) && $_GET['aksi'] == 'DELETE' ? 'selected' : '' ?>>DELETE</option>
          </select>
        </form>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered align-middle">
          <thead class="table-light">
            <tr>
              <th>ID Log</th>
              <th>Kode Barang</th>
              <th>Aksi</th>
              <th>Waktu</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $filter = '';
              if (isset($_GET['aksi']) && in_array($_GET['aksi'], ['INSERT', 'UPDATE', 'DELETE'])) {
                $aksi = $conn->real_escape_string($_GET['aksi']);
                $filter = "WHERE aksi = '$aksi'";
              }

              $res = $conn->query("SELECT * FROM log_barang $filter ORDER BY waktu DESC");
              if ($res->num_rows > 0) {
                while($row = $res->fetch_assoc()) {
                  echo "<tr>
                          <td>{$row['id_log']}</td>
                          <td>{$row['kode_brg']}</td>
                          <td>{$row['aksi']}</td>
                          <td>{$row['waktu']}</td>
                        </tr>";
                }
              } else {
                echo "<tr><td colspan='4' class='text-center text-muted'>Tidak ada data log.</td></tr>";
              }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="container my-4">
    <a href="index.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
  </div>

  <footer class="mt-5">
    &copy; 2025 Sistem Gudang Elektronik. Dibuat untuk Proyek SMBD.
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
