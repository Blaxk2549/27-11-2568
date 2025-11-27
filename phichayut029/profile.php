<?php
// 1. (สำคัญที่สุด) เริ่ม Session และตรวจสอบการ Login
session_start();
if (!isset($_SESSION['user_id'])) { // เช็กว่ามี session user_id หรือไม่
    // ถ้ายังไม่ได้ Login ให้เด้งกลับไปหน้า login
    header("Location: login.php"); 
    exit();
}

// 2. ดึงชื่อผู้ใช้จาก Session มาแสดง
$fullname = $_SESSION['fullname'];
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โปรไฟล์ - <?php echo htmlspecialchars($fullname); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <style>
        /* (CSS ธีมดำ-แดง สไตล์เดิม) */
        body {
            background-color: #1a1a1a; 
            color: #f0f0f0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 70px; /* เว้นที่ให้ Navbar */
        }
        .color-accent { color: #E74C3C !important; }
        
        /* สไตล์ Navbar (ดำกึ่งโปร่งแสง) */
        .bg-dark-glass {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .navbar-dark .navbar-nav .nav-link:hover,
        .navbar-dark .navbar-nav .nav-link.active {
            color: #E74C3C; /* สีแดงเมื่อ Active/Hover */
        }
        .btn-transport {
            background-color: #E74C3C; 
            border-color: #C0392B;
            color: white;
        }
        .btn-transport:hover { 
            background-color: #C0392B; 
            color: white;
        }

        /* การ์ดโปรไฟล์ (สไตล์ Glassmorphism) */
        .profile-card {
            background: rgba(255, 255, 255, 0.1); 
            backdrop-filter: blur(10px); 
            border: 1px solid rgba(255, 255, 255, 0.2); 
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            z-index: 10;
            position: relative;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark-glass shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="dashboard.php">
                <i class="fas fa-route color-accent"></i> Warp<span class="color-accent">Connect</span>
            </a>
            
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">
                        <i class="fas fa-tachometer-alt fa-fw me-1"></i>แดชบอร์ด
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="profile.php"> <i class="fas fa-user-circle fa-fw me-1"></i>โปรไฟล์
                    </a>
                </li>
            </ul>

            <span class="navbar-text text-white me-3 d-none d-sm-block">
                สวัสดี, <?php echo htmlspecialchars($fullname); ?>
            </span>
            <a href="logout.php" class="btn btn-transport">
                <i class="fas fa-sign-out-alt"></i> ออกจากระบบ
            </a>
        </div>
    </nav>

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card profile-card text-white text-center p-4" style="max-width: 500px;">
            <div class="card-body">
                <i class="fas fa-user-circle fa-6x color-accent mb-3"></i>
                
                <h1 class="card-title h3">สวัสดีคุณ, <?php echo htmlspecialchars($fullname); ?></h1>
                
                <p class="card-text fs-5">Username ของคุณ: <span class="fw-bold"><?php echo htmlspecialchars($username); ?></span></p>
                
                <hr class="text-white-50">
                
                <p class="text-white-50">นี่คือหน้าโปรไฟล์ส่วนตัวของคุณ</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>