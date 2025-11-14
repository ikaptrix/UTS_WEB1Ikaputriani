<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Penjualan - POLGAN MART</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            background-color: #f4f7f6;
            margin: 30px;
        }
        h1 {
            color: #008080;
            text-align: center;
        }
        h3 {
            text-align: center;
        }
        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 70%;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        table, th, td {
            border: 1px solid #777;
        }
        th {
            background-color: #008080;
            color: white;
            padding: 10px;
        }
        td {
            text-align: center;
            padding: 8px;
            background-color: #fff;
        }
        hr {
            width: 80%;
            border: 1px dashed #008080;
        }
        .logout {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            background-color: #008080;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
        }
        .logout:hover {
            background-color: #006666;
        }
        .struk {
            background-color: #fff;
            border: 2px dashed #008080;
            width: 50%;
            margin: 30px auto;
            padding: 15px;
            text-align: left;
            line-height: 1.5;
        }
        .total {
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>-- POLGAN MART --</h1>
    <h3>Selamat Datang, <?php echo $_SESSION['username']; ?> (<?php echo $_SESSION['role']; ?>)</h3>
    <hr>
    <?php
    $kode_barang = ["BARANG1", "BARANG2", "BARANG3", "BARANG4", "BARANG5"];
    $nama_barang = ["Kopi", "Mineral", "Basreng", "Roti", "Cimory"];
    $harga_barang = [10000, 3000, 25000, 7000, 5000];
    $pembelian = [
        ["kode" => "BARANG1", "nama" => "Kopi", "harga" => 10000, "jumlah" => 2],
        ["kode" => "BARANG3", "nama" => "Roti", "harga" => 7000, "jumlah" => 6],
        ["kode" => "BARANG5", "nama" => "Mineral", "harga" => 3000, "jumlah" => 1],
    ];

    echo "<h2 style='text-align:center;'>Detail Pembelian</h2>";
    echo "<table>";
    echo "<tr>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Harga (Rp)</th>
            <th>Jumlah Beli</th>
            <th>Total (Rp)</th>
          </tr>";

    $grandtotal = 0;

    foreach ($pembelian as $item) {
        $total = $item['harga'] * $item['jumlah'];
        $grandtotal += $total;

        echo "<tr>";
        echo "<td>{$item['kode']}</td>";
        echo "<td>{$item['nama']}</td>";
        echo "<td>" . number_format($item['harga'], 0, ',', '.') . "</td>";
        echo "<td>{$item['jumlah']}</td>";
        echo "<td>" . number_format($total, 0, ',', '.') . "</td>";
        echo "</tr>";
    }
    echo "<tr style='font-weight:bold; background-color:#e0f7f7;'>
            <td colspan='4'>Grand Total</td>
            <td>Rp " . number_format($grandtotal, 0, ',', '.') . "</td>
          </tr>";
    echo "</table>";

    echo "<hr>";
    echo "<div class='struk'>";
    echo "<h3 style='text-align:center;'>===== STRUK PEMBELIAN =====</h3>";
    echo "Tanggal : " . date("d-m-Y H:i:s") . "<br>";
    echo "Kasir   : " . $_SESSION['username'] . "<br><br>";
    echo "--------------------------------------------<br>";

    foreach ($pembelian as $item) {
        $total = $item['harga'] * $item['jumlah'];
        echo "{$item['nama']} ({$item['jumlah']} x Rp " . number_format($item['harga'], 0, ',', '.') . ") = Rp " . number_format($total, 0, ',', '.') . "<br>";
    }

    echo "--------------------------------------------<br>";
    echo "<div class='total'>Total Belanja : Rp " . number_format($grandtotal, 0, ',', '.') . "</div>";
    echo "<p style='text-align:center;'>Terima Kasih Telah Berbelanja di POLGAN MART!</p>";
    echo "</div>";
    ?>

    <a class="logout" href="logout.php">Logout</a>
</body>
</html>