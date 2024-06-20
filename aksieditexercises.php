<?php
session_start();
include "koneksi.php";

// Pastikan $_POST['id_exercises'] didefinisikan dan tidak kosong
if (isset($_POST['id_exercises'])) {
    $id_exercises = $_POST['id_exercises'];
} else {
    echo "ID Exercises tidak ditemukan.";
    exit;
}

$exercise_name = $_POST['exercise_name'];
$type_ofexercise = $_POST['type_ofexercise'];
$calory_burned = $_POST['calory_burned'];
$duration = $_POST['duration'];
$level_difficulity = $_POST['level_difficulity'];

// Pastikan nilai dari $id_exercises adalah integer atau sesuai dengan struktur ID di database
$id_exercises = mysqli_real_escape_string($koneksi, $id_exercises);

$sql = "UPDATE exercises
        SET exercise_name = '$exercise_name',
            type_ofexercise = '$type_ofexercise',
            calory_burned = '$calory_burned',
            duration = '$duration',
            level_difficulity = '$level_difficulity'
        WHERE id_exercises = '$id_exercises'";

$query = mysqli_query($koneksi, $sql);

if ($query) {
    header('location: tutorial.php?id=' . $id_exercises);
} else {
    echo "Error: " . mysqli_error($koneksi);
}

mysqli_close($koneksi);
?>