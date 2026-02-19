<?php 
require_once '../includes/db_connect.php'; 

// 1. ดึงข้อมูลสรุปภาพรวม
$total_stars_res = $conn->query("SELECT SUM(total_stars) as all_stars FROM user_progress");
$total_stars = $total_stars_res->fetch_assoc()['all_stars'] ?? 0;

$total_ws_res = $conn->query("SELECT SUM(download_count) as all_dl FROM worksheets");
$total_dl = $total_ws_res->fetch_assoc()['all_dl'] ?? 0;

$total_lessons_res = $conn->query("SELECT COUNT(*) as count FROM lessons");
$total_lessons = $total_lessons_res->fetch_assoc()['count'] ?? 0;
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สถิติการเรียนรู้ - Admin</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .stats-container { max-width: 1000px; margin: 20px auto; padding: 20px; font-family: 'Itim', sans-serif; }
        
        /* สไตล์ Dashboard Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 8px 15px rgba(0,0,0,0.05);
            border-bottom: 5px solid #3498db;
        }
        .stat-card h3 { margin: 0; color: #7f8c8d; font-size: 1.1rem; }
        .stat-card .number { font-size: 2.5rem; font-weight: bold; color: #2c3e50; margin: 10px 0; }
        .card-blue { border-color: #3498db; }
        .card-yellow { border-color: #f1c40f; }
        .card-green { border-color: #2ecc71; }

        /* สไตล์ตาราง */
        .table-section {
            background: white;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 8px 15px rgba(0,0,0,0.05);
        }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { color: #34495e; font-size: 1.1rem; }
        .badge {
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.9rem;
            background: #e8f4fd;
            color: #3498db;
        }
    </style>
</head>
<body>
    <?php include 'admin_header.php'; ?>

    <div class="stats-container">
        <h2 style="margin-bottom: 25px;">📊 ภาพรวมการเรียนรู้</h2>

        <div class="stats-grid">
            <div class="stat-card card-yellow">
                <h3>ดาวทั้งหมดที่ได้รับ</h3>
                <div class="number">⭐ <?php echo $total_stars; ?></div>
            </div>
            <div class="stat-card card-blue">
                <h3>ใบงานที่ถูกดาวน์โหลด</h3>
                <div class="number">📥 <?php echo $total_dl; ?></div>
            </div>
            <div class="stat-card card-green">
                <h3>บทเรียนในระบบ</h3>
                <div class="number">📚 <?php echo $total_lessons; ?></div>
            </div>
        </div>

        <div class="table-section">
            <h3>📈 อันดับใบงานยอดนิยม</h3>
            <table>
                <thead>
                    <tr>
                        <th>ชื่อใบงาน</th>
                        <th>ยอดดาวน์โหลด</th>
                        <th>สถานะ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $ws_sql = "SELECT title, download_count FROM worksheets ORDER BY download_count DESC LIMIT 5";
                    $ws_res = $conn->query($ws_sql);
                    while($row = $ws_res->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['title']}</td>
                            <td><b>{$row['download_count']}</b> ครั้ง</td>
                            <td><span class='badge'>ยอดนิยม</span></td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>