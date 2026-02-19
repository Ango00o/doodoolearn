<?php
// บรรทัดแรกต้องเป็น <?php เท่านั้น ห้ามมีช่องว่างข้างบน
require_once '../includes/db_connect.php';

// 1. ล้าง buffer ที่อาจค้างอยู่จากการรวมไฟล์ (include)
while (ob_get_level()) {
    ob_end_clean();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT file_path, title FROM worksheets WHERE id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($row) {
        // อัปเดตจำนวนดาวน์โหลด
        $conn->query("UPDATE worksheets SET download_count = download_count + 1 WHERE id = $id");

        $file = '../uploads/files/' . trim($row['file_path']); // trim path ไฟล์ด้วย

        if (file_exists($file)) {
            $download_name = trim($row['title']) . ".pdf";
            
            // 2. ตั้งค่า Header ให้เข้มงวดที่สุด
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . str_replace('"', '', $download_name) . '"');
            header('Content-Length: ' . filesize($file));
            header('Cache-Control: private, max-age=0, must-revalidate');
            header('Pragma: public');
            
            // 3. อ่านไฟล์
            readfile($file);
            
            // 4. จบการทำงานทันที ห้ามรันต่อ
            exit;
        } else {
            echo "Error: ไม่พบไฟล์จริงในโฟลเดอร์ uploads/files/";
        }
    }
}
?>