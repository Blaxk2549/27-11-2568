<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$fullname = $_SESSION['fullname'];
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard - Warp Connect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <style>
        body {
            background-color: #1a1a1a; color: #f0f0f0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 80px;
        }
        .color-accent { color: #E74C3C !important; }
        .navbar-glass {
            background: rgba(0, 0, 0, 0.8); backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(231, 76, 60, 0.3);
        }
        .stat-card {
            background: #2c2c2c; border-radius: 12px; padding: 20px;
            border: 1px solid #444; transition: transform 0.2s;
        }
        .stat-card:hover { transform: translateY(-5px); border-color: #E74C3C; }
        .stat-icon { font-size: 2.5rem; opacity: 0.2; position: absolute; right: 20px; top: 20px; }
        .btn-action {
            background: linear-gradient(45deg, #E74C3C, #c0392b);
            color: white; border: none; width: 100%; padding: 15px;
            border-radius: 10px; font-weight: bold; text-transform: uppercase;
        }
        .btn-action:hover { opacity: 0.9; color: white; }
        .table-dark-custom th { background-color: #333; color: #E74C3C; }
        .table-dark-custom td { vertical-align: middle; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-glass fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#"><i class="fas fa-route color-accent"></i> WarpConnect</a>
            <div class="d-flex align-items-center">
                <span class="text-white-50 me-3 d-none d-sm-block">สวัสดี, <?php echo htmlspecialchars($fullname); ?></span>
                <a href="logout.php" class="btn btn-outline-danger btn-sm">ออกจากระบบ</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2 class="fw-bold">ภาพรวมการขนส่ง</h2>
                <p class="text-muted">ติดตามสถานะพัสดุของคุณทั้งในและต่างประเทศ</p>
            </div>
            <div class="col-md-4">
                <button class="btn btn-action shadow"><i class="fas fa-plus-circle me-2"></i> เปิดออเดอร์ใหม่</button>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="stat-card position-relative">
                    <h6 class="text-muted">กำลังดำเนินการ</h6>
                    <h2 class="fw-bold text-warning">0 รายการ</h2>
                    <i class="fas fa-box-open stat-icon text-warning"></i>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card position-relative">
                    <h6 class="text-muted">รอชำระเงิน</h6>
                    <h2 class="fw-bold text-danger">0 รายการ</h2>
                    <i class="fas fa-wallet stat-icon text-danger"></i>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card position-relative">
                    <h6 class="text-muted">ติดศุลกากร/เอกสาร</h6>
                    <h2 class="fw-bold text-info">0 รายการ</h2>
                    <i class="fas fa-file-contract stat-icon text-info"></i>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card position-relative">
                    <h6 class="text-muted">ส่งสำเร็จ (เดือนนี้)</h6>
                    <h2 class="fw-bold text-success">0 รายการ</h2>
                    <i class="fas fa-check-circle stat-icon text-success"></i>
                </div>
            </div>
        </div>

        <div class="card bg-dark border-secondary">
            <div class="card-header border-secondary">
                <h5 class="mb-0 text-white"><i class="fas fa-list-ul color-accent me-2"></i> รายการล่าสุดของคุณ</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-dark table-hover table-dark-custom mb-0">
                    <thead>
                        <tr>
                            <th>Tracking ID</th>
                            <th>ประเภท</th>
                            <th>เส้นทาง (ต้นทาง -> ปลายทาง)</th>
                            <th>สถานะปัจจุบัน</th>
                            <th>ชำระเงิน</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                ยังไม่มีรายการขนส่ง
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>