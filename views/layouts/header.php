<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Nhân Sự</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --hover-color: #2980b9;
            --light-bg: #ecf0f1;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding-top: 70px;
        }

        .navbar {
            background: var(--primary-color) !important;
            padding: 1rem 0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-size: 1.6rem;
            font-weight: 600;
            color: white !important;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            color: var(--secondary-color) !important;
            transform: scale(1.02);
        }

        .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            padding: 0.7rem 1.2rem !important;
            border-radius: 5px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: white !important;
            background: var(--secondary-color);
            transform: translateY(-2px);
        }

        .dropdown-menu {
            border: none;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            background: white;
            padding: 0.5rem 0;
            animation: fadeIn 0.2s ease-in;
        }

        .dropdown-item {
            padding: 0.5rem 1.5rem;
            border-radius: 5px;
            margin: 2px 5px;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background: var(--light-bg);
            color: var(--secondary-color);
        }

        .badge {
            background: var(--secondary-color) !important;
            padding: 0.3em 0.6em;
            font-size: 0.8em;
            border-radius: 12px;
        }

        .btn-outline-danger {
            border-color: #e74c3c;
            color: #e74c3c;
            transition: all 0.3s ease;
        }

        .btn-outline-danger:hover {
            background: #e74c3c;
            color: white;
            transform: translateY(-2px);
        }

        main {
            background: rgba(255,255,255,0.95);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 992px) {
            .navbar-nav {
                padding: 1rem;
                background: rgba(0,0,0,0.1);
                border-radius: 10px;
                margin-top: 0.5rem;
            }
            .nav-link {
                padding: 0.8rem !important;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php?controller=nhanvien&action=index">
            <i class="bi bi-people-fill"></i> Quản Lý Nhân Sự
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=nhanvien&action=index">
                            <i class="bi bi-list-ul"></i> Danh Sách NV
                        </a>
                    </li>
                    <?php if ($this->isAdmin()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?controller=nhanvien&action=add">
                                <i class="bi bi-person-plus-fill"></i> Thêm NV
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?controller=user&action=index">
                                <i class="bi bi-person-gear"></i> Quản Lý User
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item dropdown d-flex align-items-center">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> 
                            <?php echo htmlspecialchars($_SESSION['user_fullname'] ?? $_SESSION['username']); ?> 
                            <span class="badge bg-secondary ms-2">
                                <?php echo htmlspecialchars($_SESSION['user_role']); ?>
                            </span>
                        </a>
                        <a href="index.php?controller=auth&action=logout" class="btn btn-outline-danger btn-sm ms-2" title="Đăng Xuất">
                            <i class="bi bi-box-arrow-right"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="index.php?controller=profile&action=view">
                                    <i class="bi bi-person-fill me-2"></i> Hồ Sơ Cá Nhân
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="index.php?controller=auth&action=logout">
                                    <i class="bi bi-box-arrow-right me-2"></i> Đăng Xuất
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=auth&action=register">
                            <i class="bi bi-person-plus"></i> Đăng Ký
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=auth&action=login">
                            <i class="bi bi-box-arrow-in-right"></i> Đăng Nhập
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main class="container mt-4">
    <div class="text-center py-4">
        <h2 class="fw-light">Chào mừng đến với Hệ thống Quản lý Nhân sự</h2>
        <p class="text-muted">Quản lý thông tin nhân viên một cách hiệu quả và chuyên nghiệp</p>
    </div>
</main>

<!-- Bootstrap JS and Popper -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>