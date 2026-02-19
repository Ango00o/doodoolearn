<?php
    require_once '../includes/db_connect.php'; ; // ไฟล์เชื่อมต่อ DB
    $res = $conn->query("SELECT total_stars FROM user_progress WHERE user_id = 1");
    $row = $res->fetch_assoc();
    $current_stars = $row['total_stars'];
?>
<!doctype html>
<html lang="th">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>เครื่องวัดอุณหภูมิแสนสนุก 🌡️</title>
       <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/firework.css">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <style>
      body {
        font-family: "Itim", cursive;
        text-align: center;
        background: #e0f7fa;
        padding: 20px;
        position: relative; /* สำคัญสำหรับปุ่มลอย */
      }
      .temp-container {
        display: flex;
        justify-content: center;
        align-items: flex-end;
        height: 400px;
        margin-top: 50px;
      }

      /* สไตล์เทอร์โมมิเตอร์ */
      .thermometer {
        width: 40px;
        height: 300px;
        background: #ddd;
        border: 5px solid #333;
        border-radius: 20px;
        position: relative;
        overflow: hidden;
      }
      .mercury {
        width: 100%;
        background: linear-gradient(to top, #ff4757, #ff6b81);
        position: absolute;
        bottom: 0;
        transition: height 0.3s;
      }

      /* ส่วนภาพประกอบ */
      .status-box {
        margin-top: 20px;
        font-size: 2rem;
      }
      .visual-aid {
        font-size: 5rem;
        margin-top: 20px;
        height: 100px;
      }
      input[type="range"] {
        width: 300px;
        margin-top: 40px;
      }

      /* --- ปุ่มกลับหน้าหลัก (เหมือนกับ clock-page.html) --- */
      .home-button {
        position: fixed;
        top: 20px;
        left: 20px;
        background: #ffeaa7; /* สีเหลืองสดใส */
        color: #d63031; /* สีแดงสำหรับไอคอน */
        padding: 10px 15px;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        text-decoration: none;
        display: flex;
        align-items: center;
        transition:
          transform 0.2s,
          background 0.2s;
        z-index: 100;
      }
      .home-button:hover {
        transform: scale(1.05);
        background: #ffe38f;
      }
      .home-button .icon-home {
        font-size: 2.5rem; /* ไอคอนรูปบ้านขนาดใหญ่ */
        margin-right: 8px;
      }
      .home-button .text-home {
        font-family: "Itim", cursive;
        font-size: 1.2rem; /* ตัวหนังสือ "กลับบ้าน" */
        font-weight: bold;
        display: none; /* ซ่อนตอนปกติ */
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

    <h1>เครื่องวัดอุณหภูมิแสนสนุก 🌡️</h1>
    <p>ลองเลื่อนแถบเพื่อดูว่าความร้อนทำให้อะไรเปลี่ยนไป!</p>

    <div class="temp-container">
      <div class="thermometer">
        <div class="mercury" id="mercury" style="height: 30%"></div>
      </div>
    </div>

    <div class="status-box">อุณหภูมิ: <span id="tempVal">30</span> °C</div>

    <div class="visual-aid" id="visualAid">🍦</div>
    <div id="descText" style="font-size: 1.5rem">อากาศกำลังพอดีเลย!</div>

    <input type="range" id="tempSlider" min="0" max="100" value="30" />
 <div class="mission-container">
    <div
      id="tempMission"
      class="mission-box">
      ภารกิจ: ลองทำอุณหภูมิให้ <b>"น้ำกลายเป็นน้ำแข็ง"</b> (0 องศา)
    </div>
    </div>

    <button
      id="btnSubmitTemp"
      class="btn-choice"
      style="
        background: #2ecc71;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 20px;
        font-family: &quot;Itim&quot;;
        cursor: pointer;
      "
    >
      ส่งคำตอบรับดาว ⭐
    </button>

    <script>
      const slider = document.getElementById("tempSlider");
      const mercury = document.getElementById("mercury");
      const tempVal = document.getElementById("tempVal");
      const visualAid = document.getElementById("visualAid");
      const descText = document.getElementById("descText");

      slider.oninput = function () {
        let val = this.value;
        tempVal.innerText = val;
        mercury.style.height = val + "%";

        // เปลี่ยนสถานะตามอุณหภูมิ
        if (val <= 0) {
          visualAid.innerText = "🧊";
          descText.innerText = "หนาวจัง! น้ำกลายเป็นน้ำแข็งแล้ว";
        } else if (val < 40) {
          visualAid.innerText = "🍦";
          descText.innerText = "อากาศกำลังดี ไอศกรีมยังไม่ละลาย";
        } else if (val < 80) {
          visualAid.innerText = "☀️";
          descText.innerText = "ร้อนจัง! เหงื่อเริ่มไหลแล้ว";
        } else {
          visualAid.innerText = "♨️";
          descText.innerText = "ร้อนสุดๆ! น้ำกำลังจะเดือดปุดๆ เลย";
        }
      };
    </script>

    <script>
      // เพิ่ม Logic การตรวจคำตอบ
      document.getElementById("btnSubmitTemp").onclick = function () {
        let currentTemp = parseInt(document.getElementById("tempSlider").value);

        // ตรวจสอบเงื่อนไข (สมมติว่าโจทย์คือน้ำแข็ง ต้องเป็น 0)
        if (currentTemp <= 0) {
          celebrate();
            fetch('../services/add_star.php')
            .then((response) => response.text())
            .then((data) => {
              if (data === "Success") {
                refreshMission(true); // เรียกใช้ฟังก์ชันพลุ
                alert("เย้! หนาวจนเป็นน้ำแข็งเลย รับไป 1 ดาว! ⭐");
                //location.reload(); // โหลดหน้าใหม่เพื่อรีเซ็ตโจทย์
              }
            });
        } else {
          alert("ยังหนาวไม่พอ! น้ำยังไม่แข็งเลย ลองใหม่นะ");
        }
      };


    </script>

     <script>
        // --- 2. ตั้งค่าเสียง ---
        const sounds = {
            success: new Audio('https://assets.mixkit.co/active_storage/sfx/2013/2013-preview.mp3'),
            cheer: new Audio('https://assets.mixkit.co/active_storage/sfx/1435/1435-preview.mp3'),
            error: new Audio('https://assets.mixkit.co/active_storage/sfx/2571/2571-preview.mp3'),
            click: new Audio('https://assets.mixkit.co/active_storage/sfx/2568/2568-preview.mp3') // เสียงคลิกเบาๆ
        };

       //let currentMission;

        // ฟังก์ชันสุ่มโจทย์ใหม่
        function refreshMission(playSound = false) {
            // ถ้า playSound เป็น true ถึงจะเล่นเสียง (ใช้ตอนกดปุ่ม)
            if (playSound) {
                sounds.click.play().catch(e => console.log("Audio play prevented"));
            }

            //const oldMission = currentMission;

            // do {
            //     currentMission = missions[Math.floor(Math.random() * missions.length)];
            // } while (oldMission && currentMission.text === oldMission.text);

            //document.getElementById('target-text').innerText = currentMission.text;
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
