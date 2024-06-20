<?php
include "koneksi.php";

// Validate and sanitize inputs
if (isset($_POST['id_food'])) {
    $id_food = $_POST['id_food'];
} else {
    echo "ID Makanan tidak ditemukan.";
    exit;
}

$food_name = $_POST['food_name'];
$raw_material = $_POST['raw_material'];
$calory_produced = $_POST['calory_produced'];
$category = $_POST['category'];
$tutorial = $_POST['tutorial'];

// Validate and sanitize inputs
$id_food = mysqli_real_escape_string($koneksi, $id_food);
$food_name = mysqli_real_escape_string($koneksi, $food_name);
$raw_material = mysqli_real_escape_string($koneksi, $raw_material);
$calory_produced = mysqli_real_escape_string($koneksi, $calory_produced);
$category = mysqli_real_escape_string($koneksi, $category);
$tutorial = mysqli_real_escape_string($koneksi, $tutorial);

// Prepare the update statement
$sql = "UPDATE foods
        SET food_name = ?, 
            raw_material = ?, 
            calory_produced = ?, 
            category = ?, 
            tutorial = ?
        WHERE id_food = ?";

// Prepare the statement
$stmt = mysqli_prepare($koneksi, $sql);

if ($stmt) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "ssisss", $food_name, $raw_material, $calory_produced, $category, $tutorial, $id_food);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        header('Location: recipe.php?id=' . $id_food);
        exit;
    } else {
        echo "Error executing query: " . mysqli_stmt_error($stmt);
    }

    // Close statement
    mysqli_stmt_close($stmt);
} else {
    echo "Error preparing statement: " . mysqli_error($koneksi);
}

// Close connection
mysqli_close($koneksi);
?>
