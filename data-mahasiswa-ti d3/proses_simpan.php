<?php
// panggil file "database.php" untuk koneksi ke database
require_once "config/database.php";

// mengecek data hasil submit dari form
if (isset($_POST['simpan'])) {
    // ambil data hasil submit dari form
    $id_mahasiswa  = $mysqli->real_escape_string($_POST['id_mahasiswa']);
    $nim           = $mysqli->real_escape_string(trim($_POST['nim']));
    $tanggal       = $mysqli->real_escape_string(trim($_POST['tanggal_lahir']));
    $angkatan         = $mysqli->real_escape_string($_POST['angkatan']);
    $nama_lengkap  = $mysqli->real_escape_string(trim($_POST['nama_lengkap']));
    $jenis_kelamin = $mysqli->real_escape_string($_POST['jenis_kelamin']);
    $alamat        = $mysqli->real_escape_string(trim($_POST['alamat']));
    $email         = $mysqli->real_escape_string(trim($_POST['email']));
    $whatsapp      = $mysqli->real_escape_string(trim($_POST['whatsapp']));

    // ubah format tanggal menjadi Tahun-Bulan-Hari (Y-m-d) sebelum disimpan ke database
    $tanggal_lahir = date('Y-m-d', strtotime($tanggal));

    // ambil data file hasil submit dari form
    $nama_file          = $_FILES['foto']['name'];
    $tmp_file           = $_FILES['foto']['tmp_name'];
    $extension          = array_pop(explode(".", $nama_file));
    // enkripsi nama file
    $nama_file_enkripsi = sha1(md5(time() . $nama_file)) . '.' . $extension;
    // tentukan direktori penyimpanan file
    $path               = "images/" . $nama_file_enkripsi;

    // lakukan proses unggah file
    // jika file berhasil diunggah
    if (move_uploaded_file($tmp_file, $path)) {
        // sql statement untuk insert data ke tabel "tbl_mahasiswa"
        $insert = $mysqli->query("INSERT INTO tbl_mahasiswa(id_mahasiswa, nim, tanggal_lahir, angkatan, nama_lengkap, jenis_kelamin, alamat, email, whatsapp, foto_profil) 
                                  VALUES('$id_mahasiswa','$nim','$tanggal_lahir', '$angkatan', '$nama_lengkap', '$jenis_kelamin', '$alamat', '$email', '$whatsapp', '$nama_file_enkripsi')")
                                  or die('Ada kesalahan pada query insert : ' . $mysqli->error);
        // cek query
        // jika proses insert berhasil
        if ($insert) {
            // alihkan ke halaman data mahasiswa dan tampilkan pesan berhasil simpan data
            header('location: index.php?halaman=data&pesan=1');
        }
    }
}
