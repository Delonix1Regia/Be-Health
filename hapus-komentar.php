<?php
session_start();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: konsultasi.php");
    exit;
}

include 'koneksi.php';

// Verifikasi bahwa komentar tersebut milik user yang sedang login
$sql = "SELECT * FROM komentar WHERE id=? AND id_user=?";
if ($query = $koneksi->prepare($sql)) {
    $query->bind_param("ii", $_GET['id'], $_SESSION['user']['id']);
    $query->execute();
    $result = $query->get_result();
    $komentar = $result->fetch_assoc();
    $query->close();

    if (!$komentar) {
        header("Location: konsultasi.php");
        exit;
    }

    // Hapus komentar
    $sqlHapus = "DELETE FROM komentar WHERE id=? AND id_user=?";
    if ($queryHapus = $koneksi->prepare($sqlHapus)) {
        $queryHapus->bind_param("ii", $_GET['id'], $_SESSION['user']['id']);
        $queryHapus->execute();
        $queryHapus->close();
    } else {
        echo "Error: " . $koneksi->error;
        exit;
    }

    // Redirect ke halaman topik terkait
    header("Location: lihat-topik.php?id=" . $komentar['id_topik']);
    exit;
} else {
    echo "Error: " . $koneksi->error;
    exit;
}
