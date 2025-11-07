<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}
$products = [
    ["kode" => "K003", "nama" => "Sprite", "harga" => 4000],
    ["kode" => "K001", "nama" => "Teh Pucuk", "harga" => 5000],
    ["kode" => "K004", "nama" => "Coca-Cola", "harga" => 5000],
    ["kode" => "K002", "nama" => "Sukro", "harga" => 1000],
    ["kode" => "K005", "nama" => "Chitose", "harga" => 3000],
];
$grandtotal = 0;
foreach ($products as &$p) {
    $p['jumlah'] = rand(1,5);
    $p['total'] = $p['jumlah'] * $p['harga'];
    $grandtotal += $p['total'];
}
unset($p);
?>