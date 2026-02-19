<?php
// 1. เชื่อมต่อฐานข้อมูล
//$conn = new mysqli("localhost", "root", "", "kids_learning");
//$conn->set_charset("utf8mb4");

require_once 'includes/db_connect.php'; 

// 2. ระบบค้นหาแบบง่าย
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT * FROM lessons WHERE title LIKE '%$search%' OR category LIKE '%$search%' ORDER BY id DESC";
$result = $conn->query($sql);

// 3. ดึงข้อมูลดาวรวมของผู้ใช้ (สมมติ user_id = 1)
$progress = $conn->query("SELECT total_stars FROM user_progress WHERE user_id = 1")->fetch_assoc();
$stars = $progress['total_stars'];

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DooDoo Learn - ผจญภัยโลกความรู้ 🚀</title>
    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #ff6b6b;
            --secondary: #4ecdc4;
            --sunny: #ffbe76;
            --bg: #f0f7ff;
        }

        body {
            font-family: 'Itim', cursive;
            background-color: var(--bg);
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Header สุดน่ารัก */
        header {
            background: linear-gradient(135deg, var(--secondary), #45b7af);
            padding: 40px 20px;
            text-align: center;
            color: white;
            border-bottom-left-radius: 50px;
            border-bottom-right-radius: 50px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 3rem;
            margin: 0;
            text-shadow: 3px 3px 0px rgba(0, 0, 0, 0.1);
        }

        p {
            font-size: 1.5rem;
            opacity: 0.9;
        }

        /* ช่องค้นหาแว่นขยาย */
        .search-box {
            margin-top: -30px;
            display: flex;
            justify-content: center;
        }

        .search-box input {
            width: 80%;
            max-width: 500px;
            padding: 20px 30px;
            border-radius: 50px;
            border: 5px solid white;
            font-size: 1.2rem;
            font-family: 'Itim';
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            outline: none;
        }

        /* Grid บทเรียนแบบ Card เกม */
        .container {
            padding: 50px 20px;
            max-width: 1100px;
            margin: auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
        }

        .card {
            background: white;
            border-radius: 30px;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-decoration: none;
            color: inherit;
            border: 4px solid transparent;
            position: relative;
        }

        .card:hover {
            transform: translateY(-15px) scale(1.03);
            border-color: var(--sunny);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .thumb-container {
            width: 100%;
            height: 180px;
            background: #eee;
            position: relative;
        }

        .thumb-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .category-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--primary);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
        }

        .card-content {
            padding: 20px;
            text-align: center;
        }

        .card-content h3 {
            font-size: 1.6rem;
            margin: 10px 0;
            color: #2d3436;
        }

        .card-content p {
            font-size: 1.1rem;
            color: #636e72;
            margin: 0;
        }

        .btn-play {
            background: var(--secondary);
            color: white;
            padding: 10px 25px;
            border-radius: 50px;
            display: inline-block;
            margin-top: 15px;
            font-weight: bold;
        }

        /* Floating Donation & Admin */
        .admin-link {
            position: fixed;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.8);
            padding: 8px 15px;
            border-radius: 20px;
            text-decoration: none;
            color: #666;
            font-size: 0.9rem;
        }

        /* --- CSS Donation (จากที่ออกแบบไว้เดิม) --- */
        .floating-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #ff813f;
            color: white;
            padding: 15px 25px;
            border-radius: 50px;
            cursor: pointer;
            display: flex;
            align-items: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            z-index: 99;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
        }

        .modal-content {
            background: white;
            margin: 10% auto;
            padding: 30px;
            width: 90%;
            max-width: 400px;
            border-radius: 30px;
            text-align: center;
        }


        /* สมุดดาว */
        .star-notebook {
            background: white;
            max-width: 400px;
            margin: 0 auto 20px;
            padding: 15px;
            border-radius: 25px;
            box-shadow: 0 8px 0 #bdc3c7;
            border: 3px solid #f1f1f1;
            text-align: center;
        }

        .star-badge {
            font-size: 1.5rem;
            font-weight: bold;
            color: #f1c40f;
        }

        .star-icon {
            font-size: 2rem;
        }

        .progress-bar-container {
            background: #ecf0f1;
            height: 15px;
            border-radius: 10px;
            margin-top: 10px;
            overflow: hidden;
            position: relative;
        }

        .progress-bar {
            background: linear-gradient(90deg, #f1c40f, #f39c12);
            height: 100%;
            transition: width 0.5s ease;
        }
    </style>
</head>

<body>

    <a href="admin/" class="admin-link">สำหรับผู้ปกครอง ⚙️</a>

    <header>
        <h1>DooDoo Learn 🌈</h1>
        <p>วันนี้อยากเก่งเรื่องอะไรดีจ๊ะเด็กๆ?</p>
    </header>

    <div class="search-box">
        <form action="" method="GET" style="width: 100%; text-align: center;">
            <input type="text" name="search" placeholder="🔍 ค้นหาบทเรียนสนุกๆ..."
                value="<?php echo htmlspecialchars($search); ?>">
        </form>
    </div>

    <div class="container">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <a href="<?php echo $row['content_link']; ?>" class="card">
                    <div class="thumb-container">
                        <span class="category-badge"><?php echo $row['category']; ?></span>
                        <img src="uploads/<?php echo $row['thumbnail']; ?>" alt="บทเรียน">
                    </div>
                    <div class="card-content">
                        <h3><?php echo $row['title']; ?></h3>
                        <p>มาสนุกด้วยกันเถอะ!</p>
                        <div class="btn-play">เริ่มเล่นเลย 🎮</div>
                    </div>
                </a>
            <?php endwhile; ?>
        <?php else: ?>
            <div style="grid-column: 1/-1; text-align: center;">
                <img src="https://cdn-icons-png.flaticon.com/512/6134/6134065.png" width="150">
                <h2>หาไม่เจอเลย... ลองใช้คำอื่นดูนะ!</h2>
            </div>
        <?php endif; ?>
    </div>

    <div class="star-notebook">
        <div class="star-badge">
            <span class="star-icon">⭐</span>
            <span class="star-count">สะสมได้ <?php echo $stars; ?> ดวงแล้ว!</span>
        </div>
        <div class="progress-bar-container">
            <p>อีก <?php echo (10 - ($stars % 10)); ?> ดวงจะได้รางวัลใหญ่!</p>
            <div class="progress-bar" style="width: <?php echo ($stars % 10) * 10; ?>%;"></div>
        </div>
    </div>

    <div class="floating-btn" onclick="document.getElementById('donModal').style.display='block'">
        <span style="font-size: 1.5rem; margin-right: 10px;">☕</span> เลี้ยงกาแฟทีมงาน
    </div>

    <div id="donModal" class="modal">
        <div class="modal-content">
            <span style="float:right; cursor:pointer;"
                onclick="document.getElementById('donModal').style.display='none'">❌</span>
            <h2>สนับสนุน DooDoo Learn 💖</h2>
            <p>สแกน PromptPay เพื่อสนับสนุนเรา</p>
            <img src="assets/img/qr-code-image.jpg" width="250" style="border-radius: 15px;">
            <p>ขอบคุณทุกความใจดีนะครับ!</p>
        </div>
    </div>

</body>

</html>