<?php
include "koneksi.php";

if(isset($_POST['input']) && !empty($_POST['input'])) {

    $ids = implode(",", array_map('intval', $_POST['input']));

    $sql = "DELETE FROM foods WHERE id_food IN ({$ids})";
    $query = $koneksi->query($sql);

    if ($query === true) {
        header('Location: listfood.php');
        exit(); 
    } else {
        echo "Error deleting records: " . $koneksi->error;
    }
} else {
    echo "No input IDs received.";
}
?>