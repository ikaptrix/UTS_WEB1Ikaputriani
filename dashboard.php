<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['hapus_index'])) {
    unset($_SESSION['cart'][$_POST['hapus_index']]);
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    header("Location: dashboard.php");
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kode'])) {

    $kode   = $_POST['kode'];
    $nama   = $_POST['nama'];
    $harga  = (int) $_POST['harga'];
    $jumlah = (int) $_POST['jumlah'];

    if ($jumlah <= 0) {
        $errors[] = "Jumlah tidak valid";
    }

    if (!$errors) {
        $_SESSION['cart'][] = [
            'kode' => $kode,
            'nama' => $nama,
            'harga' => $harga,
            'jumlah' => $jumlah,
            'lineTotal' => $harga * $jumlah
        ];
        header("Location: dashboard.php");
        exit;
    }
}

if (isset($_POST['clear_cart'])) {
    $_SESSION['cart'] = [];
    header("Location: dashboard.php");
    exit;
}

$grandtotal = 0;
foreach ($_SESSION['cart'] as $c) {
    $grandtotal += $c['lineTotal'];
}

$diskon = 0;
$d = "0%";

if ($grandtotal >= 100000) {
    $diskon = 0.15 * $grandtotal;
    $d = "15%";
} elseif ($grandtotal >= 50000) {
    $diskon = 0.10 * $grandtotal;
    $d = "10%";
} elseif ($grandtotal > 0) {
    $diskon = 0.05 * $grandtotal;
    $d = "5%";
}

$totalbayar = $grandtotal - $diskon;

$barangData = [];
$q = $conn->query("SELECT kode_barang, nama_barang, harga FROM barang");
while ($r = $q->fetch_assoc()) {
    $barangData[$r['kode_barang']] = [
        'nama' => $r['nama_barang'],
        'harga' => $r['harga']
    ];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - POLGAN MART</title>

    <style>
        :root {
            --bg: #f5f7fb;
            --card: #fff;
            --accent: #1f6feb;
            --muted: #6b7280;
            --border: #e6e9ef;
        }

        * {
            box-sizing: border-box;
            font-family: Inter, Segoe UI, Arial;
        }

        body {
            margin: 0;
            background: var(--bg);
            padding: 24px;
        }

        .container {
            max-width: 900px;
            margin: auto;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 18px;
        }

        header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .logo {
            width: 56px;
            height: 56px;
            background: var(--accent);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid var(--border);
        }

        th {
            color: var(--muted);
        }

        .right {
            text-align: right;
        }

        .total-row td {
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 8px;
            border: 1px solid var(--border);
            border-radius: 8px;
        }

        .btn {
            background: var(--accent);
            color: #fff;
            border: 0;
            padding: 10px;
            border-radius: 8px;
        }

        .btn-reset {
            background: #ef4444;
            color: #fff;
            border: 0;
            padding: 8px;
            border-radius: 8px;
        }
    </style>
</head>

<body>
<div class="container">
    <header>
        <div style="display:flex;gap:12px">
            <div class="logo">PM</div>
            <div>
                <h3>POLGAN MART</h3>
                <small>Sistem Penjualan</small>
            </div>
        </div>
        <div>
            <b><?= $_SESSION['username'] ?></b><br>
            <small><?= $_SESSION['role'] ?? '-' ?></small><br>
            <a href="logout.php">Logout</a>
        </div>
    </header>

    <div class="card">
        <?php foreach ($errors as $e): ?>
            <p style="color:red"><?= $e ?></p>
        <?php endforeach; ?>

        <form method="post">
            <label>Kode Barang</label>
            <select id="kode" name="kode" required>
                <option value="">-- pilih --</option>
                <?php foreach ($barangData as $k => $v): ?>
                    <option value="<?= $k ?>"><?= $k ?></option>
                <?php endforeach; ?>
            </select>

            <label>Nama Barang</label>
            <input type="text" id="nama" name="nama" readonly>

            <label>Harga</label>
            <input type="text" id="harga" name="harga" readonly>

            <label>Jumlah</label>
            <input type="number" name="jumlah" min="1" required>

            <button class="btn">Tambah</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th class="right">Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($_SESSION['cart'] as $i => $c): ?>
                <tr>
                    <td><?= $c['kode'] ?></td>
                    <td><?= $c['nama'] ?></td>
                    <td>Rp <?= number_format($c['harga']) ?></td>
                    <td><?= $c['jumlah'] ?></td>
                    <td class="right">Rp <?= number_format($c['lineTotal']) ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="hapus_index" value="<?= $i ?>">
                            <button class="btn-reset">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>

            <tr class="total-row">
                <td colspan="4" class="right">Total</td>
                <td class="right">Rp <?= number_format($grandtotal) ?></td>
            </tr>
            <tr class="total-row">
                <td colspan="4" class="right">Diskon (<?= $d ?>)</td>
                <td class="right">Rp <?= number_format($diskon) ?></td>
            </tr>
            <tr class="total-row">
                <td colspan="4" class="right">Total Bayar</td>
                <td class="right">Rp <?= number_format($totalbayar) ?></td>
            </tr>
            </tbody>
        </table>

        <form method="post">
            <button name="clear_cart" class="btn-reset">Kosongkan</button>
        </form>
    </div>
</div>

<script>
const barangData = <?= json_encode($barangData); ?>;
const kode = document.getElementById('kode');
const nama = document.getElementById('nama');
const harga = document.getElementById('harga');

kode.addEventListener('change', function () {
    if (barangData[this.value]) {
        nama.value = barangData[this.value].nama;
        harga.value = barangData[this.value].harga;
    } else {
        nama.value = '';
        harga.value = '';
    }
});
</script>
</body>
</html>