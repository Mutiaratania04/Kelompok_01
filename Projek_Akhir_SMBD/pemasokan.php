<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Data Pemasokan</title>
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
          <li class="nav-item"><a class="nav-link" href="transaksi.php">Transaksi</a></li>
          <li class="nav-item"><a class="nav-link" href="detail.php">Detail</a></li>
          <li class="nav-item"><a class="nav-link active" href="#">Pemasokan</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">
    <h3 class="mb-4 text-center">Data Pemasokan</h3>
    <div class="table-responsive shadow-sm rounded">
      <table class="table table-bordered table-hover bg-white">
        <thead class="table-light text-center">
          <tr>
            <th>ID</th>
            <th>Supplier</th>
            <th>Barang</th>
            <th>Jumlah</th>
            <th>Harga Beli</th>
            <th>Tanggal</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $res = $conn->query("SELECT p.*, s.nama_sup, b.nama_brg 
                               FROM pemasokan p
                               JOIN supplier s ON p.id_sup = s.id_sup
                               JOIN barang b ON p.kode_brg = b.kode_brg");
          while($row = $res->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id_pemasokan']}</td>
                    <td>{$row['nama_sup']}</td>
                    <td>{$row['nama_brg']}</td>
                    <td>{$row['jumlah']}</td>
                    <td>Rp " . number_format($row['harga_beli'], 0, ',', '.') . "</td>
                    <td>{$row['tgl_pemasokan']}</td>
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
