<?php
include "koneksi.php"; 

// Mendapatkan data dari form
$food_name = $_POST['food_name'];
$raw_material = $_POST['raw_material'];
$calory_produced = $_POST['calory_produced'];
$category = $_POST['category'];
$tutorial = $_POST['tutorial'];

// Mengatur direktori target untuk upload file
$target_dir = "imgfood/"; 

// Cek apakah file diunggah
if(isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
    $target_file = $target_dir . basename($_FILES["file"]["name"]); 
    $uploadOk = 1; 

    // Cek apakah file sudah ada
    if (file_exists($target_file)) {
        echo "Maaf, file tersebut sudah ada.";
        $uploadOk = 0;
    }

    // Cek jenis file
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif") {
        echo "Maaf, hanya file JPG, JPEG, PNG, & GIF yang diizinkan.";
        $uploadOk = 0;
    }

    // Jika semua pengecekan sudah OK, lanjutkan proses upload file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            echo "File ". htmlspecialchars(basename($_FILES["file"]["name"])). " telah berhasil diunggah.";

            // Menyimpan data ke database
            $sql = "INSERT INTO foods (food_name, raw_material, calory_produced, category, tutorial, image) 
                    VALUES ('$food_name', '$raw_material', '$calory_produced', '$category', '$tutorial', '$target_file')";
            $query = $koneksi->query($sql);

            if ($query === true) {
                header('location: listfood.php'); 
            } else {
                echo "Gagal menyimpan rekomendasi makanan ke database: " . $koneksi->error;
            }
        } else {
            echo "Maaf, terjadi kesalahan saat mengunggah file.";
        }
    }
} else {
    echo "Maaf, tidak ada file yang diunggah atau terjadi kesalahan saat mengunggah file.";
}
?>
