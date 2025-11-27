<?php
// 1. เริ่ม Session
session_start();

// 2. SweetAlert Setup
echo '<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style> body { background-color: #2c3e50; font-family: sans-serif; } </style>
</head>
<body>';

// 3. เชื่อมต่อฐานข้อมูล
include_once 'connect.php';

if (!$con) { 
    echo "<script>Swal.fire({icon: 'error', title: 'Database Error'}).then(() => { window.location = 'login.php'; });</script>"; 
    die(); 
}

// 4. ตรวจสอบการส่งข้อมูล
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ค้นหา User
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // ตรวจสอบรหัสผ่าน
        if (password_verify($password, $row['password'])) {
            
            // เก็บ Session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['status'] = $row['status'];

            // [!!! จุดที่แก้ไขให้ครบ 3 สิทธิ์ !!!]
            $redirect_url = 'dashboard.php'; // ค่าเริ่มต้น (User)

            if ($row['status'] == 'admin') {
                // Admin -> เข้าโฟลเดอร์ admin
                $redirect_url = 'admin/dashboard.php'; 
            } elseif ($row['status'] == 'shipper') {
                // Shipper -> ไปหน้า Shipper Dashboard
                $redirect_url = 'shipper_dashboard.php'; 
            }

            // แจ้งเตือนและส่งไปหน้าปลายทาง
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'เข้าสู่ระบบสำเร็จ',
                    text: 'ยินดีต้อนรับคุณ " . $row['fullname'] . " (" . strtoupper($row['status']) . ")',
                    timer: 1500,
                    showConfirmButton: false
                }).then(function() {
                    window.location = '$redirect_url'; 
                });
            </script>";
            exit();

        } else {
            echo "<script>Swal.fire({icon: 'error', title: 'รหัสผ่านไม่ถูกต้อง', confirmButtonColor: '#d33'}).then(() => { window.history.back(); });</script>";
        }
    } else {
        echo "<script>Swal.fire({icon: 'error', title: 'ไม่พบชื่อผู้ใช้นี้', confirmButtonColor: '#d33'}).then(() => { window.history.back(); });</script>";
    }
    mysqli_stmt_close($stmt);
} else {
    // เข้าผิดทาง
    echo "<script>Swal.fire({icon: 'warning', title: 'Access Denied'}).then(() => { window.location = 'login.php'; });</script>";
}

mysqli_close($con);
echo '</body></html>';
?>