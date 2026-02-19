<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการสำหรับผู้ปกครองและคุณครู 🍎</title>
    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #d35400;
            --secondary: #2980b9;
            --accent: #27ae60;
            --bg: #fffaf0;
        }

        body { 
            font-family: 'Itim', cursive; 
            background: var(--bg); 
            margin: 0; padding: 0; 
        }

        .container { max-width: 900px; margin: 40px auto; padding: 20px; }
        
        .header { 
            text-align: center; 
            margin-bottom: 40px;
            padding: 30px;
            background: white;
            border-radius: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        
        .header h1 { color: var(--primary); margin: 0; font-size: 2.5rem; }
        .header p { color: #666; font-size: 1.2rem; }

        .section-title {
            margin: 30px 0 15px 10px;
            color: #444;
            font-size: 1.4rem;
            border-left: 5px solid var(--primary);
            padding-left: 15px;
        }

        .menu-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); 
            gap: 20px; 
        }

        .menu-item {
            background: white; 
            padding: 25px; 
            border-radius: 20px;
            text-align: center; 
            border: 2px solid transparent;
            text-decoration: none; 
            color: #333; 
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .menu-item:hover { 
            transform: translateY(-10px);
            border-color: var(--primary);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .icon { font-size: 3.5rem; margin-bottom: 15px; }
        .menu-item h3 { margin: 10px 0 5px 0; color: #2c3e50; }
        .menu-item p { margin: 0; color: #7f8c8d; font-size: 0.95rem; }

        .btn-back {
            display: inline-block;
            margin-top: 40px;
            text-decoration: none;
            color: var(--secondary);
            font-weight: bold;
            font-size: 1.1rem;
        }
        .btn-back:hover { text-decoration: underline; }

        /* Badge สำหรับบอกจำนวน (สมมติ) */
        .badge {
            background: #e74c3c;
            color: white;
            padding: 2px 10px;
            border-radius: 10px;
            font-size: 0.8rem;
            margin-left: 5px;
        }
    </style>
</head>
<body>

<div style="text-align: center; margin-bottom: 20px;">
    <a href="../" style="background: #2ecc71; color: white; padding: 12px 25px; border-radius: 50px; text-decoration: none; display: inline-block; font-weight: bold;">
        ⬅️ ออกจากโหมดผู้ปกครอง (ไปหน้าเด็กเรียน)
    </a>
</div>

    <div class="container">
        <div class="header">
            <h1>พื้นที่คุณครูและผู้ปกครอง 🍏</h1>
            <p>จัดการความรู้และสื่อการสอนให้เด็กๆ ได้ที่นี่</p>
        </div>

        <div class="section-title">จัดการบทเรียน</div>
        <div class="menu-grid">
            <a href="admin.php" class="menu-item">
                <span class="icon">✨</span>
                <h3>เพิ่มบทเรียนใหม่</h3>
                <p>สร้างบทความหรือบทเรียนใหม่ลงเว็บ</p>
            </a>

            <a href="edit-list.php" class="menu-item">
                <span class="icon">🛠️</span>
                <h3>จัดการบทเรียน</h3>
                <p>แก้ไขเนื้อหา เปลี่ยนรูป หรือลบบทเรียน</p>
            </a>
        </div>

        <div class="section-title">คลังสื่อและสมาชิก</div>
        <div class="menu-grid">
            <a href="worksheets.php" class="menu-item">
                <span class="icon">📄</span>
                <h3>คลังใบงาน</h3>
                <p>จัดการไฟล์ PDF สำหรับดาวน์โหลด</p>
            </a>

            <a href="admin_worksheets.php" class="menu-item">
                <span class="icon">📄</span>
                <h3>แก้ไข คลังใบงาน</h3>
                <p>จัดการไฟล์ PDF สำหรับดาวน์โหลด</p>
            </a>
            
            <a href="admin_stats.php" class="menu-item">
                <span class="icon">📈</span>
                <h3>สถิติการเรียน</h3>
                <p>ดูว่าเด็กๆ สนใจเรื่องไหนมากที่สุด</p>
            </a>
        </div>

        <div style="text-align: center;">
            <a href="../" class="btn-back">← กลับไปหน้าหลัก (สำหรับเด็กๆ)</a>
        </div>
    </div>

</body>
</html>