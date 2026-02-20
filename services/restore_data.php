<?php
// ห้ามมีช่องว่างหรือตัวอักษรใดๆ ก่อนแท็ก <?php ด้านบนนี้
require_once '../includes/db_connect.php';

header('Content-Type: application/json');

try {
    // ใช้ __DIR__ เพื่ออ้างอิงตำแหน่งโฟลเดอร์ปัจจุบันที่ไฟล์นี้อยู่
    // แล้วถอยออกไป 1 ชั้นเพื่อเข้าสู่โฟลเดอร์ SQL (เช็คชื่อตัวพิมพ์เล็ก-ใหญ่ให้ตรงกับใน Hosting)
    $sqlFilePath = __DIR__ . '/../SQL/dump-kids_learning-202602192047.sql';

    if (!file_exists($sqlFilePath)) {
        throw new Exception("ไม่พบไฟล์ในตำแหน่ง: " . $sqlFilePath);
    }

    $sqlContent = file_get_contents($sqlFilePath);
    
    echo "กำลังประมวลผลไฟล์ SQL จาก: " . $sqlFilePath . "\n";
    echo "ขนาดไฟล์: " . strlen($sqlContent) . " bytes\n";
    echo "เริ่มการนำเข้า SQL...\n";
    //echo $sqlContent . "\n"; // แสดงเนื้อหา SQL เพื่อการดีบัก

    if ($conn->multi_query($sqlContent)) {
        do {
            if ($result = $conn->store_result()) { $result->free(); }
        } while ($conn->next_result());

        echo json_encode(['status' => 'success', 'message' => 'รีเซ็ตข้อมูลสำเร็จ!']);
        echo "<script>console.log('รีเซ็ตข้อมูลสำเร็จ!');</script>";
    } else {
        throw new Exception("SQL Error: " . $conn->error);
    }

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}


header("Location: ../admin/");

?>
