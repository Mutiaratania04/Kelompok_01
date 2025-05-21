<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Data Barang</title>
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
          <li class="nav-item"><a class="nav-link active" href="#">Barang</a></li>
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
    <h3 class="mb-4 text-center">Data Barang</h3>
    <div class="table-responsive">
      <table class="table table-bordered table-hover shadow-sm bg-white">
        <thead class="table-light text-center">
          <tr>
            <th>Kode</th>
            <th>Nama Barang</th>
            <th>Harga (Rp)</th>
            <th>Jumlah</th>
            <th>Stok Minimal</th>
            <th>Supplier</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $query = mysqli_query($conn, "
              SELECT barang.*, supplier.nama_sup 
              FROM barang
              LEFT JOIN supplier ON barang.id_sup = supplier.id_sup
            ");
            if (mysqli_num_rows($query) > 0) {
              while ($row = mysqli_fetch_assoc($query)) {
                echo "<tr>";
                echo "<td class='text-center'>" . $row['kode_brg'] . "</td>";
                echo "<td>" . $row['nama_brg'] . "</td>";
                echo "<td class='text-end'>" . number_format($row['harga_brg'], 2, ',', '.') . "</td>";
                echo "<td class='text-center'>" . $row['jumlah_brg'] . "</td>";
                echo "<td class='text-center'>" . $row['stok_minimal'] . "</td>";
                echo "<td>" . ($row['nama_sup'] ?? '-') . "</td>";
                echo "</tr>";
              }
            } else {
              echo "<tr><td colspan='6' class='text-center text-muted'>Tidak ada data barang.</td></tr>";
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
