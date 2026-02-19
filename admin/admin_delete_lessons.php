<?php
require_once '../includes/db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. ลบข้อมูลใน Database
    $conn->query("DELETE FROM lessons WHERE id = $id");
}

header("Location: edit-list.php");
?>