<?php
session_start();
include "koneksi.php";

if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit;
}
$error='';
if (isset($_POST['x']) && isset($_POST['y'])) {
    $username = $_POST['x'];
    $password = $_POST['y'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");

    if ($row = mysqli_fetch_assoc($result)) {
        if ($password == $row['password']) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['nama'] = $row['nama_lengkap'];
            $_SESSION['role'] = $row['role'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login POLGAN MART</title>
    <style>
        body {
            background: #f2f2f2;
            font-family: Arial, sans-serif;
        }
        .card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 0 15px 4px #bbb;
            margin: 60px auto;
            padding: 35px 35px 25px 35px;
            width: 380px;
            text-align: center;
        }
        .logo {
            font-size: 2em;
            font-weight: bold;
            color: #1976d2;
            margin-bottom: 25px;
            letter-spacing: 1px;
        }
        .form-label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            text-align: left;
        }
        .form-input {
            width: 100%;
            padding: 7px 12px;
            border: 1.5px solid #bfc0c0;
            border-radius: 6px;
            font-size: 1em;
            margin-bottom: 18px;
            background: #f8f8f8;
        }
        .btn {
            width: 100%;
            background: #1976d2;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 1.1em;
            font-weight: bold;
            padding: 10px 0px;
            margin-bottom: 10px;
            cursor: pointer;
            box-shadow: 0 1px 1px #aaa;
            transition: background 0.2s;
        }
        .btn:hover {
            background: #125ca0;
        }
        .btn-reset {
            background: none;
            border: none;
            color: #1976d2;
            font-size: 1em;
            cursor: pointer;
            margin-bottom: 10px;
        }
        .error {
            color: #c62828;
            margin-bottom: 12px;
            font-weight: bold;
        }
        .footer {
            color: #888;
            font-size: 0.96em;
            margin-top: 12px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">POLGAN MART</div>
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="form-label">Username</div>
            <input type="text" name="x" class="form-input" autocomplete="off" required>
            <div class="form-label">Password</div>
            <input type="password" name="y" class="form-input" required>
            <button type="submit" name="login" class="btn">Login</button>
            <button type="reset" class="btn-reset">Batal</button>
        </form>
        <div class="footer">&copy; 2025 POLGAN MART</div>
    </div>
</body>
</html>