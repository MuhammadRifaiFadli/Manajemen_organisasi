<?php
require_once "function.php";
createTables();

$id_organisasi = $_GET["id"];
$anggota = getAllAnggota($id_organisasi);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name= viewport content= width=device-width initial-scale=1.0>
    <title>Anggota Organisasi Sekolah</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Anggota Organisasi Sekolah</h1>
    <table>
        <tr>
            <th>No</th>
            <th>Nama Anggota</th>
            <th>Jabatan</th>
        </tr>
        <?php foreach ($anggota as $i => $ang) { ?>
        <tr>
            <td><?= $i + 1 ?></td>
            <td><?= $ang["nama_anggota"] ?></td>
            <td><?= $ang["jabatan"] ?></td>
        </tr>
        <?php } ?>
    </table>
    <a href="index.php">Kembali ke Halaman Utama</a>
</body>
</html>