<?php
//$conn = new mysqli("localhost", "root", "", "kids_learning");
//$conn->set_charset("utf8mb4");

require_once '../includes/db_connect.php'; 

if (isset($_POST['add_lesson'])) {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $link = addslashes("contents/" . $_POST['link']);//$_POST['link'];
    
    // จัดการการอัปโหลดไฟล์ภาพ (Asset Management)
    $target_dir = "../uploads/";
    if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }
    
    $filename = time() . "_" . basename($_FILES["thumb"]["name"]);
    $target_file = $target_dir . $filename;

    if (move_uploaded_file($_FILES["thumb"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO lessons (title, category, thumbnail, content_link) 
                VALUES ('$title', '$category', '$filename', '$link')";
        $conn->query($sql);
        echo "<script>alert('เพิ่มบทเรียนสำเร็จแล้ว!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ระบบหลังบ้านครู 🍎</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; padding: 20px; }
        .admin-form { background: white; padding: 20px; border-radius: 10px; max-width: 500px; margin: auto; }
        input, select, button { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        button { background: #4ecdc4; color: white; border: none; cursor: pointer; }
    </style>
   
</head>
<body>

 <?php include 'admin_header.php'; ?>

    <div class="admin-form">
        <h2>เพิ่มบทเรียนใหม่ 📝</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="ชื่อบทเรียน (เช่น การวัดอุณหภูมิ)" required>
            <select name="category">
                <option value="วิทยาศาสตร์">วิทยาศาสตร์</option>
                <option value="คณิตศาสตร์">คณิตศาสตร์</option>
            </select>
            <input type="text" name="link" placeholder="ลิงก์หน้าเนื้อหา (เช่น temp.html)" required>
            <label>รูปภาพ Thumbnail:</label>
            <input type="file" name="thumb" accept="image/*" required>
            <button type="submit" name="add_lesson">บันทึกข้อมูล</button>
        </form>
    </div>
</body>
</html>