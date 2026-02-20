<?php
require_once '../includes/db_connect.php';

header('Content-Type: application/json');

try {
    // 1. กำหนด Path ของไฟล์ SQL (ปรับตามโครงสร้างโฟลเดอร์ของคุณ)
    $sqlFilePath = '../sql/dump-kids_learning-202602192047.sql';

    if (!file_exists($sqlFilePath)) {
        throw new Exception("ไม่พบไฟล์ SQL ในตำแหน่งที่ระบุ: " . $sqlFilePath);
    }

    // 2. อ่านเนื้อหาในไฟล์ SQL
    $sqlContent = file_get_contents($sqlFilePath);

    // 3. ใช้ multi_query เพื่อรันคำสั่งทั้งหมดในไฟล์พร้อมกัน
    // หมายเหตุ: วิธีนี้จะรันคำสั่งทั้งหมดที่แยกด้วยเครื่องหมาย semicolon (;)
    if ($conn->multi_query($sqlContent)) {
        // ต้องเคลียร์ผลลัพธ์ของ multi_query เพื่อป้องกัน Error ในการรันคำสั่งถัดไป
        do {
            if ($result = $conn->store_result()) {
                $result->free();
            }
        } while ($conn->next_result());

        echo json_encode([
            'status' => 'success', 
            'message' => 'รีเซ็ตระบบด้วยไฟล์ dump เรียบร้อยแล้ว!'
        ]);
    } else {
        throw new Exception("เกิดข้อผิดพลาดในการรัน SQL: " . $conn->error);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error', 
        'message' => $e->getMessage()
    ]);
}

header("Location: ../admin/");

?>
