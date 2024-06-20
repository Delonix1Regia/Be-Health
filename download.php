<?php
function downloadImage($file_path) {
    if (file_exists($file_path) && filesize($file_path) <= 2 * 1024 * 1024) {
        $file_name = basename($file_path);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $file_name);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));
        readfile($file_path);
        exit;
    } else {
        echo "File tidak tersedia atau melebihi 2 MB";
    }
}

if (isset($_GET['file'])) {
    $file_path = $_GET['file'];
    downloadImage($file_path);
}
?>