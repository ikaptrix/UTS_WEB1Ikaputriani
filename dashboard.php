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
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6fa; margin: 0; }
        .container { width: 900px; margin: 35px auto; }
        .topbar { display: flex; justify-content: flex-end; align-items: center; margin-bottom: 20px; }
        .topbar-info { margin-right: 12px; text-align: right; }
        .username { font-size: 1.07em; color: #222; }
        .role { font-size: 0.95em; color: #888; display: block; margin-bottom: 6px; }
        .logout-btn { background: #fff; border: 1.2px solid #c8d4df; border-radius: 5px; padding: 8px 20px; color: #444; cursor: pointer; }
        .logout-btn:hover { background: #e6eefc; }
        .card { background: #fff; border-radius: 13px; padding: 28px; box-shadow: 0 0 10px #e3e5ea; }
        .brand-row { display: flex; align-items: center; margin-bottom: 16px; }
        .brand-logo { width: 40px; height: 40px; background: #4376ff; color: #fff; border-radius: 8px;
                       display: inline-flex; align-items: center; justify-content: center; font-weight: bold; margin-right: 10px; }
        .brand-text { display: inline-block; vertical-align: middle; }
        .brand-title { font-weight: bold; font-size: 1.1em; }
        .brand-subtitle { color: #768cb0; font-size: 0.95em; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #e5e8ee; padding: 8px 14px; }
        th { background: #f7f9fc; }
        .total-row td { font-weight: bold; background: #f7f7fa; }
    </style>
</head>
<body>
    <div class="container">
    <div class="topbar">
        <div class="topbar-info">
            <div class="username">Selamat datang, <?= $_SESSION["username"]; ?>!</div>
            <span class="role">Role: <?= $_SESSION["role"]; ?></span>
        </div>
        <form method="post" action="logout.php" style="margin:0;">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
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