<?php
require_once '../includes/db_connect.php';  // ไฟล์เชื่อมต่อ DB
$res = $conn->query("SELECT total_stars FROM user_progress WHERE user_id = 1");
$row = $res->fetch_assoc();
$current_stars = $row['total_stars'];
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หนูน้อยเก่งนาฬิกา ⏰ - Game Edition</title>
   
    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/firework.css">
    <link rel="stylesheet" href="../assets/css/body_content_states_of_matter.css">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <style>
        :root {
            --primary-color: #ff6b6b;
            --secondary-color: #4ecdc4;
            --accent-color: #ffbe76;
            --bg-color: #f0f7ff;
            --morning: #fff9c4;
            --afternoon: #ffecb3;
            --evening: #ffe0b2;
            --night: #d1c4e9;
        }

        body {
            font-family: 'Itim', cursive;
            background-color: var(--bg-color);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            color: #333;
            overflow-x: hidden;
            position: relative;
            /* สำคัญสำหรับปุ่มลอย */
        }

        .game-card {
            background: white;
            padding: 20px;
            border-radius: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 500px;
            border: 4px solid var(--secondary-color);
            margin-bottom: 30px;
        }

        h1 {
            color: var(--primary-color);
            font-size: 2.2rem;
            margin: 10px 0;
        }

        /* ส่วนของภารกิจ */
        .mission-box {
            background: var(--accent-color);
            padding: 15px;
            border-radius: 15px;
            margin-bottom: 20px;
            font-size: 1.4rem;
            font-weight: bold;
            color: #d35400;
            border: 3px dashed #e67e22;
        }

        /* สไตล์ของนาฬิกา */
        .clock-container {
            position: relative;
            width: 220px;
            height: 220px;
            background: white;
            border: 10px solid #333;
            border-radius: 50%;
            margin: 20px auto;
        }

        .center-dot {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 12px;
            height: 12px;
            background: #333;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
        }

        .hand {
            position: absolute;
            bottom: 50%;
            left: 50%;
            transform-origin: bottom;
            border-radius: 10px;
        }

        .hour-hand {
            width: 8px;
            height: 55px;
            background: #333;
            z-index: 5;
        }

        .min-hand {
            width: 5px;
            height: 85px;
            background: var(--primary-color);
            z-index: 4;
        }

        .number {
            position: absolute;
            width: 100%;
            height: 100%;
            text-align: center;
            font-size: 1.1rem;
            font-weight: bold;
            padding: 8px;
            box-sizing: border-box;
        }

        /* ส่วนควบคุม */
        input[type=range] {
            width: 90%;
            height: 15px;
            background: #ddd;
            border-radius: 10px;
            appearance: none;
            margin: 25px 0;
        }

        input[type=range]::-webkit-slider-thumb {
            appearance: none;
            width: 30px;
            height: 30px;
            /* เพิ่มขนาด Thumb เพื่อให้เด็กแตะง่าย */
            background: var(--primary-color);
            border-radius: 50%;
            cursor: pointer;
            border: 3px solid white;
        }

        .feedback {
            font-size: 1.2rem;
            height: 30px;
            margin-top: 10px;
            font-weight: bold;
        }

        .btn-random {
            background: var(--secondary-color);
            color: white;
            border: none;
            padding: 10px 25px;
            font-size: 1.2rem;
            border-radius: 50px;
            cursor: pointer;
            font-family: 'Itim';
            transition: 0.2s;
            margin-top: 10px;
        }

        .btn-random:hover {
            transform: scale(1.05);
            background: #3db7ae;
        }

        .thai-call {
            font-size: 1.5rem;
            color: #555;
            margin-top: 10px;
            display: block;
        }

        /* Table Styles */
        .summary-table {
            width: 100%;
            max-width: 500px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border-collapse: collapse;
            margin-top: 30px;
        }

        .summary-table th {
            background: var(--secondary-color);
            color: white;
            padding: 10px;
            font-size: 1.2rem;
        }

        .summary-table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #eee;
            font-size: 1.1rem;
        }

        .row-morning {
            background-color: var(--morning);
        }

        .row-afternoon {
            background-color: var(--afternoon);
        }

        .row-night {
            background-color: var(--night);
        }

        /* --- ปุ่มกลับหน้าหลัก (ใหม่) --- */
        .home-button {
            position: fixed;
            top: 20px;
            left: 20px;
            background: #ffeaa7;
            /* สีเหลืองสดใส */
            color: #d63031;
            /* สีแดงสำหรับไอคอน */
            padding: 10px 15px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: transform 0.2s, background 0.2s;
            z-index: 100;
        }

        .home-button:hover {
            transform: scale(1.05);
            background: #ffe38f;
        }

        .home-button .icon-home {
            font-size: 2.5rem;
            /* ไอคอนรูปบ้านขนาดใหญ่ */
            margin-right: 8px;
        }

        .home-button .text-home {
            font-family: 'Itim', cursive;
            font-size: 1.2rem;
            /* ตัวหนังสือ "กลับบ้าน" */
            font-weight: bold;
            display: none;
            /* ซ่อนตอนปกติ */
        }

        @media (min-width: 768px) {

            /* แสดงข้อความเมื่อหน้าจอใหญ่ขึ้น */
            .home-button .text-home {
                display: inline;
            }
        }
    </style>

</head>

<body>

    <?php
    require_once '../includes/menu_home.php';
    ?>

   
            <div class="game-card">
        <h1>เรียนรู้เรื่องเวลา ⏰</h1>
        <div class="mission-box" id="missionText">รอสักครู่...</div>

        <div class="clock-container">
            <div class="center-dot"></div>
            <div class="hand hour-hand" id="hourHand"></div>
            <div class="hand min-hand" id="minHand"></div>
            <div id="numbers"></div>
        </div>

        <input type="range" id="timeSlider" min="0" max="1439" value="480">
        <button class="btn-random" onclick="submitClockAnswer()" style="background: #2ecc71;">ส่งคำตอบรับดาว ⭐</button>
        <div id="digitalTime" style="font-size: 1.8rem; font-weight: bold;">08:00</div>
        <div id="thaiCall" style="font-size: 1.5rem; color: #555; margin-bottom: 10px;">แปดโมงเช้า</div>
        <div id="feedback" style="font-size: 1.2rem; font-weight: bold; height: 30px;"></div>

        <button class="btn-random" onclick="generateMission()">เปลี่ยนโจทย์ใหม่ 🎲</button>
    </div>
    

        <h3>ตะลุยตารางเวลาภาษาไทย 🇹🇭</h3>
    <table class="summary-table">
        <thead>
            <tr>
                <th>เวลาสากล</th>
                <th>คนไทยเรียกแบบนี้</th>
            </tr>
        </thead>
        <tbody>
            <tr class="row-morning">
                <td>07:00 - 11:00</td>
                <td><b>โมงเช้า</b> (1 ถึง 5 โมงเช้า)</td>
            </tr>
            <tr class="row-afternoon">
                <td>12:00</td>
                <td><b>เที่ยงวัน</b> ☀️</td>
            </tr>
            <tr class="row-afternoon">
                <td>13:00 - 15:00</td>
                <td><b>บ่าย...โมง</b> (บ่าย 1 ถึง 3)</td>
            </tr>
            <tr class="row-afternoon">
                <td>16:00 - 18:00</td>
                <td><b>โมงเย็น</b> (4 ถึง 6 โมงเย็น)</td>
            </tr>
            <tr class="row-night">
                <td>19:00 - 23:00</td>
                <td><b>ทุ่ม</b> (1 ถึง 5 ทุ่ม) 🌙</td>
            </tr>
            <tr class="row-night">
                <td>00:00</td>
                <td><b>เที่ยงคืน</b> 😴</td>
            </tr>
            <tr class="row-night">
                <td>01:00 - 05:00</td>
                <td><b>ตี...</b> (ตี 1 ถึง 5)</td>
            </tr>
        </tbody>
    </table>


    

    <script>
        const hourHand = document.getElementById('hourHand');
        const minHand = document.getElementById('minHand');
        const timeSlider = document.getElementById('timeSlider');
        const digitalTime = document.getElementById('digitalTime');
        const thaiCall = document.getElementById('thaiCall');
        const missionText = document.getElementById('missionText');
        const feedback = document.getElementById('feedback');

        let targetHour = 8;
        let targetMin = 0;

        const numbersContainer = document.getElementById('numbers');
        for (let i = 1; i <= 12; i++) {
            const numDiv = document.createElement('div');
            numDiv.className = 'number';
            numDiv.style.transform = `rotate(${i * 30}deg)`;
            numDiv.innerHTML = `<span style="display:inline-block; transform:rotate(-${i * 30}deg)">${i}</span>`;
            numbersContainer.appendChild(numDiv);
        }

        function getThaiTime(h, m) {
            let suffix = m > 0 ? ` ${m} นาที` : "";
            if (h === 0) return "เที่ยงคืน" + suffix;
            if (h >= 1 && h <= 5) return "ตี " + h + suffix;
            if (h === 6) return "หกโมงเช้า" + suffix;
            if (h >= 7 && h <= 11) return (h - 6) + " โมงเช้า" + suffix;
            if (h === 12) return "เที่ยงวัน" + suffix;
            if (h >= 13 && h <= 15) return "บ่าย " + (h - 12) + " โมง" + suffix;
            if (h >= 16 && h <= 18) return (h - 12) + " โมงเย็น" + suffix;
            if (h >= 19 && h <= 23) return (h - 18) + " ทุ่ม" + suffix;
            return "";
        }

        function updateClock() {
            const totalMinutes = parseInt(timeSlider.value);
            const hours = Math.floor(totalMinutes / 60);
            const minutes = totalMinutes % 60;
            hourHand.style.transform = `translateX(-50%) rotate(${(hours * 30) + (minutes * 0.5)}deg)`;
            minHand.style.transform = `translateX(-50%) rotate(${minutes * 6}deg)`;
            digitalTime.innerText = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;
            thaiCall.innerText = getThaiTime(hours, minutes);

            if (hours === targetHour && minutes === targetMin) {
                feedback.innerText = "✨ เก่งที่สุด! ถูกต้องครับ ✨";
                feedback.style.color = "#27ae60";
            } else {
                feedback.innerText = "ลองเลื่อนต่อไปนะ...";
                feedback.style.color = "#95a5a6";
            }
        }

        function generateMission() {
            const times = [
                { h: 7, m: 0 }, { h: 10, m: 0 }, { h: 13, m: 0 },
                { h: 17, m: 0 }, { h: 19, m: 0 }, { h: 21, m: 0 }, { h: 2, m: 0 },
                { h: 8, m: 30 }, { h: 14, m: 30 }, { h: 20, m: 30 } // เพิ่ม 30 นาที
            ];
            const pick = times[Math.floor(Math.random() * times.length)];
            targetHour = pick.h;
            targetMin = pick.m;
            missionText.innerText = `โจทย์: ไหนลองทำเวลา "${getThaiTime(targetHour, targetMin)}" ซิ!`;
            feedback.innerText = "";
        }

        timeSlider.addEventListener('input', updateClock);
        generateMission();
        updateClock();


        // เพิ่มฟังก์ชันนี้ลงใน <script> ของ clock-page.html

        function submitClockAnswer() {
            const totalMinutes = parseInt(timeSlider.value);
            const hours = Math.floor(totalMinutes / 60);
            const minutes = totalMinutes % 60;

            if (hours === targetHour && minutes === targetMin) {
                // ถ้าถูก ยิงไปเก็บดาว
                fetch('../services/add_star.php')
                    .then(response => response.text())
                    .then(data => {
                        if (data === "Success") {
                            celebrate();
                            refreshMission(true); // เล่นเสียงและพลุ
                            alert("เก่งมาก! รับดาวเพิ่ม 1 ดวง ⭐");
                            //showStarAnimation();
                            // อาจจะสุ่มโจทย์ใหม่ต่อเลย
                            generateMission();
                        }
                    });
            } else {
                alert("ยังไม่ถูกนะ ลองดูเข็มสั้นเข็มยาวอีกทีครับ 🧐");
            }
        }

        // และเพิ่มปุ่มนี้ไว้ใต้ Slider หรือปุ่มเปลี่ยนโจทย์
        // <button class="btn-random" onclick="submitClockAnswer()" style="background: #2ecc71;">ส่งคำตอบรับดาว ⭐</button>

        
        // function showStarAnimation() {
        //     // สร้าง Element ดาวลอยขึ้นมา
        //     const star = document.createElement('div');
        //     star.innerHTML = "⭐";
        //     star.style.position = "fixed";
        //     star.style.bottom = "50%";
        //     star.style.left = "50%";
        //     star.style.fontSize = "5rem";
        //     star.style.transition = "all 1s ease-in-out";
        //     star.style.zIndex = "1000";
        //     document.body.appendChild(star);

        //     setTimeout(() => {
        //         star.style.transform = "translate(-50%, -200%) scale(2)";
        //         star.style.opacity = "0";
        //     }, 100);
        // }

    </script>

<script>
        // --- 2. ตั้งค่าเสียง ---
        const sounds = {
            success: new Audio('https://assets.mixkit.co/active_storage/sfx/2013/2013-preview.mp3'),
            cheer: new Audio('https://assets.mixkit.co/active_storage/sfx/1435/1435-preview.mp3'),
            error: new Audio('https://assets.mixkit.co/active_storage/sfx/2571/2571-preview.mp3'),
            click: new Audio('https://assets.mixkit.co/active_storage/sfx/2568/2568-preview.mp3') // เสียงคลิกเบาๆ
        };

        // const missions = [
        //     { id: 'solid', text: 'โมเลกุลชิดกันแน่น เรียงตัวเป็นระเบียบ' },
        //     { id: 'solid', text: 'รักษารูปร่างได้เอง ไม่เปลี่ยนตามภาชนะ' },
        //     { id: 'liquid', text: 'โมเลกุลอยู่ใกล้กัน แต่ไหลไปมาได้' },
        //     { id: 'liquid', text: 'เปลี่ยนรูปร่างตามภาชนะ แต่ปริมาตรเท่าเดิม' },
        //     { id: 'gas', text: 'โมเลกุลอยู่ห่างกันมาก ฟุ้งกระจายอิสระ' },
        //     { id: 'gas', text: 'ไม่มีรูปร่างแน่นอน และฟุ้งเต็มภาชนะเสมอ' }
        // ];

        // let currentMission;

        // ฟังก์ชันสุ่มโจทย์ใหม่
        function refreshMission(playSound = false) {
            // ถ้า playSound เป็น true ถึงจะเล่นเสียง (ใช้ตอนกดปุ่ม)
            if (playSound) {
                sounds.click.play().catch(e => console.log("Audio play prevented"));
            }

            // const oldMission = currentMission;

            // do {
            //     currentMission = missions[Math.floor(Math.random() * missions.length)];
            // } while (oldMission && currentMission.text === oldMission.text);

            // document.getElementById('target-text').innerText = currentMission.text;
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

     
    </script>


</body>

</html>