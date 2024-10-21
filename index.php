<?php
require_once "function.php";
createTables();

$organisasi = getAllOrganisasi();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name= viewport content= width=device-width initial-scale=1.0>
    <title>Manajemen Organisasi Sekolah</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Manajemen Organisasi Sekolah</h1>
    <table>
        <tr>
            <th>No</th>
            <th>Logo Organisasi</th>
            <th>Nama Organisasi</th>
            <th>Ketua Organisasi</th>
            <th>Jumlah Anggota</th>
        </tr>
        <?php foreach ($organisasi as $i => $org) { ?>
        <tr>
            <td><?= $i + 1 ?></td>
            <td><img src="Logo_organisasi/<?= $org[
                "logo_organisasi"
            ] ?>" alt="Logo Organisasi"></td>
            <td><?= $org["nama_organisasi"] ?></td>
            <td><?= $org["ketua_organisasi"] ?></td>
            <td><a href="read_anggota.php?id=<?= $org["id"] ?>"><?= count(
    getAllAnggota($org["id"])
) ?> Anggota</a></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>