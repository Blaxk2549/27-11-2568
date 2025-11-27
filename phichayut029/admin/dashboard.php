<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['status'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

include_once '../connect.php';
$fullname = $_SESSION['fullname'];

// --- [โซนดึงข้อมูลสถิติ] ---

// 1. นับสมาชิกทั้งหมด
$sql_all = "SELECT COUNT(*) as total FROM users";
$res_all = mysqli_query($con, $sql_all);
$row_all = mysqli_fetch_assoc($res_all);
$total_users = $row_all['total'];

// 2. นับเฉพาะลูกค้า (User)
$sql_cust = "SELECT COUNT(*) as total FROM users WHERE status = 'user'";
$res_cust = mysqli_query($con, $sql_cust);
$row_cust = mysqli_fetch_assoc($res_cust);
$total_cust = $row_cust['total'];

// 3. นับคนส่งของ (Shipper)
$sql_ship = "SELECT COUNT(*) as total FROM users WHERE status = 'shipper'";
$res_ship = mysqli_query($con, $sql_ship);
$row_ship = mysqli_fetch_assoc($res_ship);
$total_ship = $row_ship['total'];

// 4. ดึงรายชื่อล่าสุด 5 คน (แค่อ่านอย่างเดียว ไม่ต้องแก้)
$sql_recent = "SELECT * FROM users ORDER BY id DESC LIMIT 5";
$res_recent = mysqli_query($con, $sql_recent);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <style>
        body { background-color: #121212; color: #ccc; font-family: 'Segoe UI', sans-serif; }
        .sidebar { width: 260px; height: 100vh; position: fixed; background: #000; border-right: 1px solid #333; padding: 20px; }
        .main-content { margin-left: 260px; padding: 30px; }
        
        .text-gold { color: #FFD700 !important; }
        .admin-card {
            background: #1E1E1E; border: 1px solid #333; border-radius: 10px; padding: 20px;
            border-left: 4px solid #FFD700; transition: transform 0.2s;
        }
        .admin-card:hover { transform: translateY(-5px); border-color: #FFD700; }
        .admin-card h3 { color: #fff; font-weight: bold; font-size: 2.5rem; }
        
        .table-dark-custom { background-color: #1E1E1E; border-radius: 10px; overflow: hidden; }
        .table-dark-custom th { background-color: #252525; color: #FFD700; border-bottom: 2px solid #444; }
        .table-dark-custom td { border-bottom: 1px solid #333; color: #ccc; vertical-align: middle; }
        
        .nav-link { color: #888; padding: 12px; margin-bottom: 5px; border-radius: 8px; }
        .nav-link:hover, .nav-link.active { background: rgba(255, 215, 0, 0.15); color: #FFD700; }
    </style>
</head>
<body>

    <div class="sidebar d-flex flex-column">
        <div class="text-center mb-4">
            <i class="fas fa-shield-alt fa-3x text-gold mb-2"></i>
            <h4 class="text-white">ADMIN <span class="text-gold">PANEL</span></h4>
        </div>
        <ul class="nav flex-column flex-grow-1">
            <li class="nav-item"><a href="dashboard.php" class="nav-link active text-gold"><i class="fas fa-chart-line me-2"></i> Dashboard</a></li>
            <li class="nav-item"><a href="manage_users.php" class="nav-link"><i class="fas fa-users me-2"></i> จัดการสมาชิก</a></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="fas fa-boxes me-2"></i> จัดการสินค้า</a></li>
        </ul>
        <div class="mt-auto">
            <p class="small mb-1">Admin: <?php echo htmlspecialchars($fullname); ?></p>
            <a href="../logout.php" class="btn btn-outline-danger w-100 btn-sm">ออกจากระบบ</a>
        </div>
    </div>

    <div class="main-content">
        <h2 class="text-white fw-bold mb-4">ภาพรวมระบบ</h2>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="admin-card">
                    <p class="text-uppercase small mb-1">สมาชิกทั้งหมด</p>
                    <h3><?php echo $total_users; ?> คน</h3>
                    <i class="fas fa-users float-end text-gold fs-1 opacity-25 mt-n4"></i>
                </div>
            </div>
            <div class="col-md-4">
                <div class="admin-card" style="border-left-color: #28a745;">
                    <p class="text-uppercase small mb-1">ลูกค้า (Customers)</p>
                    <h3 class="text-success"><?php echo $total_cust; ?> คน</h3>
                    <i class="fas fa-user-check float-end text-success fs-1 opacity-25 mt-n4"></i>
                </div>
            </div>
            <div class="col-md-4">
                <div class="admin-card" style="border-left-color: #00d2d3;">
                    <p class="text-uppercase small mb-1">คนส่งของ (Shippers)</p>
                    <h3 class="text-info"><?php echo $total_ship; ?> คน</h3>
                    <i class="fas fa-truck float-end text-info fs-1 opacity-25 mt-n4"></i>
                </div>
            </div>
        </div>

        <div class="card bg-dark border-secondary shadow-lg">
            <div class="card-header border-secondary d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-white"><i class="fas fa-history me-2 text-gold"></i> สมาชิกที่สมัครล่าสุด</h5>
                <a href="manage_users.php" class="btn btn-sm btn-outline-warning">ดูทั้งหมด / จัดการ</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark table-hover table-dark-custom mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>ชื่อ-นามสกุล</th>
                                <th>สถานะ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = mysqli_fetch_assoc($res_recent)) { ?>
                            <tr>
                                <td class="fw-bold text-white"><?php echo $row['username']; ?></td>
                                <td><?php echo $row['fullname']; ?></td>
                                <td>
                                    <?php 
                                    if($row['status']=='admin') echo '<span class="badge bg-warning text-dark">Admin</span>';
                                    elseif($row['status']=='shipper') echo '<span class="badge bg-info text-dark">Shipper</span>';
                                    else echo '<span class="badge bg-success">User</span>';
                                    ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>