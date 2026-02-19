<?php
$conn = new mysqli("localhost", "root", "", "kids_learning");
$conn->set_charset("utf8mb4");

// รับค่า user_id และเพิ่มดาว 1 ดวง
$sql = "UPDATE user_progress SET total_stars = total_stars + 1 WHERE user_id = 1";

if ($conn->query($sql) === TRUE) {
    echo "Success";
} else {
    echo "Error";
}
$conn->close();
?>