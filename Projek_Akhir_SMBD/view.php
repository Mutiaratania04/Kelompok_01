<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Data View SQL - Gudang Elektronik</title>
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
    h1 {
      margin-top: 20px;
      margin-bottom: 30px;
      text-align: center;
    }
    footer {
      text-align: center;
      padding: 1rem;
      margin-top: 3rem;
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
    <h1>Data View Gudang Elektronik</h1>

    <?php
    // List of views and their queries
    $views = [
      [
        'title' => '1. View Stok Barang dan Supplier',
        'query' => "SELECT * FROM view_stok_barang",
        'headers' => ['Kode Barang', 'Nama Barang', 'Jumlah', 'Stok Minimal', 'Nama Supplier'],
        'columns' => ['kode_brg', 'nama_brg', 'jumlah_brg', 'stok_minimal', 'nama_sup']
      ],
      [
        'title' => '2. View Transaksi Lengkap',
        'query' => "SELECT * FROM view_transaksi_lengkap",
        'headers' => ['ID Transaksi', 'Waktu', 'Pelanggan', 'Metode Bayar', 'Status Bayar', 'Total'],
        'columns' => ['id_tran', 'waktu_tran', 'nama_plg', 'metode_byr', 'status_byr', 'total_tran']
      ],
      [
        'title' => '3. View Barang Stok Kritis',
        'query' => "SELECT * FROM view_barang_stok_kritis",
        'headers' => ['Kode Barang', 'Nama Barang', 'Jumlah', 'Stok Minimal'],
        'columns' => ['kode_brg', 'nama_brg', 'jumlah_brg', 'stok_minimal']
      ],
      [
        'title' => '4. View Detail Transaksi',
        'query' => "SELECT * FROM view_detail_transaksi",
        'headers' => ['ID Transaksi', 'Nama Barang', 'Jumlah', 'Harga Satuan', 'Subtotal'],
        'columns' => ['id_tran', 'nama_brg', 'jumlah', 'harga_satuan', 'subtotal']
      ],
      [
        'title' => '5. View Pemasokan Lengkap',
        'query' => "SELECT * FROM view_pemasokan_lengkap",
        'headers' => ['ID Pemasokan', 'Supplier', 'Barang', 'Jumlah', 'Harga Beli', 'Tanggal'],
        'columns' => ['id_pemasokan', 'nama_sup', 'nama_brg', 'jumlah', 'harga_beli', 'tgl_pemasokan']
      ]
    ];

    // Loop through each view
    foreach ($views as $view) {
      echo "<div class='card mb-4'>";
      echo "<div class='card-header bg-primary text-white fw-bold'>{$view['title']}</div>";
      echo "<div class='card-body'>";
      
      $query = mysqli_query($conn, $view['query']);
      if ($query && mysqli_num_rows($query) > 0) {
        echo "<div class='table-responsive'><table class='table table-bordered table-striped table-hover'>";
        echo "<thead><tr>";
        foreach ($view['headers'] as $header) {
          echo "<th>{$header}</th>";
        }
        echo "</tr></thead><tbody>";
        while ($row = mysqli_fetch_assoc($query)) {
          echo "<tr>";
          foreach ($view['columns'] as $col) {
            echo "<td>{$row[$col]}</td>";
          }
          echo "</tr>";
        }
        echo "</tbody></table></div>";
      } else {
        echo "<p class='text-muted fst-italic'>Tidak ada data pada {$view['title']}.</p>";
      }

      echo "</div></div>";
    }
    ?>

  </div>

  <div class="container my-4">
  <a href="index.php" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Kembali
  </a>
</div>


  <footer>
    &copy; 2025 Sistem Gudang Elektronik. Dibuat untuk Proyek SMBD.
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
