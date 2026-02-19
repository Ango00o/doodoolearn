<?php
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    
    // ตั้งชื่อไฟล์ใหม่เพื่อป้องกันชื่อซ้ำ
    $preview_name = time() . "_" . $_FILES['preview_image']['name'];
    $file_name = time() . "_" . $_FILES['file_path']['name'];

    // ตำแหน่งจัดเก็บ
    $target_preview = "uploads/previews/" . $preview_name;
    $target_file = "uploads/files/" . $file_name;

    // ตรวจสอบและสร้างโฟลเดอร์ถ้ายังไม่มี
    if (!is_dir('uploads/previews')) mkdir('uploads/previews', 0777, true);
    if (!is_dir('uploads/files')) mkdir('uploads/files', 0777, true);

    // อัปโหลดไฟล์
    if (move_uploaded_file($_FILES['preview_image']['tmp_name'], $target_preview) && 
        move_uploaded_file($_FILES['file_path']['tmp_name'], $target_file)) {
        
        $sql = "INSERT INTO worksheets (title, preview_image, file_path) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $title, $preview_name, $file_name);
        
        if ($stmt->execute()) {
            echo "<script>alert('เพิ่มใบงานสำเร็จ!'); window.location='admin_worksheets.php';</script>";
        } else {
            echo "เกิดข้อผิดพลาดในการบันทึกฐานข้อมูล";
        }
    } else {
        echo "เกิดข้อผิดพลาดในการอัปโหลดไฟล์";
    }
}
?>