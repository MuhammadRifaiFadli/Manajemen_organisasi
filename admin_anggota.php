<?php
require_once "function.php";
createTables();

if (isset($_POST["tambah"])) {
    $id_organisasi = $_POST["id_organisasi"];
    $nama = $_POST["nama"];
    $jabatan = $_POST["jabatan"];
    tambahAnggota($id_organisasi, $nama, $jabatan);
    header("Location: admin_anggota.php");
    exit();
}

if (isset($_POST["update"])) {
    $id = $_POST["id"];
    $id_organisasi = $_POST["id_organisasi"];
    $nama = $_POST["nama"];
    $jabatan = $_POST["jabatan"];
    updateAnggota($id, $nama, $jabatan);
    header("Location: admin_anggota.php");
    exit();
}

if (isset($_POST["hapus"])) {
    $id = $_POST["id"];
    hapusAnggota($id);
    header("Location: admin_anggota.php");
    exit();
}

$organisasi_list = getAllOrganisasi();
$anggota = [];
$selected_organisasi = null;

if (isset($_GET["id_organisasi"])) {
    $selected_organisasi = $_GET["id_organisasi"];
    $anggota = getAllAnggota($selected_organisasi);
}

if (isset($_GET["id_organisasi"]) && !empty($_GET["id_organisasi"])) {
    $selected_organisasi = $_GET["id_organisasi"];
    $anggota = getAllAnggota($selected_organisasi);
} else {
    // Jika tidak ada organisasi yang dipilih, tampilkan semua anggota dari semua organisasi
    $db = getConnection();
    $result = $db->query("SELECT * FROM anggota");
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $anggota[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name= viewport content= width=device-width initial-scale=1.0>
    <title>Admin Anggota Organisasi</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Admin Anggota Organisasi</h1>
    <form method="post">
        <label>Organisasi:</label>
        <select name="id_organisasi" required>
            <option value="">Pilih Organisasi</option>
            <?php foreach ($organisasi_list as $org) { ?>
                <option value="<?= $org["id"] ?>" <?= $selected_organisasi ==
$org["id"]
    ? "selected"
    : "" ?>>
                    <?= $org["nama_organisasi"] ?>
                </option>
            <?php } ?>
        </select><br><br>
        <label>Nama Anggota:</label>
        <input type="text" name="nama" required><br><br>
        <label>Jabatan:</label>
        <input type="text" name="jabatan" required><br><br>
        <input type="submit" name="tambah" value="Tambah Anggota">
    </form>

    <h2>Daftar Anggota</h2>
    <form method="get">
        <label>Pilih Organisasi:</label>
        <select name="id_organisasi" onchange="this.form.submit()">
            <option value="">Semua Organisasi</option>
            <?php foreach ($organisasi_list as $org) { ?>
                <option value="<?= $org["id"] ?>" <?= $selected_organisasi ==
$org["id"]
    ? "selected"
    : "" ?>>
                    <?= $org["nama_organisasi"] ?>
                </option>
            <?php } ?>
        </select>
    </form>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Organisasi</th>
            <th>Nama Anggota</th>
            <th>Jabatan</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($anggota as $i => $ang) {
            $org = getOrganisasiById($ang["id_organisasi"]); ?>
        <tr>
            <td><?= $i + 1 ?></td>
            <td><?= $org["nama_organisasi"] ?></td>
            <td><?= $ang["nama_anggota"] ?></td>
            <td><?= $ang["jabatan"] ?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="id" value="<?= $ang["id"] ?>">
                    <input type="hidden" name="id_organisasi" value="<?= $ang[
                        "id_organisasi"
                    ] ?>">
                    <input type="text" name="nama" value="<?= $ang[
                        "nama_anggota"
                    ] ?>" required>
                    <input type="text" name="jabatan" value="<?= $ang[
                        "jabatan"
                    ] ?>" required>
                    <input type="submit" name="update" value="Update">
                    <input type="submit" name="hapus" value="Hapus">
                </form>
            </td>
        </tr>
        <?php
        } ?>
    </table>
    <a href="admin.php">Kembali ke Admin Organisasi</a>
</body>
</html>
