<?php
include "koneksi.php";

// Mendapatkan data dari form
$exercise_name = $_POST['exercise_name'];
$type_ofexercise = $_POST['type_ofexercise'];
$calory_burned = $_POST['calory_burned'];
$duration = $_POST['duration'];
$level_difficulity = $_POST['level_difficulity'];

// Mengatur direktori target untuk upload file
$target_dir = "imgexercises/"; 

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
            $sql = "INSERT INTO exercises (exercise_name, type_ofexercise, calory_burned, duration, level_difficulity, image) 
                    VALUES ('$exercise_name', '$type_ofexercise', '$calory_burned', '$duration', '$level_difficulity', '$target_file')";
            $query = $koneksi->query($sql);

            if ($query === true) {
                header('location: listexercises.php'); // Mengarahkan kembali ke halaman daftar exercises setelah penyimpanan berhasil
                exit(); 
            } else {
                echo "Gagal menyimpan rekomendasi exercises ke database: " . $koneksi->error;
            }
        } else {
            echo "Maaf, terjadi kesalahan saat mengunggah file.";
        }
    }
} else {
    echo "Maaf, tidak ada file yang diunggah atau terjadi kesalahan saat mengunggah file.";
}
?>
