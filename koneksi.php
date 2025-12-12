<?php
$host = "localhost"; //alamat server database (biasanya localhost)
$username = "root"; //username untuk login ke database
$password = ""; //password untuk login (biasanya kosong untuk localhost)
$dbname = "db_penjualan"; //nama database yang ingin diakses

//membuat koneksi
$conn = new mysqli($host, $username, $password, $dbname);

//mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: ". $conn->connect_error);
}
echo "Koneksi berhasil!";
?>