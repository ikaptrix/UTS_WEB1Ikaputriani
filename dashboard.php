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
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Penjualan - POLGAN MART</title>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="brand">--POLGAN MART--</div>
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $p): ?>
                    <tr>
                        <td><?= $p["kode"] ?></td>
                        <td><?= $p["nama"] ?></td>
                        <td>Rp <?= number_format($p["harga"],0,',','.') ?></td>
                        <td><?= $p["jumlah"] ?></td>
                        <td>Rp <?= number_format($p["total"],0,',','.') ?></td>
                    </tr>
                    <?php endforeach ?>
                    <tr class="total-row">
                        <td colspan="4" style="text-align:right;">Total Belanja</td>
                        <td>Rp <?= number_format($grandtotal,0,',','.') ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>