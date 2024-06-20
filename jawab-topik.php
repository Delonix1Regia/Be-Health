<?php
session_start();

// Jika tidak ada data POST, redirect ke halaman konsultasi
if (empty($_POST)) {
    header("Location: konsultasi.php");
    exit;
}

// Jika id_topik tidak ada atau kosong, redirect ke halaman konsultasi
if (!isset($_POST['id_topik']) || empty($_POST['id_topik'])) {
    header("Location: konsultasi.php");
    exit;
}

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user']) || empty($_SESSION['user']['id'])) {
    header("Location: logininspinia.php"); // Redirect ke halaman login jika belum login
    exit;
}

include 'koneksi.php';

// Siapkan pernyataan SQL
$sql = "INSERT INTO komentar (komentar, tanggal, id_topik, id_user) VALUES (?, now(), ?, ?)";

if ($query = $koneksi->prepare($sql)) {
    // Bind parameter dan eksekusi pernyataan
    $query->bind_param("sii", $_POST['komentar'], $_POST['id_topik'], $_SESSION['user']['id']);
    if ($query->execute()) {
        // Tutup pernyataan dan redirect ke halaman topik
        $query->close();
        header("Location: lihat-topik.php?id=" . $_POST['id_topik']);
        exit;
    } else {
        echo "Error: " . $query->error;
    }
} else {
    echo "Error: " . $koneksi->error;
}

// Tutup koneksi
$koneksi->close();
