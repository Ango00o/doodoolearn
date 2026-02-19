<?php require_once '../includes/db_connect.php'; ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการใบงาน - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .admin-container { max-width: 1000px; margin: 20px auto; padding: 20px; font-family: sans-serif; }
        .upload-card { background: #fff; padding: 20px; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #34495e; color: white; }
        .img-thumb { width: 60px; height: 80px; object-fit: cover; border-radius: 5px; }
        .btn-delete { background: #ff4757; color: white; padding: 5px 12px; border-radius: 5px; text-decoration: none; font-size: 0.9rem; }
        .btn-delete:hover { background: #ff6b81; }
        .form-group { margin-bottom: 15px; }
        input[type="text"], input[type="file"] { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ddd; border-radius: 5px; }
    </style>
</head>
<body>
    <?php include 'admin_header.php'; ?>

    <div class="admin-container">
        <div class="upload-card">
            <h3>➕ เพิ่มใบงานใหม่</h3>
            <form action="upload_ws.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>ชื่อใบงาน:</label>
                    <input type="text" name="title" placeholder="เช่น แบบฝึกหัดบวกเลข" required>
                </div>
                <div style="display: flex; gap: 20px;">
                    <div class="form-group">
                        <label>รูปตัวอย่าง:</label>
                        <input type="file" name="preview_image" accept="image/*" required>
                    </div>
                    <div class="form-group">
                        <label>ไฟล์ PDF:</label>
                        <input type="file" name="file_path" accept=".pdf" required>
                    </div>
                </div>
                <button type="submit" style="background: #27ae60; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: bold;">อัปโหลดใบงาน</button>
            </form>
        </div>

        <h3>รายการใบงานทั้งหมด</h3>
        <table>
            <thead>
                <tr>
                    <th>ตัวอย่าง</th>
                    <th>ชื่อใบงาน</th>
                    <th>วันที่เพิ่ม</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM worksheets ORDER BY id DESC");
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td><img src='../uploads/previews/{$row['preview_image']}' class='img-thumb'></td>
                        <td>{$row['title']}</td>
                        <td>{$row['created_at']}</td>
                        <td>
                            <a href='admin_delete_ws.php?id={$row['id']}' class='btn-delete' onclick='return confirm(\"ยืนยันการลบใบงานนี้?\")'>ลบ</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>