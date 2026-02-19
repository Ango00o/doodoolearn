<?php
require_once '../includes/db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. ดึงชื่อไฟล์มาเพื่อลบทิ้งจาก Folder
    $res = $conn->query("SELECT preview_image, file_path FROM worksheets WHERE id = $id");
    $data = $res->fetch_assoc();

    if ($data) {
        unlink("../uploads/previews/" . $data['preview_image']);
        unlink("../uploads/files/" . $data['file_path']);
    }

    // 2. ลบข้อมูลใน Database
    $conn->query("DELETE FROM worksheets WHERE id = $id");
}

header("Location: admin_worksheets.php");
?>