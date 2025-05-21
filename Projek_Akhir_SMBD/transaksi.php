<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Data Transaksi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <style>
    body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    .navbar-brand { font-weight: 600; font-size: 1.5rem; }
    footer { text-align: center; padding: 1rem; margin-top: 2rem; color: #6c757d; font-size: 0.9rem; }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
    <div class="container">
      <a class="navbar-brand" href="index.php">Gudang Elektronik</a>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="supplier.php">Supplier</a></li>
          <li class="nav-item"><a class="nav-link" href="barang.php">Barang</a></li>
          <li class="nav-item"><a class="nav-link" href="pelanggan.php">Pelanggan</a></li>
          <li class="nav-item"><a class="nav-link" href="pembayaran.php">Pembayaran</a></li>
          <li class="nav-item"><a class="nav-link active" href="#">Transaksi</a></li>
          <li class="nav-item"><a class="nav-link" href="detail.php">Detail</a></li>
          <li class="nav-item"><a class="nav-link" href="pemasokan.php">Pemasokan</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">
    <h3 class="mb-4 text-center">Data Transaksi</h3>
    <div class="table-responsive shadow-sm rounded">
      <table class="table table-bordered table-hover bg-white">
        <thead class="table-light text-center">
          <tr>
            <th>ID</th>
            <th>Waktu</th>
            <th>Pelanggan</th>
            <th>Pembayaran</th>
            <th>Status</th>
            <th>Total</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $res = $conn->query("SELECT t.*, p.nama_plg, b.metode_byr 
                               FROM transaksi t 
                               JOIN pelanggan p ON t.id_plg = p.id_plg 
                               JOIN pembayaran b ON t.id_byr = b.id_byr");
          while($row = $res->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id_tran']}</td>
                    <td>{$row['waktu_tran']}</td>
                    <td>{$row['nama_plg']}</td>
                    <td>{$row['metode_byr']}</td>
                    <td>{$row['status_tran']}</td>
                    <td>Rp " . number_format($row['total_tran'], 0, ',', '.') . "</td>
                    <td>{$row['keterangan']}</td>
                  </tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <footer class="mt-5">
    &copy; 2025 Sistem Gudang Elektronik. Dibuat untuk Proyek SMBD.
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
