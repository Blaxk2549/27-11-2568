<?php
session_start();
include_once '../connect.php';

// SweetAlert Setup
echo '<!DOCTYPE html><head><meta charset="UTF-8"><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script><style>body{background:#2c3e50;}</style></head><body>';

// เช็กสิทธิ์ Admin
if (!isset($_SESSION['user_id']) || $_SESSION['status'] != 'admin') {
    die("Access Denied");
}

// 1. กรณีเพิ่มสมาชิก (Add)
if (isset($_POST['action']) && $_POST['action'] == 'add') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash รหัส
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $status = $_POST['status'];

    $sql = "INSERT INTO users (username, password, fullname, phone, status) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $username, $password, $fullname, $phone, $status);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>Swal.fire('สำเร็จ', 'เพิ่มสมาชิกเรียบร้อย', 'success').then(()=>{window.location='manage_users.php'});</script>";
    } else {
        echo "<script>Swal.fire('ผิดพลาด', 'Username นี้อาจมีอยู่แล้ว', 'error').then(()=>{window.history.back()});</script>";
    }
}

// 2. กรณีแก้ไขสมาชิก (Edit)
if (isset($_POST['action']) && $_POST['action'] == 'edit') {
    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $status = $_POST['status'];
    $password = $_POST['password'];

    if (!empty($password)) {
        // ถ้ากรอกรหัสใหม่ -> อัปเดตทุกอย่างรวมรหัสผ่าน (Hash ใหม่)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET fullname=?, phone=?, status=?, password=? WHERE id=?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ssssi", $fullname, $phone, $status, $hashed_password, $id);
    } else {
        // ถ้าไม่กรอกรหัส -> อัปเดตแค่ข้อมูลอื่น (รหัสเดิมไม่เปลี่ยน)
        $sql = "UPDATE users SET fullname=?, phone=?, status=? WHERE id=?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "sssi", $fullname, $phone, $status, $id);
    }

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>Swal.fire('บันทึกแล้ว', 'แก้ไขข้อมูลสำเร็จ', 'success').then(()=>{window.location='manage_users.php'});</script>";
    } else {
        echo "<script>Swal.fire('ผิดพลาด', 'ไม่สามารถแก้ไขได้', 'error').then(()=>{window.history.back()});</script>";
    }
}

// 3. กรณีลบสมาชิก (Delete)
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // ป้องกันไม่ให้ Admin ลบตัวเอง
    if ($id == $_SESSION['user_id']) {
        echo "<script>Swal.fire('ไม่ได้นะ!', 'คุณจะลบตัวเองออกจากระบบไม่ได้', 'warning').then(()=>{window.location='manage_users.php'});</script>";
        exit();
    }

    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>Swal.fire('ลบสำเร็จ', 'ข้อมูลถูกลบออกจากระบบแล้ว', 'success').then(()=>{window.location='manage_users.php'});</script>";
    } else {
        echo "<script>Swal.fire('ผิดพลาด', 'ลบไม่ได้', 'error').then(()=>{window.location='manage_users.php'});</script>";
    }
}

mysqli_close($con);
echo '</body></html>';
?>