<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warp Connect Transport - Login/Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <style>
        body {
            background: url('placeholder-dark-road-lights.jpg') no-repeat center center fixed; 
            background-size: cover;
            position: relative;
            background-color: #121212; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(180deg, 
                rgba(0, 0, 0, 0.9) 0%, 
                rgba(80, 0, 0, 0.8) 100%
            );
            backdrop-filter: blur(2px) brightness(0.9); 
        }
        .login-card {
            background: rgba(255, 255, 255, 0.1); 
            backdrop-filter: blur(10px); 
            border: 1px solid rgba(255, 255, 255, 0.2); 
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            max-width: 500px;
            z-index: 10;
            position: relative;
        }
        .color-accent { color: #E74C3C !important; }
        .btn-transport {
            background-color: #E74C3C; 
            border-color: #C0392B;
            transition: background-color 0.3s, transform 0.2s;
            font-weight: bold;
        }
        .btn-transport:hover { 
            background-color: #C0392B; 
            transform: translateY(-1px);
        }
        .nav-tabs .nav-link {
            color: #eee; 
            border: none;
            border-bottom: 3px solid transparent;
            font-weight: bold;
        }
        .nav-tabs .nav-link.active {
            color: #FFFFFF; 
            background-color: transparent;
            border-color: #E74C3C; 
        }
        .form-floating > .form-control,
        .form-floating > .form-control:focus {
             background-color: rgba(255, 255, 255, 0.95);
             color: #333;
        }
        .form-floating > label { color: #777; }
        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label {
            color: #E74C3C; 
        }
        .form-control:focus {
            border-color: #E74C3C;
            box-shadow: 0 0 0 0.25rem rgba(231, 76, 60, 0.25); 
        }
        .input-group-text {
            background-color: rgba(255, 255, 255, 0.95);
            border-color: #ced4da;
            color: #555;
        }
        .text-white-50 {
            color: rgba(255, 255, 255, 0.7) !important; 
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">
    
    <div class="container">
        <div class="card login-card mx-auto p-4 p-md-5 text-white">
            
            <div class="text-center mb-4">
                <i class="fas fa-route fa-3x color-accent mb-2"></i> 
                <h3 class="fw-bold text-uppercase">Warp Connect Transport</h3>
            </div>
            
            <ul class="nav nav-tabs nav-fill mb-4" id="portalTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login-pane" type="button" role="tab" aria-controls="login-pane" aria-selected="true">
                        <i class="fas fa-sign-in-alt me-1"></i> เข้าสู่ระบบ
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register-pane" type="button" role="tab" aria-controls="register-pane" aria-selected="false">
                        <i class="fas fa-user-plus me-1"></i> ลงทะเบียนใหม่
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="portalTabsContent">
                
                <div class="tab-pane fade show active" id="login-pane" role="tabpanel" aria-labelledby="login-tab" tabindex="0">
                    <p class="text-white-50 text-center">สำหรับสมาชิกปัจจุบัน</p>
                    <form action="check_login.php" method="POST">
                        <div class="input-group mb-4">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="log-username" name="username" placeholder="Username" required>
                                <label for="log-username">Username</label>
                            </div>
                        </div>
                        <div class="input-group mb-4">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <div class="form-floating">
                                <input type="password" class="form-control" id="log-password" name="password" placeholder="รหัสผ่าน" required>
                                <label for="log-password">รหัสผ่าน</label>
                            </div>
                        </div>
                        <a href="#" class="text-decoration-none color-accent d-block text-end mb-3">ลืมรหัสผ่าน?</a>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-transport btn-lg text-white">เข้าสู่ระบบ</button>
                        </div>
                    </form>
                </div>
                
                <div class="tab-pane fade" id="register-pane" role="tabpanel" aria-labelledby="register-tab" tabindex="0">
                    <p class="text-white-50 text-center">สำหรับสมาชิกใหม่</p>
                    <form action="register_save.php" method="POST">
                        
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="reg-username" name="username" placeholder="Username" required>
                                <label for="reg-username">Username</label>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <div class="form-floating">
                                <input type="tel" class="form-control" id="reg-phone" name="phone" placeholder="Phone" required>
                                <label for="reg-phone">เบอร์โทรศัพท์</label>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="reg-fullname" name="fullname" placeholder="Full Name" required>
                                <label for="reg-fullname">ชื่อ-นามสกุล</label>
                            </div>
                        </div>
                        
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <div class="form-floating">
                                <input type="password" class="form-control" id="reg-password" name="password" placeholder="Password" required>
                                <label for="reg-password">รหัสผ่าน</Hlabel>
                            </div>
                        </div>
                        
                        <div class="input-group mb-4">
                            <span class="input-group-text"><i class="fas fa-lock-open"></i></span>
                            <div class="form-floating">
                                <input type="password" class="form-control" id="reg-confirm" name="confirm_password" placeholder="Confirm Password" required>
                                <label for="reg-confirm">ยืนยันรหัสผ่าน</label>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-transport btn-lg text-white">ลงทะเบียน</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>