<?php
// (SweetAlert setup...)
echo '<!DOCTYPE html><html lang="th"><head><meta charset="UTF-8"><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script><style>body { background-color: #2c3e50; }</style></head><body>';

include_once 'connect.php';

if (!$con) { 
    echo "<script>Swal.fire({icon: 'error', title: 'Connection Failed'}).then(() => { window.history.back(); });</script>"; 
    die(); 
}

// รับค่า
$username = $_POST['username'];
$phone = $_POST['phone'];
$fullname = $_POST['fullname'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

if ($password !== $confirm_password) {
    echo "<script>Swal.fire({icon: 'error', title: 'รหัสผ่านไม่ตรงกัน', confirmButtonColor: '#E74C3C'}).then(() => { window.history.back(); });</script>";
    die();
}

// เข้ารหัส
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// [!!! จุดที่แก้ไข !!!] กำหนดสถานะเป็น 'user' อัตโนมัติ
$status = 'user';

// [!!! จุดที่แก้ไข !!!] เพิ่มคอลัมน์ status ใน SQL
$sql = "INSERT INTO users (username, phone, fullname, password, status) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($con, $sql);

if ($stmt) {
    // sssss = 5 strings (username, phone, fullname, password, status)
    mysqli_stmt_bind_param($stmt, "sssss", $username, $phone, $fullname, $hashed_password, $status);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'ลงทะเบียนสำเร็จ!',
                text: 'คุณสามารถเข้าสู่ระบบได้แล้ว',
                confirmButtonColor: '#28a745'
            }).then(() => { window.location = 'login.php'; });
        </script>";
    } else {
        if (mysqli_errno($con) == 1062) {
            echo "<script>Swal.fire({icon: 'error', title: 'Username ซ้ำ!', confirmButtonColor: '#E74C3C'}).then(() => { window.history.back(); });</script>";
        } else {
            echo "Error: " . mysqli_stmt_error($stmt);
        }
    }
    mysqli_stmt_close($stmt);
} else {
    echo "SQL Error: " . mysqli_error($con);
}

mysqli_close($con);
echo '</body></html>';
?>