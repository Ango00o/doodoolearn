<?php
require_once '../includes/db_connect.php'; // ไฟล์เชื่อมต่อ DB
$res = $conn->query("SELECT total_stars FROM user_progress WHERE user_id = 1");
$row = $res->fetch_assoc();
$current_stars = $row['total_stars'];
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ของแข็งหรือของเหลวกันนะ? 🧊💧</title>

    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/firework.css">
    <link rel="stylesheet" href="../assets/css/body_content_states_of_matter.css">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

</head>

<body>

    <?php
    require_once '../includes/menu_home.php';
    ?>

    <div class="container">
        <h1 class="header-title">ของแข็ง vs ของเหลว ✨</h1>
        <p style="font-size: 1.4rem;">มาช่วยกันดูซิว่า สิ่งของรอบตัวเราเป็นแบบไหน!</p>

        <div class="comparison-grid">
            <div class="card solid-card">
                <div class="icon-large">🧱</div>
                <h2>ของแข็ง (Solid)</h2>
                <ul class="fact-list">
                    <li>✅ รูปร่างเหมือนเดิมเสมอ</li>
                    <li>✅ จับแล้วรู้สึกแข็งแรง</li>
                    <li>✅ ไม่ไหลไปไหนเอง</li>
                    <li>🍎 ตัวอย่าง: แอปเปิ้ล, หิน, ของเล่น</li>
                </ul>
            </div>

            <div class="card liquid-card">
                <div class="icon-large">🥛</div>
                <h2>ของเหลว (Liquid)</h2>
                <ul class="fact-list">
                    <li>✅ เปลี่ยนรูปร่างตามภาชนะ</li>
                    <li>✅ ไหลได้ เทได้</li>
                    <li>✅ เอามือจุ่มลงไปได้</li>
                    <li>💧 ตัวอย่าง: น้ำเปล่า, นม, น้ำหวาน</li>
                </ul>
            </div>
        </div>

        <!--<div class="game-area">
            <h3>🎮 เกมทายใจ: "น้ำแข็งที่ละลาย" เป็นอะไรนะ?</h3>
            <p>ถ้าน้องๆ เอาน้ำแข็งออกมาวางทิ้งไว้จนกลายเป็นน้ำ...</p>
            <button class="btn-check" onclick="checkAnswer('solid')">เป็นของแข็ง</button>
            <button class="btn-check" onclick="checkAnswer('liquid')" style="background: var(--liquid-color);">เป็นของเหลว</button>
            <div id="result" class="result-msg"></div>
        </div> -->

        <div class="mission-container">
            <h2>🌟 ภารกิจวันนี้ 🌟</h2>
            <p>จงเลือกสถานะที่ทำให้: <br>
                <span id="target-text" class="target-highlight">กำลังสุ่มภารกิจ...</span>
            </p>
            <button class="btn-refresh" onclick="refreshMission(true)">🔄 เปลี่ยนโจทย์ใหม่</button>
        </div>

        <div style="text-align: center; margin-top: 30px;">
            <button class="btn-choice btn-solid" onclick="checkAnswer('solid')">ของแข็ง</button>
            <button class="btn-choice btn-liquid" onclick="checkAnswer('liquid')">ของเหลว</button>
            <button class="btn-choice btn-gas" onclick="checkAnswer('gas')">แก๊ส</button>
        </div>

    </div>

    <script>
        // --- 2. ตั้งค่าเสียง ---
        const sounds = {
            success: new Audio('https://assets.mixkit.co/active_storage/sfx/2013/2013-preview.mp3'),
            cheer: new Audio('https://assets.mixkit.co/active_storage/sfx/1435/1435-preview.mp3'),
            error: new Audio('https://assets.mixkit.co/active_storage/sfx/2571/2571-preview.mp3'),
            click: new Audio('https://assets.mixkit.co/active_storage/sfx/2568/2568-preview.mp3') // เสียงคลิกเบาๆ
        };

        const missions = [
            { id: 'solid', text: 'โมเลกุลชิดกันแน่น เรียงตัวเป็นระเบียบ' },
            { id: 'solid', text: 'รักษารูปร่างได้เอง ไม่เปลี่ยนตามภาชนะ' },
            { id: 'liquid', text: 'โมเลกุลอยู่ใกล้กัน แต่ไหลไปมาได้' },
            { id: 'liquid', text: 'เปลี่ยนรูปร่างตามภาชนะ แต่ปริมาตรเท่าเดิม' },
            { id: 'gas', text: 'โมเลกุลอยู่ห่างกันมาก ฟุ้งกระจายอิสระ' },
            { id: 'gas', text: 'ไม่มีรูปร่างแน่นอน และฟุ้งเต็มภาชนะเสมอ' }
        ];

        let currentMission;

        // ฟังก์ชันสุ่มโจทย์ใหม่
        function refreshMission(playSound = false) {
            // ถ้า playSound เป็น true ถึงจะเล่นเสียง (ใช้ตอนกดปุ่ม)
            if (playSound) {
                sounds.click.play().catch(e => console.log("Audio play prevented"));
            }

            const oldMission = currentMission;

            do {
                currentMission = missions[Math.floor(Math.random() * missions.length)];
            } while (oldMission && currentMission.text === oldMission.text);

            document.getElementById('target-text').innerText = currentMission.text;
        }

        // เรียกใช้งานครั้งแรกเมื่อโหลดหน้า
        refreshMission(false);

        function celebrate() {
            // เล่นเสียง success
            sounds.success.play().catch(e => console.log("Success sound error:", e.message));

            // เล่นเสียง cheer ตามมา
            setTimeout(() => {
                sounds.cheer.play().catch(e => {
                    console.log("Cheer sound error: ไฟล์เสียงอาจจะเสียหรือหาไม่เจอ", e.message);
                });
            }, 500);

            confetti({ particleCount: 100, spread: 70, origin: { x: 0, y: 0.6 } });
            confetti({ particleCount: 100, spread: 70, origin: { x: 1, y: 0.6 } });
        }

        function checkAnswer(userChoice) {
            if (userChoice === currentMission.id) {
                celebrate();
                fetch('../services/add_star.php')
                    .then(res => res.text())
                    .then(data => {
                        setTimeout(() => {
                            alert("เก่งมากเลย! รับไปเลย 1 ดาว ⭐");
                            refreshMission(true); // เปลี่ยนโจทย์ใหม่ทันทีหลังทำถูก
                        }, 2000);
                    });
            } else {
                sounds.error.play();
                alert("อ๊ะ! ยังไม่ใช่จ้า ลองอ่านคำใบ้แล้วเลือกใหม่อีกทีนะ");
            }
        }
    </script>

</body>

</html>