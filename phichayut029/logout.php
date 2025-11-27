<?php
// 1. ต้องวาง session_start(); ไว้ บรรทัดบนสุด
session_start();

// 2. ทำลาย Session ทั้งหมด
session_unset();
session_destroy();


// 3. ส่งกลับไปหน้าล็อกอิน
header('Location: login.php'); // (login.php คือหน้าฟอร์ม)
exit();
?>