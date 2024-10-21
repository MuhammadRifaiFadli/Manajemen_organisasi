<?php
require_once "function.php";
createTables();

if (isset($_POST["tambah"])) {
    $nama = $_POST["nama"];
    $ketua = $_POST["ketua"];
    $logo = $_FILES["logo"]["name"];
    tambahOrganisasi($nama, $ketua, $logo);
    move_uploaded_file($_FILES["logo"]["tmp_name"], "Logo_organisasi/" . $logo);
    header("Location: admin.php");
    exit();
}

if (isset($_POST["update"])) {
    $id = $_POST["id"];
    $nama = $_POST["nama"];
    $ketua = $_POST["ketua"];
    
    // Cek apakah ada file logo baru yang diupload
    if (!empty($_FILES["logo"]["name"])) {
        $logo = $_FILES["logo"]["name"];
        move_uploaded_file($_FILES["logo"]["tmp_name"], "Logo_organisasi/" . $logo);
    } else {
        // Jika tidak ada file baru, gunakan logo yang sudah ada
        $org = getOrganisasiById($id);
        $logo = $org["logo_organisasi"];
    }
    
    updateOrganisasi($id, $nama, $ketua, $logo);
    header("Location: admin.php");
    exit();
}

if (isset($_POST["hapus"])) {
    $id = $_POST["id"];
    hapusOrganisasi($id);
    header("Location: admin.php");
    exit();
}

$organisasi = getAllOrganisasi();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name= viewport content= width=device-width initial-scale=1.0>
    <title>Admin Manajemen Organisasi Sekolah</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Admin Manajemen Organisasi Sekolah</h1>
    <form method="post" enctype="multipart/form-data">
        <label>Nama Organisasi:</label >
        <input type="text" name="nama"><br><br>
        <label>Ketua Organisasi:</label>
        <input type="text" name="ketua"><br><br>
        <label>Logo Organisasi:</label>
        <input type="file" name="logo"><br><br>
        <input type="submit" name="tambah" value="Tambah Organisasi">
    </form>
    <table>
    <tr>
        <th>No</th>
        <th>Nama Organisasi</th>
        <th>Ketua Organisasi</th>
        <th>Logo Organisasi</th>
        <th>Aksi</th>
    </tr>
    <?php foreach ($organisasi as $i => $org) { ?>
    <tr>
        <td><?= $i + 1 ?></td>
        <td><?= $org["nama_organisasi"] ?></td>
        <td><?= $org["ketua_organisasi"] ?></td>
        <td><img src="Logo_organisasi/<?= $org["logo_organisasi"] ?>" alt="Logo Organisasi" width="50"></td>
        <td>
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $org["id"] ?>">
                <input type="text" name="nama" value="<?= $org["nama_organisasi"] ?>" required>
                <input type="text" name="ketua" value="<?= $org["ketua_organisasi"] ?>" required>
                <input type="file" name="logo">
                <input type="submit" name="update" value="Update">
                <input type="submit" name="hapus" value="Hapus">
            </form>
        </td>
    </tr>
    <?php } ?>
</table>
    <a href="admin_anggota.php">ke Admin anggota</a>
</body>
</html>