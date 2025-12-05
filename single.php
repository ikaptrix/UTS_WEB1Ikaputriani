<?php
session_start();

// kalau halaman dibuka biasa (GET), keranjang dikosongkan
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['cart'] = [];
}

// Inisialisasi keranjang
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// data barang
$barangList = [
    'BRG001' => ['nama' => 'Sabun Mandi', 'harga' => 15000],
    'BRG002' => ['nama' => 'Sikat Gigi',  'harga' => 8000],
    'BRG003' => ['nama' => 'Pasta Gigi',  'harga' => 12000],
    'BRG004' => ['nama' => 'Shampoo',     'harga' => 18000],
    'BRG005' => ['nama' => 'Handuk',      'harga' => 35000],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $kode   = $_POST['kode']   ?? '';
    $nama   = $_POST['nama']   ?? '';
    $harga  = (int)($_POST['harga']   ?? 0);
    $jumlah = (int)($_POST['jumlah']  ?? 0);

    // hanya kalau benar2 dipilih dan jumlah > 0
    if ($kode !== '' && $jumlah > 0) {
        $_SESSION['cart'][] = [
            'kode'   => $kode,
            'nama'   => $nama,
            'harga'  => $harga,
            'jumlah' => $jumlah
        ];
    }
}

// hitung total hanya dari isi keranjang (kalau ada)
$grandtotal = 0;
foreach ($_SESSION['cart'] as $item) {
    $grandtotal += $item['harga'] * $item['jumlah'];
}

if ($grandtotal == 0) {
    $d = "0%";
    $diskon = 0;
} elseif ($grandtotal < 50000) {
    $d = "5%";
    $diskon = 0.05 * $grandtotal;
} elseif ($grandtotal <= 100000) {
    $d = "10%";
    $diskon = 0.10 * $grandtotal;
} else {
    $d = "15%";
    $diskon = 0.15 * $grandtotal;
}

$totalbayar = $grandtotal - $diskon;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>POLGAN MART - Keranjang</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .form-group { margin-bottom: 10px; }
        label { font-weight: bold; display:block; margin-bottom:4px; }
        input, select { width: 100%; padding:6px; box-sizing:border-box; }
        button { padding:6px 12px; }
        table { border-collapse: collapse; width:100%; margin-top:16px; }
        th, td { border:1px solid #ccc; padding:6px; }
        th { background:#f2f2f2; }
        tfoot td { font-weight:bold; }
        .text-right { text-align:right; }
        .text-center { text-align:center; }
    </style>
</head>
<body>
    <h2>Input Barang</h2>

    <form method="post" id="formBarang">
        <div class="form-group">
            <label>Kode Barang</label>
            <select name="kode" id="kode">
                <option value="">Pilih Kode Barang</option>
                <?php foreach ($barangList as $k => $b): ?>
                    <option value="<?php echo $k; ?>"
                            data-nama="<?php echo $b['nama']; ?>"
                            data-harga="<?php echo $b['harga']; ?>">
                        <?php echo $k . ' - ' . $b['nama']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama" id="nama" readonly>
        </div>

        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" id="harga" readonly>
        </div>

        <div class="form-group">
            <label>Jumlah</label>
            <input type="number" name="jumlah" min="1" value="1">
        </div>

        <button type="submit">Tambahkan</button>
        <button type="reset">Batal</button>
    </form>

    <script>
    const selectKode = document.getElementById('kode');
    const inputNama  = document.getElementById('nama');
    const inputHarga = document.getElementById('harga');

    function isiBarangDariSelect() {
        const opt   = selectKode.options[selectKode.selectedIndex];
        const nama  = opt.getAttribute('data-nama')  || '';
        const harga = opt.getAttribute('data-harga') || '';
        inputNama.value  = nama;
        inputHarga.value = harga;
    }

    selectKode.addEventListener('change', isiBarangDariSelect);
    </script>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SESSION['cart'])): ?>
    <h2>Daftar Barang di Keranjang</h2>
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Harga (Rp)</th>
                <th>Jumlah</th>
                <th>Total Baris (Rp)</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($_SESSION['cart'] as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars($item['kode']); ?></td>
                <td><?php echo htmlspecialchars($item['nama']); ?></td>
                <td class="text-right">
                    <?php echo number_format($item['harga'],0,',','.'); ?>
                </td>
                <td class="text-center">
                    <?php echo $item['jumlah']; ?>
                </td>
                <td class="text-right">
                    <?php echo number_format($item['harga'] * $item['jumlah'],0,',','.'); ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right">Subtotal</td>
                <td class="text-right"><?php echo number_format($grandtotal,0,',','.'); ?></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right">Diskon (<?php echo $d; ?>)</td>
                <td class="text-right"><?php echo number_format($diskon,0,',','.'); ?></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right">Total Bayar</td>
                <td class="text-right"><?php echo number_format($totalbayar,0,',','.'); ?></td>
            </tr>
        </tfoot>
    </table>
    <?php endif; ?>
</body>
</html>