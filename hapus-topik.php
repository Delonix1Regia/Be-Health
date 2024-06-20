<?php

session_start();
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: konsultasi.php");
    exit;
}

include 'koneksi.php';

// Verifikasi bahwa topik tersebut milik user yang sedang login
$sql = "SELECT * FROM topik WHERE id=? AND id_user=?";
if ($query = $koneksi->prepare($sql)) {
    $query->bind_param("ii", $_GET['id'], $_SESSION['user']['id']);
    $query->execute();
    $result = $query->get_result();
    $topik = $result->fetch_assoc();
    $query->close();

    if (!$topik) {
        header("Location: konsultasi.php");
        exit;
    }

    // Mulai transaksi
    $koneksi->begin_transaction();

    try {
        // Hapus komentar terkait
        $queryHapusKomentar = $koneksi->prepare("DELETE FROM komentar WHERE id_topik=?");
        $queryHapusKomentar->bind_param("i", $topik['id']);
        $queryHapusKomentar->execute();
        $queryHapusKomentar->close();

        // Hapus topik
        $sqlHapus = "DELETE FROM topik WHERE id=? AND id_user=?";
        $queryHapus = $koneksi->prepare($sqlHapus);
        $queryHapus->bind_param("ii", $_GET['id'], $_SESSION['user']['id']);
        $queryHapus->execute();
        $queryHapus->close();

        // Commit transaksi
        $koneksi->commit();
    } catch (Exception $e) {
        // Rollback jika ada kesalahan
        $koneksi->rollback();
        echo $e->getMessage();
        exit;
    }
} else {
    echo "Error: " . $koneksi->error;
    exit;
}

header("Location: konsultasi.php");
exit;
