CREATE DATABASE gudang;
USE gudang;

-- 1. Tabel Supplier (tidak bergantung pada tabel lain)
CREATE TABLE supplier (
    id_sup INT PRIMARY KEY AUTO_INCREMENT,
    nama_sup VARCHAR(50) NOT NULL,
    telp_sup VARCHAR(20) NOT NULL,
    alamat_sup VARCHAR(100) NOT NULL
);

-- 2. Tabel Barang (bergantung pada supplier)
CREATE TABLE barang (
    kode_brg INT PRIMARY KEY AUTO_INCREMENT,
    nama_brg VARCHAR(50) NOT NULL,
    harga_brg DECIMAL(12,2) NOT NULL, -- Menggunakan DECIMAL untuk harga
    jumlah_brg INT NOT NULL,
    id_sup INT,
    stok_minimal INT DEFAULT 5,
    FOREIGN KEY (id_sup) REFERENCES supplier(id_sup) ON DELETE SET NULL
);

-- 3. Tabel Pelanggan (tidak bergantung pada tabel lain)
CREATE TABLE pelanggan (
    id_plg INT PRIMARY KEY AUTO_INCREMENT,
    nama_plg VARCHAR(50) NOT NULL,
    telp_plg VARCHAR(20) NOT NULL,
    jk_plg ENUM('Laki-laki', 'Perempuan') NOT NULL,
    alamat_plg VARCHAR(100) NOT NULL,
    email_plg VARCHAR(100)
);

-- 4. Tabel Pembayaran (tidak bergantung pada tabel lain)
CREATE TABLE pembayaran (
    id_byr INT PRIMARY KEY AUTO_INCREMENT,
    metode_byr ENUM('Tunai', 'Transfer', 'Kartu Kredit', 'E-Wallet') NOT NULL,
    status_byr ENUM('Pending', 'Lunas', 'Gagal') DEFAULT 'Pending'
);

-- 5. Tabel Transaksi (bergantung pada pelanggan dan pembayaran)
CREATE TABLE transaksi (
    id_tran INT PRIMARY KEY AUTO_INCREMENT,
    waktu_tran DATETIME NOT NULL,
    id_plg INT NOT NULL,
    id_byr INT NOT NULL,
    status_tran ENUM('Draft', 'Diproses', 'Selesai', 'Dibatalkan') DEFAULT 'Draft',
    total_tran DECIMAL(12,2) NOT NULL,
    keterangan TEXT,
    FOREIGN KEY (id_plg) REFERENCES pelanggan(id_plg) ON DELETE CASCADE,
    FOREIGN KEY (id_byr) REFERENCES pembayaran(id_byr) ON DELETE CASCADE
);

-- 6. Tabel Detail Transaksi (many-to-many antara transaksi dan barang)
CREATE TABLE detail_transaksi (
    id_detail INT PRIMARY KEY AUTO_INCREMENT,
    id_tran INT NOT NULL,
    kode_brg INT NOT NULL,
    jumlah INT NOT NULL,
    harga_satuan DECIMAL(12,2) NOT NULL,
    subtotal DECIMAL(12,2) GENERATED ALWAYS AS (jumlah * harga_satuan) STORED,
    FOREIGN KEY (id_tran) REFERENCES transaksi(id_tran) ON DELETE CASCADE,
    FOREIGN KEY (kode_brg) REFERENCES barang(kode_brg) ON DELETE RESTRICT
);

-- 7. Tabel Pemasokan (many-to-many antara supplier dan barang)
CREATE TABLE pemasokan (
    id_pemasokan INT PRIMARY KEY AUTO_INCREMENT,
    id_sup INT NOT NULL,
    kode_brg INT NOT NULL,
    jumlah INT NOT NULL,
    harga_beli DECIMAL(12,2) NOT NULL,
    tgl_pemasokan DATE NOT NULL,
    FOREIGN KEY (id_sup) REFERENCES supplier(id_sup) ON DELETE CASCADE,
    FOREIGN KEY (kode_brg) REFERENCES barang(kode_brg) ON DELETE RESTRICT
);

-- 1. Supplier (Pemasok)
INSERT INTO supplier (nama_sup, telp_sup, alamat_sup) VALUES
('PT Logistik Elektronik', '02155667788', 'Jl. Industri Raya No.12, Jakarta'),
('CV Sinar Gadget', '02277889900', 'Jl. Teknologi No.45, Bandung'),
('UD Barokah Elektronik', '03111223344', 'Jl. Pahlawan No.78, Surabaya'),
('Toko Sumber Komponen', '06122334455', 'Jl. Perdagangan No.56, Medan'),
('Supplier Global Parts', '02455667788', 'Jl. Modern No.34, Semarang');

-- 2. Barang (Inventory Gudang)
INSERT INTO barang (nama_brg, harga_brg, jumlah_brg, id_sup, stok_minimal) VALUES
('Kabel HDMI 2m', 75000, 120, 1, 50),
('Adaptor Charger 65W', 150000, 85, 2, 30),
('Baterai Laptop 5000mAh', 300000, 45, 3, 20),
('SSD 512GB SATA', 600000, 38, 4, 15),
('RAM DDR4 8GB', 400000, 52, 5, 20);

-- 3. Pemasokan (Stock Opname)
INSERT INTO pemasokan (id_sup, kode_brg, jumlah, harga_beli, tgl_pemasokan) VALUES
(1, 1, 100, 50000, '2023-11-01'),
(2, 2, 50, 120000, '2023-11-05'),
(3, 3, 30, 250000, '2023-11-10'),
(4, 4, 25, 500000, '2023-11-15'),
(5, 5, 40, 350000, '2023-11-20');

-- 4. Pelanggan (Minimal untuk relasi)
INSERT INTO pelanggan (nama_plg, telp_plg, jk_plg, alamat_plg) VALUES
('Budi Santoso', '08111222333', 'Laki-laki', 'Jl. Mangga No.5, Jakarta'),
('Ani Wijaya', '08222333444', 'Perempuan', 'Jl. Melati No.10, Bandung'),
('Citra Dewi', '08333444555', 'Perempuan', 'Jl. Anggrek No.15, Surabaya'),
('Dodi Pratama', '08444555666', 'Laki-laki', 'Jl. Kenanga No.20, Medan'),
('Eka Putri', '08555666777', 'Perempuan', 'Jl. Flamboyan No.25, Yogyakarta');

-- 5. Pembayaran (Minimal untuk relasi)
INSERT INTO pembayaran (metode_byr, status_byr) VALUES
('Tunai', 'Lunas'),
('Transfer', 'Lunas'),
('Kartu Kredit', 'Pending'),
('E-Wallet', 'Lunas'),
('Transfer', 'Gagal');

-- 6. Transaksi (Contoh pengeluaran barang)
INSERT INTO transaksi (waktu_tran, id_plg, id_byr, status_tran, total_tran) VALUES
('2023-12-01 10:00:00', 1, 1, 'Selesai', 225000),  -- 3x Kabel HDMI
('2023-12-02 11:30:00', 2, 2, 'Selesai', 300000),  -- 2x Adaptor
('2023-12-03 14:15:00', 3, 3, 'Diproses', 600000), -- 2x RAM
('2023-12-04 16:45:00', 4, 4, 'Selesai', 600000),  -- 1x SSD
('2023-12-05 09:30:00', 5, 5, 'Dibatalkan', 150000); -- 1x Adaptor

-- 7. Detail Transaksi (Barang keluar dari gudang)
INSERT INTO detail_transaksi (id_tran, kode_brg, jumlah, harga_satuan) VALUES
(1, 1, 3, 75000),   -- Kabel HDMI
(2, 2, 2, 150000),  -- Adaptor
(3, 5, 2, 300000),  -- RAM (harga promo)
(4, 4, 1, 600000),  -- SSD
(5, 2, 1, 150000);   -- Adaptor (dibatalkan)

-- ----------------------------------------- projek akhir

USE gudang;

-- =========================
-- 5 VIEW (dengan JOIN & kondisi)
-- =========================

-- View 1: Stok barang dan supplier
CREATE VIEW view_stok_barang AS
SELECT b.kode_brg, b.nama_brg, b.jumlah_brg, b.stok_minimal, s.nama_sup
FROM barang b
JOIN supplier s ON b.id_sup = s.id_sup;

SELECT * FROM view_stok_barang;

-- View 2: Transaksi lengkap
CREATE VIEW view_transaksi_lengkap AS
SELECT t.id_tran, t.waktu_tran, p.nama_plg, pb.metode_byr, pb.status_byr, t.total_tran
FROM transaksi t
JOIN pelanggan p ON t.id_plg = p.id_plg
JOIN pembayaran pb ON t.id_byr = pb.id_byr;

SELECT * FROM view_transaksi_lengkap;

-- View 3: Barang dengan stok rendah (Seleksi Kondisi)
CREATE VIEW view_barang_stok_kritis AS
SELECT kode_brg, nama_brg, jumlah_brg, stok_minimal
FROM barang
WHERE jumlah_brg < stok_minimal;

UPDATE barang SET jumlah_brg = 10 WHERE kode_brg = 3;

SELECT * FROM view_barang_stok_kritis;

-- View 4: Detail transaksi dan nama barang
CREATE VIEW view_detail_transaksi AS
SELECT dt.id_tran, b.nama_brg, dt.jumlah, dt.harga_satuan, dt.subtotal
FROM detail_transaksi dt
JOIN barang b ON dt.kode_brg = b.kode_brg;

SELECT * FROM view_detail_transaksi;

-- View 5: Pemasokan lengkap
CREATE VIEW view_pemasokan_lengkap AS
SELECT p.id_pemasokan, s.nama_sup, b.nama_brg, p.jumlah, p.harga_beli, p.tgl_pemasokan
FROM pemasokan p
JOIN supplier s ON p.id_sup = s.id_sup
JOIN barang b ON p.kode_brg = b.kode_brg;

SELECT * FROM view_pemasokan_lengkap;

-- =========================
-- 5 STORED PROCEDURE (dengan parameter & loop)
-- =========================

-- SP 1: Tambah stok barang dari pemasokan (looping)
DELIMITER //
CREATE PROCEDURE tambah_stok_dari_pemasokan()
BEGIN
  DECLARE done INT DEFAULT 0;
  DECLARE brg_id INT;
  DECLARE jml INT;
  DECLARE cur CURSOR FOR SELECT kode_brg, jumlah FROM pemasokan;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

  OPEN cur;
  read_loop: LOOP
    FETCH cur INTO brg_id, jml;
    IF done THEN
      LEAVE read_loop;
    END IF;
    UPDATE barang SET jumlah_brg = jumlah_brg + jml WHERE kode_brg = brg_id;
  END LOOP;
  CLOSE cur;
END;
//
DELIMITER ;

CALL tambah_stok_dari_pemasokan();

-- SP 2: Cek stok barang tertentu
DELIMITER //
CREATE PROCEDURE cek_stok_barang(IN kode INT)
BEGIN
  SELECT nama_brg, jumlah_brg, stok_minimal
  FROM barang
  WHERE kode_brg = kode;
END;
//
DELIMITER ;

CALL cek_stok_barang(3);

-- SP 3: Tampilkan transaksi berdasarkan pelanggan
DELIMITER //
CREATE PROCEDURE transaksi_per_pelanggan(IN id INT)
BEGIN
  SELECT t.id_tran, t.waktu_tran, t.total_tran, t.status_tran
  FROM transaksi t
  WHERE t.id_plg = id;
END;
//
DELIMITER ;

CALL transaksi_per_pelanggan(2);

-- SP 4: Hitung total transaksi selesai
DELIMITER //
CREATE PROCEDURE total_transaksi_selesai(OUT total DECIMAL(12,2))
BEGIN
  SELECT SUM(total_tran) INTO total
  FROM transaksi
  WHERE status_tran = 'Selesai';
END;
//
DELIMITER ;

-- Siapkan variabel untuk output
SET @total_selesai = 0;

-- Panggil prosedur dengan parameter OUT
CALL total_transaksi_selesai(@total_selesai);

-- Tampilkan hasilnya
SELECT @total_selesai AS total_transaksi_selesai;

-- SP 5: Update status transaksi (by ID)
DELIMITER //
CREATE PROCEDURE ubah_status_transaksi(IN id INT, IN status_baru ENUM('Draft','Diproses','Selesai','Dibatalkan'))
BEGIN
  UPDATE transaksi
  SET status_tran = status_baru
  WHERE id_tran = id;
END;
//
DELIMITER ;

CALL ubah_status_transaksi(3, 'Selesai');

-- =========================
-- TRIGGER (INSERT, UPDATE, DELETE)
-- =========================

-- Trigger INSERT: Log penambahan barang
CREATE TABLE log_barang (
  id_log INT AUTO_INCREMENT PRIMARY KEY,
  kode_brg INT,
  aksi VARCHAR(10),
  waktu TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DELIMITER //
CREATE TRIGGER trg_insert_barang
AFTER INSERT ON barang
FOR EACH ROW
BEGIN
  INSERT INTO log_barang(kode_brg, aksi) VALUES (NEW.kode_brg, 'INSERT');
END;
//
DELIMITER ;

-- Trigger UPDATE: Log perubahan jumlah stok
DELIMITER //
CREATE TRIGGER trg_update_stok
AFTER UPDATE ON barang
FOR EACH ROW
BEGIN
  IF NEW.jumlah_brg <> OLD.jumlah_brg THEN
    INSERT INTO log_barang(kode_brg, aksi) VALUES (NEW.kode_brg, 'UPDATE');
  END IF;
END;
//
DELIMITER ;

-- Trigger DELETE: Log penghapusan barang
DELIMITER //
CREATE TRIGGER trg_delete_barang
AFTER DELETE ON barang
FOR EACH ROW
BEGIN
  INSERT INTO log_barang(kode_brg, aksi) VALUES (OLD.kode_brg, 'DELETE');
END;
//
DELIMITER ;

-- Contoh INSERT barang baru
INSERT INTO barang (nama_brg, harga_brg, jumlah_brg, id_sup) VALUES ('Mouse Wireless', 120000, 10, 1);

-- Cek log
SELECT * FROM log_barang ORDER BY waktu DESC;

-- Contoh UPDATE jumlah barang
UPDATE barang SET jumlah_brg = jumlah_brg + 5 WHERE nama_brg = 'Mouse Wireless';

-- Cek log lagi
SELECT * FROM log_barang ORDER BY waktu DESC;

-- Contoh DELETE barang
DELETE FROM barang WHERE nama_brg = 'Mouse Wireless';

-- Cek log terakhir
SELECT * FROM log_barang ORDER BY waktu DESC;
