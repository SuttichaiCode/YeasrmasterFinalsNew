<?php
session_start();
if (!isset($_SESSION['uid'])) {
    header("Location: index.php"); // หากไม่ได้ล็อกอิน ส่งกลับไปที่หน้า Login
    exit();
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>หน้าหลัก</title>
</head>
<body>
    <h1>ยินดีต้อนรับสู่ระบบ!</h1>
    <a href="logout.php">ออกจากระบบ</a>
</body>
</html>
