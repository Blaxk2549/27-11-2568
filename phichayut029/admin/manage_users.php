<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['status'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

include_once '../connect.php';

// ดึงข้อมูล Users
$sql = "SELECT * FROM users ORDER BY id ASC";
$result = mysqli_query($con, $sql);
$fullname = $_SESSION['fullname'];
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการสมาชิก</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body { background-color: #121212; color: #ccc; font-family: 'Segoe UI', sans-serif; }
        
        /* [แก้] เพิ่ม z-index ให้ Sidebar อยู่ชั้นบนสุด แต่ไม่บังเนื้อหา */
        .sidebar { 
            width: 260px; height: 100vh; position: fixed; 
            background: #000; border-right: 1px solid #333; padding: 20px; 
            z-index: 1000; 
        }
        
        .main-content { margin-left: 260px; padding: 30px; position: relative; z-index: 1; }
        
        .text-gold { color: #FFD700 !important; }
        .btn-gold { background-color: #FFD700; color: #000; font-weight: bold; border: none; }
        .btn-gold:hover { background-color: #e6c200; color: #000; }
        
        .table-dark-custom { background-color: #1E1E1E; border-radius: 10px; overflow: hidden; }
        .table-dark-custom th { background-color: #252525; color: #FFD700; border-bottom: 2px solid #444; }
        .table-dark-custom td { border-bottom: 1px solid #333; color: #ccc; vertical-align: middle; }
        
        /* Modal Styles */
        .modal-content { background-color: #2c2c2c; color: #fff; border: 1px solid #444; }
        .modal-header { border-bottom: 1px solid #444; }
        .modal-footer { border-top: 1px solid #444; }
        .form-control, .form-select { background-color: #1a1a1a; border: 1px solid #444; color: #fff; }
        .form-control:focus, .form-select:focus { background-color: #1a1a1a; color: #fff; border-color: #FFD700; box-shadow: 0 0 0 0.25rem rgba(255, 215, 0, 0.25); }
        
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
            <li class="nav-item"><a href="dashboard.php" class="nav-link"><i class="fas fa-chart-line me-2"></i> Dashboard</a></li>
            <li class="nav-item"><a href="manage_users.php" class="nav-link text-gold active"><i class="fas fa-users me-2"></i> จัดการสมาชิก</a></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="fas fa-boxes me-2"></i> จัดการสินค้า</a></li>
        </ul>
        <div class="mt-auto">
            <a href="../logout.php" class="btn btn-outline-danger w-100 btn-sm">ออกจากระบบ</a>
        </div>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white fw-bold"><i class="fas fa-users-cog me-2 text-gold"></i> จัดการสมาชิก</h2>
            <button class="btn btn-gold" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fas fa-plus-circle me-2"></i> เพิ่มสมาชิกใหม่
            </button>
        </div>

        <div class="card bg-dark border-secondary shadow-lg">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark table-hover table-dark-custom mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>ชื่อ-นามสกุล</th>
                                <th>เบอร์โทร</th>
                                <th>สถานะ</th>
                                <th class="text-end">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Loop รอบที่ 1: แสดงตาราง
                            while($row = mysqli_fetch_assoc($result)) { 
                            ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td class="fw-bold text-white"><?php echo $row['username']; ?></td>
                                <td><?php echo $row['fullname']; ?></td>
                                <td><?php echo $row['phone']; ?></td>
                                <td>
                                    <?php 
                                    if($row['status']=='admin') echo '<span class="badge bg-warning text-dark">Admin</span>';
                                    elseif($row['status']=='shipper') echo '<span class="badge bg-info text-dark">Shipper</span>';
                                    else echo '<span class="badge bg-success">User</span>';
                                    ?>
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>">
                                        <i class="fas fa-edit"></i> แก้ไข
                                    </button>
                                    <button onclick="confirmDelete(<?php echo $row['id']; ?>)" class="btn btn-sm btn-outline-danger me-2">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php 
    // [สำคัญ] รีเซ็ต Pointer ของข้อมูล เพื่อ Loop สร้าง Modal อีกรอบ
    mysqli_data_seek($result, 0); 
    
    while($row = mysqli_fetch_assoc($result)) { 
    ?>
    <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-gold">แก้ไข: <?php echo $row['username']; ?></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="user_actions.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="action" value="edit">
                        
                        <div class="mb-3">
                            <label>ชื่อ-นามสกุล</label>
                            <input type="text" name="fullname" class="form-control" value="<?php echo $row['fullname']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>เบอร์โทร</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo $row['phone']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>สถานะ</label>
                            <select name="status" class="form-select">
                                <option value="user" <?php if($row['status']=='user') echo 'selected'; ?>>User</option>
                                <option value="shipper" <?php if($row['status']=='shipper') echo 'selected'; ?>>Shipper</option>
                                <option value="admin" <?php if($row['status']=='admin') echo 'selected'; ?>>Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="text-warning">เปลี่ยนรหัสผ่าน (เว้นว่างถ้าไม่เปลี่ยน)</label>
                            <input type="password" name="password" class="form-control" placeholder="ตั้งรหัสผ่านใหม่...">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-gold">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php } ?>

    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-gold"><i class="fas fa-user-plus"></i> เพิ่มสมาชิกใหม่</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="user_actions.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add">
                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>รหัสผ่าน</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>ชื่อ-นามสกุล</label>
                            <input type="text" name="fullname" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>เบอร์โทร</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>สถานะ</label>
                            <select name="status" class="form-select">
                                <option value="user">User</option>
                                <option value="shipper">Shipper</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-gold">เพิ่มสมาชิก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'ยืนยันการลบ?',
                text: "ข้อมูลจะหายไปถาวรเลยนะ!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'ใช่, ลบเลย!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'user_actions.php?action=delete&id=' + id;
                }
            })
        }
    </script>
</body>
</html>