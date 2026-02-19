<?php
//$conn = new mysqli("localhost", "root", "", "kids_learning");
//$conn->set_charset("utf8mb4");

require_once '../includes/db_connect.php';

$sql = "SELECT * FROM worksheets ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>คลังใบงานสำหรับคุณหนู 📝 | DooDoo Learn</title>
    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Itim', cursive;
            background: #fffcf2;
            margin: 0;
            padding: 0;
        }

        .header {
            background: #ffbe76;
            padding: 40px;
            text-align: center;
            color: white;
        }

        .grid-container {
            max-width: 1100px;
            margin: 40px auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            padding: 0 20px;
        }

        .ws-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border: 2px solid #eee;
            transition: 0.3s;
            position: relative;
        }

        .ws-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* ส่วน Preview รูปภาพ */
        .preview-box {
            width: 100%;
            height: 350px;
            background: #f9f9f9;
            overflow: hidden;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: zoom-in;
            position: relative;
        }

        .preview-box img {
            width: 90%;
            height: auto;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        }

        /* ป้ายสถานะ */
        .badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: bold;
        }

        .free {
            background: #4ecdc4;
            color: white;
        }

        .premium {
            background: #ff6b6b;
            color: white;
        }

        .ws-info {
            padding: 20px;
            text-align: center;
        }

        .btn-download {
            display: block;
            width: 100%;
            padding: 12px;
            background: #d35400;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            margin-top: 10px;
            transition: 0.2s;
        }

        .btn-download:hover {
            background: #e67e22;
        }

        /* Modal สำหรับดูรูปขยาย */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            padding-top: 50px;
        }

        .modal-img {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 600px;
        }
    </style>
</head>

<body>
    <?php include 'admin_header.php'; ?>
    <div class="header">
        <h1>คลังใบงานแสนสนุก 📄</h1>
        <p>ดาวน์โหลดไปฝึกฝนที่บ้าน ช่วยให้เด็กๆ เก่งไวขึ้น!</p>
    </div>

    <div class="grid-container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="ws-card">
                <div class="preview-box" onclick="openPreview('../uploads/previews/<?php echo $row['preview_image']; ?>')">
                    <span class="badge <?php echo $row['is_premium'] ? 'premium' : 'free'; ?>">
                        <?php echo $row['is_premium'] ? '⭐ Premium' : 'Free'; ?>
                    </span>
                    <img src="../uploads/previews/<?php echo $row['preview_image']; ?>" alt="ตัวอย่างใบงาน">
                </div>

                <div class="ws-info">
                    <h3><?php echo $row['title']; ?></h3>
                    <?php if ($row['is_premium']): ?>
                        <p style="color: #666; font-size: 0.9rem;">เฉพาะสมาชิกพิเศษเท่านั้น</p>
                        <a href="subscription.php" class="btn-download" style="background:#6c5ce7;">สมัครสมาชิกเพื่อโหลด</a>
                    <?php else: ?>
                        <p style="color: #666; font-size: 0.9rem;">ดาวน์โหลดฟรี!</p>
                        <!--<a href="uploads/files/<?php echo $row['file_path']; ?>" class="btn-download" download>ดาวน์โหลด PDF</a>-->
                        <a href="../services/download_counter.php?id=<?php echo $row['id']; ?>" class="btn-download">
                            ดาวน์โหลด (PDF) 📥
                        </a>

                        <span class="download-tag">
                            ยอดดาวน์โหลด:
                            <?php echo number_format($row['download_count']); ?> ครั้ง
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <div id="imgModal" class="modal" onclick="this.style.display='none'">
        <img class="modal-img" id="fullImg">
        <div style="color:white; text-align:center; margin-top:20px;">คลิกที่ไหนก็ได้เพื่อปิด</div>
    </div>

    <script>
        function openPreview(src) {
            document.getElementById('fullImg').src = src;
            document.getElementById('imgModal').style.display = 'block';
        }
    </script>

</body>

</html>