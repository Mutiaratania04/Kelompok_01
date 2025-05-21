<?php
// koneksi.php
$host = "localhost";
$user = "root";
$pass = "";
$db = "pa_smbd_gudang";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>