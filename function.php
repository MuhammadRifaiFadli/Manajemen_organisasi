<?php
// Koneksi database
function getConnection()
{
    $db = new SQLite3("database.sqlite");
    return $db;
}

// Membuat tabel jika belum ada
function createTables()
{
    $db = getConnection();

    $db->exec('CREATE TABLE IF NOT EXISTS organisasi (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nama_organisasi TEXT,
        ketua_organisasi TEXT,
        logo_organisasi TEXT
    )');

    $db->exec('CREATE TABLE IF NOT EXISTS anggota (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        id_organisasi INTEGER,
        nama_anggota TEXT,
        jabatan TEXT,
        FOREIGN KEY (id_organisasi) REFERENCES organisasi(id)
    )');
}

// Fungsi untuk menambah organisasi
function tambahOrganisasi($nama, $ketua, $logo)
{
    $db = getConnection();
    $stmt = $db->prepare(
        "INSERT INTO organisasi (nama_organisasi, ketua_organisasi, logo_organisasi) VALUES (:nama, :ketua, :logo)"
    );
    $stmt->bindValue(":nama", $nama, SQLITE3_TEXT);
    $stmt->bindValue(":ketua", $ketua, SQLITE3_TEXT);
    $stmt->bindValue(":logo", $logo, SQLITE3_TEXT);
    return $stmt->execute();
}

// Fungsi untuk mengupdate organisasi
function updateOrganisasi($id, $nama, $ketua, $logo)
{
    $db = getConnection();
    $stmt = $db->prepare(
        "UPDATE organisasi SET nama_organisasi = :nama, ketua_organisasi = :ketua, logo_organisasi = :logo WHERE id = :id"
    );
    $stmt->bindValue(":id", $id, SQLITE3_INTEGER);
    $stmt->bindValue(":nama", $nama, SQLITE3_TEXT);
    $stmt->bindValue(":ketua", $ketua, SQLITE3_TEXT);
    $stmt->bindValue(":logo", $logo, SQLITE3_TEXT);
    return $stmt->execute(); // Return true jika berhasil, false jika gagal
}

// Fungsi untuk menghapus organisasi
function hapusOrganisasi($id)
{
    $db = getConnection();
    $stmt = $db->prepare("DELETE FROM organisasi WHERE id = :id");
    $stmt->bindValue(":id", $id, SQLITE3_INTEGER);
    return $stmt->execute();
}

// Fungsi untuk mendapatkan semua organisasi
function getAllOrganisasi()
{
    $db = getConnection();
    $result = $db->query("SELECT * FROM organisasi");
    $organisasi = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $organisasi[] = $row;
    }
    return $organisasi;
}

// Fungsi untuk mendapatkan organisasi berdasarkan ID
function getOrganisasiById($id)
{
    $db = getConnection();
    $stmt = $db->prepare("SELECT * FROM organisasi WHERE id = :id");
    $stmt->bindValue(":id", $id, SQLITE3_INTEGER);
    $result = $stmt->execute();
    return $result->fetchArray(SQLITE3_ASSOC);
}

// Fungsi untuk menambah anggota
function tambahAnggota($id_organisasi, $nama, $jabatan)
{
    $db = getConnection();
    $stmt = $db->prepare(
        "INSERT INTO anggota (id_organisasi, nama_anggota, jabatan) VALUES (:id_organisasi, :nama, :jabatan)"
    );
    $stmt->bindValue(":id_organisasi", $id_organisasi, SQLITE3_INTEGER);
    $stmt->bindValue(":nama", $nama, SQLITE3_TEXT);
    $stmt->bindValue(":jabatan", $jabatan, SQLITE3_TEXT);
    return $stmt->execute();
}

// Fungsi untuk mengupdate anggota
function updateAnggota($id, $nama, $jabatan)
{
    $db = getConnection();
    $stmt = $db->prepare(
        "UPDATE anggota SET nama_anggota = :nama, jabatan = :jabatan WHERE id = :id"
    );
    $stmt->bindValue(":id", $id, SQLITE3_INTEGER);
    $stmt->bindValue(":nama", $nama, SQLITE3_TEXT);
    $stmt->bindValue(":jabatan", $jabatan, SQLITE3_TEXT);
    return $stmt->execute();
}

// Fungsi untuk menghapus anggota
function hapusAnggota($id)
{
    $db = getConnection();
    $stmt = $db->prepare("DELETE FROM anggota WHERE id = :id");
    $stmt->bindValue(":id", $id, SQLITE3_INTEGER);
    return $stmt->execute();
}

// Fungsi untuk mendapatkan semua anggota berdasarkan ID organisasi
function getAllAnggota($id_organisasi)
{
    $db = getConnection();
    $stmt = $db->prepare(
        "SELECT * FROM anggota WHERE id_organisasi = :id_organisasi"
    );
    $stmt->bindValue(":id_organisasi", $id_organisasi, SQLITE3_INTEGER);
    $result = $stmt->execute();
    $anggota = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $anggota[] = $row;
    }
    return $anggota;
}
?>
