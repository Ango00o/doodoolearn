<?php
$conn = new mysqli("localhost", "root", "", "kids_learning");
$conn->set_charset("utf8mb4");

// ดึงบทความทั้งหมด
$sql = "SELECT * FROM lessons ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการบทเรียน 🛠️</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; padding: 20px; }
        .table-container { background: white; padding: 20px; border-radius: 10px; max-width: 900px; margin: auto; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: left; }
        .btn-edit { background: #ffbe76; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px; }
        .btn-delete { background: #ff6b6b; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px; }
        img { border-radius: 5px; }
    </style>
</head>
<body>
     <?php include 'admin_header.php'; ?>
    <div class="table-container">
        <h2>รายการบทเรียนทั้งหมด 📚</h2>
        <table>
            <tr>
                <th>รูป</th>
                <th>ชื่อบทเรียน</th>
                <th>หมวดหมู่</th>
                <th>จัดการ</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><img src="../uploads/<?php echo $row['thumbnail']; ?>" width="50"></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['category']; ?></td>
                <td>
                    <a href="edit-lesson.php?id=<?php echo $row['id']; ?>" class="btn-edit">แก้ไข</a>
                    <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('แน่ใจนะว่าจะลบ?')">ลบ</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <br>
        <a href="admin.php"> กลับไปหน้าเพิ่มบทเรียน</a>
    </div>
</body>
</html>