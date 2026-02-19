<?php
// 1. ตั้งค่าการเชื่อมต่อฐานข้อมูล
//Localhost
// $servername = "localhost";
// $username = "root";      // ปกติ XAMPP ใช้ root
// $password = "";          // ปกติ XAMPP รหัสผ่านว่าง
// $dbname = "kids_learning";


// 1. ตั้งค่าการเชื่อมต่อฐานข้อมูล
//Production Server
$servername = "Production";
$username = "u225725850_root";      // ปกติ XAMPP ใช้ root
$password = "iE2/^tiB#9!j";          // ปกติ XAMPP รหัสผ่านว่าง
$dbname = "u225725850_kids_learning";

// 2. สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// 3. ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    // ถ้าเชื่อมต่อไม่ได้ ให้แสดงข้อความเตือน
    die("<div style='color:red; text-align:center; padding:20px; font-family:sans-serif;'>
            <h2>เชื่อมต่อฐานข้อมูลไม่สำเร็จ 🔌</h2>
            <p>กรุณาตรวจสอบชื่อ Database หรือเปิด MySQL ใน XAMPP Control Panel</p>
            <small>" . $conn->connect_error . "</small>
         </div>");
}

// 4. ตั้งค่า Encoding ให้รองรับภาษาไทย (utf8mb4)
// เพื่อไม่ให้ตัวอักษรกลายเป็นเครื่องหมายคำถาม ????
$conn->set_charset("utf8mb4");

// หมายเหตุ: ไม่ต้องปิดแท็ก ?> 

<? //ถ้าไฟล์นี้มีแต่ code PHP เพื่อป้องกันปัญหา Header Already Sent ?>