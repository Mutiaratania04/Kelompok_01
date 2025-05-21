<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Stored Procedure - Gudang Elektronik</title>
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
    .card {
      margin-bottom: 1.5rem;
    }
    footer {
      text-align: center;
      padding: 1rem;
      color: #6c757d;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
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
    <h1 class="mb-4">Stored Procedure - Gudang Elektronik</h1>

    <!-- 1. Tambah Stok dari Pemasokan -->
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">1. Tambah Stok dari Pemasokan (looping)</h5>
        <form method="post">
          <button type="submit" name="tambah_stok" class="btn btn-primary">Jalankan SP</button>
        </form>
        <?php
        if (isset($_POST['tambah_stok'])) {
          mysqli_query($conn, "CALL tambah_stok_dari_pemasokan()");
          echo "<div class='alert alert-success mt-2'>Stok berhasil ditambahkan dari data pemasokan.</div>";
        }
        ?>
      </div>
    </div>

    <!-- 2. Cek Stok Barang -->
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">2. Cek Stok Barang</h5>
        <form method="post" class="row g-2">
          <div class="col-auto">
            <input type="number" name="kode_brg" class="form-control" placeholder="Kode Barang" required>
          </div>
          <div class="col-auto">
            <button type="submit" name="cek_stok" class="btn btn-info">Cek</button>
          </div>
        </form>
        <?php
        if (isset($_POST['cek_stok'])) {
          $kode = $_POST['kode_brg'];
          $result = mysqli_query($conn, "CALL cek_stok_barang($kode)");
          if ($result && mysqli_num_rows($result) > 0) {
            echo "<table class='table table-bordered mt-3'><tr><th>Nama</th><th>Jumlah</th><th>Stok Minimal</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr><td>{$row['nama_brg']}</td><td>{$row['jumlah_brg']}</td><td>{$row['stok_minimal']}</td></tr>";
            }
            echo "</table>";
          } else {
            echo "<div class='alert alert-warning mt-2'>Barang tidak ditemukan.</div>";
          }
          mysqli_next_result($conn);
        }
        ?>
      </div>
    </div>

    <!-- 3. Transaksi per Pelanggan -->
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">3. Transaksi per Pelanggan</h5>
        <form method="post" class="row g-2">
          <div class="col-auto">
            <input type="number" name="id_plg" class="form-control" placeholder="ID Pelanggan" required>
          </div>
          <div class="col-auto">
            <button type="submit" name="transaksi_plg" class="btn btn-secondary">Tampilkan</button>
          </div>
        </form>
        <?php
        if (isset($_POST['transaksi_plg'])) {
          $id = $_POST['id_plg'];
          $result = mysqli_query($conn, "CALL transaksi_per_pelanggan($id)");
          if ($result && mysqli_num_rows($result) > 0) {
            echo "<table class='table table-bordered mt-3'><tr><th>ID</th><th>Waktu</th><th>Total</th><th>Status</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr><td>{$row['id_tran']}</td><td>{$row['waktu_tran']}</td><td>{$row['total_tran']}</td><td>{$row['status_tran']}</td></tr>";
            }
            echo "</table>";
          } else {
            echo "<div class='alert alert-warning mt-2'>Tidak ada transaksi untuk ID tersebut.</div>";
          }
          mysqli_next_result($conn);
        }
        ?>
      </div>
    </div>

    <!-- 4. Total Transaksi Selesai -->
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">4. Total Transaksi Selesai</h5>
        <form method="post">
          <button type="submit" name="hitung_total" class="btn btn-success">Hitung</button>
        </form>
        <?php
        if (isset($_POST['hitung_total'])) {
          mysqli_query($conn, "SET @total_selesai = 0;");
          mysqli_query($conn, "CALL total_transaksi_selesai(@total_selesai);");
          $res = mysqli_query($conn, "SELECT @total_selesai AS total;");
          $row = mysqli_fetch_assoc($res);
          echo "<div class='alert alert-info mt-2'>Total transaksi selesai: <strong>Rp " . number_format($row['total'], 0, ',', '.') . "</strong></div>";
        }
        ?>
      </div>
    </div>

    <!-- 5. Ubah Status Transaksi -->
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">5. Ubah Status Transaksi</h5>
        <form method="post" class="row g-2">
          <div class="col-md-3">
            <input type="number" name="id_tran" class="form-control" placeholder="ID Transaksi" required>
          </div>
          <div class="col-md-3">
            <select name="status_baru" class="form-select" required>
              <option value="">Pilih Status</option>
              <option value="Draft">Draft</option>
              <option value="Diproses">Diproses</option>
              <option value="Selesai">Selesai</option>
              <option value="Dibatalkan">Dibatalkan</option>
            </select>
          </div>
          <div class="col-auto">
            <button type="submit" name="ubah_status" class="btn btn-warning">Ubah</button>
          </div>
        </form>
        <?php
        if (isset($_POST['ubah_status'])) {
          $id = $_POST['id_tran'];
          $status = $_POST['status_baru'];
          mysqli_query($conn, "CALL ubah_status_transaksi($id, '$status')");
          echo "<div class='alert alert-success mt-2'>Status transaksi berhasil diubah ke <strong>$status</strong>.</div>";
        }
        ?>
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
