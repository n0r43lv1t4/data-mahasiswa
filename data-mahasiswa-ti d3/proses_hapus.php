<?php
// panggil file "database.php" untuk koneksi ke database
require_once "config/database.php";

// mengecek data GET "id_mahasiswa"
if (isset($_GET['id'])) {
    // ambil data GET dari tombol hapus
    $id_mahasiswa = $mysqli->real_escape_string(trim($_GET['id']));

    // mengecek data foto profil
    // sql statement untuk menampilkan data "foto_profil" dari tabel "tbl_mahasiswa" berdasarkan "id_mahasiswa"
    $query = $mysqli->query("SELECT foto_profil FROM tbl_mahasiswa WHERE id_mahasiswa='$id_mahasiswa'")
                             or die('Ada kesalahan pada query tampil data : ' . $mysqli->error);
    // ambil data hasil query
    $data = $query->fetch_assoc();

    // hapus file foto dari folder images
    $hapus_file = unlink("images/$data[foto_profil]");

    // sql statement untuk delete data dari tabel "tbl_mahasiswa" berdasarkan "id_mahasiswa"
    $delete = $mysqli->query("DELETE FROM tbl_mahasiswa WHERE id_mahasiswa='$id_mahasiswa'")
                              or die('Ada kesalahan pada query delete : ' . $mysqli->error);
    // cek query
    // jika proses delete berhasil
    if ($delete) {
        // alihkan ke halaman data mahasiswa dan tampilkan pesan berhasil hapus data
        header('location: index.php?halaman=data&pesan=3');
    }
}
