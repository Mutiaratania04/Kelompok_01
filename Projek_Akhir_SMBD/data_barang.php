<?php
include 'koneksi.php';

// Tambah barang
if (isset($_POST['tambah'])) {
  $nama = $_POST['nama'];
  $harga = $_POST['harga'];
  $jumlah = $_POST['jumlah'];
  $sup = $_POST['supplier'];

  $conn->query("INSERT INTO barang (nama_brg, harga_brg, jumlah_brg, id_sup) 
                VALUES ('$nama', '$harga', '$jumlah', '$sup')");
  header("Location: barang.php");
}

// Edit barang
if (isset($_POST['ubah'])) {
  $kode = $_POST['kode'];
  $nama = $_POST['nama'];
  $harga = $_POST['harga'];
  $jumlah = $_POST['jumlah'];
  $sup = $_POST['supplier'];

  $conn->query("UPDATE barang SET nama_brg='$nama', harga_brg='$harga', jumlah_brg='$jumlah', id_sup='$sup' 
                WHERE kode_brg='$kode'");
  header("Location: barang.php");
}

// Hapus barang
if (isset($_GET['hapus'])) {
  $kode = $_GET['hapus'];
  $conn->query("DELETE FROM barang WHERE kode_brg='$kode'");
  header("Location: barang.php");
}
?>

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
    <h2 class="text-center mb-4">Data Barang</h2>
    <div class="row mb-3">
        <div class="col text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
            <i class="fas fa-plus"></i> Tambah Barang
            </button>
        </div>
    </div>

    <div class="table-responsive shadow-sm rounded">
      <table class="table table-bordered align-middle">
        <thead class="table-light">
          <tr>
            <th>Kode</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Supplier</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT b.kode_brg, b.nama_brg, b.harga_brg, b.jumlah_brg, s.nama_sup 
                  FROM barang b LEFT JOIN supplier s ON b.id_sup = s.id_sup";
          $result = $conn->query($sql);
          while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['kode_brg']}</td>
                    <td>{$row['nama_brg']}</td>
                    <td>Rp " . number_format($row['harga_brg'], 0, ',', '.') . "</td>
                    <td>{$row['jumlah_brg']}</td>
                    <td>{$row['nama_sup']}</td>
                    <td>
                      <button class='btn btn-sm btn-warning' data-bs-toggle='modal' data-bs-target='#editModal{$row['kode_brg']}'><i class='fas fa-edit'></i></button>
                      <a href='?hapus={$row['kode_brg']}' onclick='return confirm(\"Hapus barang ini?\")' class='btn btn-sm btn-danger'><i class='fas fa-trash'></i></a>
                    </td>
                  </tr>";

            // Modal Edit
            echo "<div class='modal fade' id='editModal{$row['kode_brg']}' tabindex='-1'>
                    <div class='modal-dialog'>
                      <div class='modal-content'>
                        <form method='POST'>
                          <div class='modal-header'><h5 class='modal-title'>Ubah Barang</h5></div>
                          <div class='modal-body'>
                            <input type='hidden' name='kode' value='{$row['kode_brg']}' />
                            <div class='mb-2'><label>Nama Barang</label>
                              <input type='text' name='nama' class='form-control' value='{$row['nama_brg']}' required>
                            </div>
                            <div class='mb-2'><label>Harga</label>
                              <input type='number' name='harga' class='form-control' value='{$row['harga_brg']}' required>
                            </div>
                            <div class='mb-2'><label>Jumlah</label>
                              <input type='number' name='jumlah' class='form-control' value='{$row['jumlah_brg']}' required>
                            </div>
                            <div class='mb-2'><label>Supplier</label>
                              <select name='supplier' class='form-control' required>";
                              $supRes = $conn->query("SELECT * FROM supplier");
                              while($sup = $supRes->fetch_assoc()) {
                                $sel = $sup['id_sup'] == $row['id_sup'] ? 'selected' : '';
                                echo "<option value='{$sup['id_sup']}' $sel>{$sup['nama_sup']}</option>";
                              }
                            echo "</select>
                            </div>
                          </div>
                          <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Batal</button>
                            <button type='submit' name='ubah' class='btn btn-primary'>Simpan Perubahan</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal Tambah -->
  <div class="modal fade" id="tambahModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="POST">
          <div class="modal-header"><h5 class="modal-title">Tambah Barang</h5></div>
          <div class="modal-body">
            <div class="mb-2"><label>Nama Barang</label>
              <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-2"><label>Harga</label>
              <input type="number" name="harga" class="form-control" required>
            </div>
            <div class="mb-2"><label>Jumlah</label>
              <input type="number" name="jumlah" class="form-control" required>
            </div>
            <div class="mb-2"><label>Supplier</label>
              <select name="supplier" class="form-control" required>
                <option value="">-- Pilih Supplier --</option>
                <?php
                $sup = $conn->query("SELECT * FROM supplier");
                while($s = $sup->fetch_assoc()) {
                  echo "<option value='{$s['id_sup']}'>{$s['nama_sup']}</option>";
                }
                ?>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
          </div>
        </form>
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
