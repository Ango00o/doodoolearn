<?php
//$conn = new mysqli("localhost", "root", "", "kids_learning");
//$conn->set_charset("utf8mb4");

require_once '../includes/db_connect.php'; 

$id = $_GET['id'];
$res = $conn->query("SELECT * FROM lessons WHERE id = $id");
$data = $res->fetch_assoc();

if (isset($_POST['update_lesson'])) {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $link = addslashes($_POST['link']);//$_POST['link'];
    $description = $_POST['description'];
    
    // ตรวจสอบว่ามีการอัปโหลดรูปใหม่ไหม
    if (!empty($_FILES["thumb"]["name"])) {
        $filename = time() . "_" . basename($_FILES["thumb"]["name"]);
        move_uploaded_file($_FILES["thumb"]["tmp_name"], "../uploads/" . $filename);
        // อัปเดตแบบเปลี่ยนรูป
        $sql = "UPDATE lessons SET title='$title', category='$category', thumbnail='$filename', content_link='$link', description='$description' WHERE id=$id";
    } else {
        // อัปเดตแบบไม่เปลี่ยนรูป (ใช้รูปเดิม)
        $sql = "UPDATE lessons SET title='$title', category='$category', content_link='$link', description='$description' WHERE id=$id";
    }

    if ($conn->query($sql)) {
        echo "<script>alert('แก้ไขสำเร็จ!'); window.location='edit-list.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขบทเรียน 📝</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; padding: 20px; }
        .edit-form { background: white; padding: 30px; border-radius: 15px; max-width: 600px; margin: auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        input, select, textarea, button { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        button { background: #4ecdc4; color: white; border: none; font-weight: bold; cursor: pointer; }
        .current-img { margin: 10px 0; display: block; border-radius: 8px; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <div class="edit-form">
        <h2>แก้ไขบทเรียน: <?php echo $data['title']; ?></h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label>ชื่อบทเรียน:</label>
            <input type="text" name="title" value="<?php echo $data['title']; ?>" required>
            
            <label>หมวดหมู่:</label>
            <select name="category">
                <option value="วิทยาศาสตร์" <?php if($data['category']=='วิทยาศาสตร์') echo 'selected'; ?>>วิทยาศาสตร์</option>
                <option value="คณิตศาสตร์" <?php if($data['category']=='คณิตศาสตร์') echo 'selected'; ?>>คณิตศาสตร์</option>
            </select>

            <label>รายละเอียดสั้นๆ:</label>
            <textarea name="description" rows="3"><?php echo $data['description']; ?></textarea>

            <label>ลิงก์บทความ (URL):</label>
            <input type="text" name="link" value="<?php echo $data['content_link']; ?>" required>

            <label>รูปเดิม:</label>
            <img src="../uploads/<?php echo $data['thumbnail']; ?>" width="150" class="current-img">
            
            <label>เปลี่ยนรูปใหม่ (ถ้าไม่เปลี่ยนให้เว้นว่างไว้):</label>
            <input type="file" name="thumb" accept="image/*">

            <button type="submit" name="update_lesson">บันทึกการเปลี่ยนแปลง ✨</button>
            <a href="edit-list.php" style="display:block; text-align:center; color:#888; text-decoration:none; margin-top:10px;">ยกเลิก</a>
        </form>
    </div>
</body>
</html>