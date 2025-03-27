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
            --primary-color: #2ecc71; /* Màu xanh lá nhạt hơn */
            --secondary-color: #e67e22; /* Màu cam nổi bật */
            --hover-color: #d35400; /* Cam đậm khi hover */
            --light-bg: #f9ebea; /* Màu nền nhạt hồng */
        }

        body {
            font-family: 'Roboto', sans-serif; /* Thay font chữ */
            background: linear-gradient(120deg, #dfe6e9 0%, #b2bec3 100%); /* Gradient nhẹ nhàng */
            min-height: 100vh;
            padding-top: 80px; /* Tăng padding top */
        }

        .navbar {
            background: var(--primary-color) !important;
            padding: 1.2rem 0; /* Tăng padding navbar */
            box-shadow: 0 6px 20px rgba(0,0,0,0.2); /* Đổ bóng đậm hơn */
            transition: all 0.4s ease; /* Hiệu ứng mượt hơn */
        }

        .navbar-brand {
            font-size: 1.8rem; /* Tăng kích thước chữ */
            font-weight: 700;
            color: #fff !important;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.4s ease;
        }

        .navbar-brand:hover {
            color: var(--secondary-color) !important;
            transform: scale(1.05); /* Phóng to nhẹ hơn */
        }

        .nav-link {
            color: rgba(255,255,255,0.95) !important;
            font-weight: 600; /* Đậm hơn */
            padding: 0.8rem 1.5rem !important;
            border-radius: 8px; /* Bo góc lớn hơn */
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.4s ease;
        }

        .nav-link:hover {
            color: #fff !important;
            background: var(--secondary-color);
            transform: scale(1.05); /* Phóng to khi hover */
        }

        .dropdown-menu {
            border: 1px solid rgba(0,0,0,0.05);
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            background: #fff;
            padding: 0.7rem 0;
            animation: slideIn 0.3s ease-out;
        }

        .dropdown-item {
            padding: 0.6rem 1.8rem;
            border-radius: 6px;
            margin: 3px 6px;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background: var(--light-bg);
            color: var(--hover-color);
        }

        .badge {
            background: var(--secondary-color) !important;
            padding: 0.4em 0.8em;
            font-size: 0.85em;
            border-radius: 15px; /* Bo tròn hơn */
        }

        .btn-outline-danger {
            border-color: #c0392b; /* Đỏ đậm hơn */
            color: #c0392b;
            transition: all 0.3s ease;
        }

        .btn-outline-danger:hover {
            background: #c0392b;
            color: #fff;
            transform: scale(1.05); /* Phóng to nhẹ */
        }

        main {
            background: rgba(255,255,255,0.98);
            border-radius: 20px; /* Bo góc lớn hơn */
            padding: 2.5rem;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            margin-bottom: 3rem;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 992px) {
            .navbar-nav {
                padding: 1.5rem;
                background: rgba(0,0,0,0.15);
                border-radius: 12px;
                margin-top: 0.8rem;
            }
            .nav-link {
                padding: 1rem !important;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php?controller=nhanvien&action=index">
            <i class="bi bi-briefcase-fill"></i> Quản Lý Nhân Sự <!-- Thay icon -->
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=nhanvien&action=index">
                            <i class="bi bi-list-check"></i> Danh Sách NV <!-- Thay icon -->
                        </a>
                    </li>
                    <?php if ($this->isAdmin()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?controller=nhanvien&action=add">
                                <i class="bi bi-person-add"></i> Thêm NV <!-- Thay icon -->
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?controller=user&action=index">
                                <i class="bi bi-gear-fill"></i> Quản Lý User <!-- Thay icon -->
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item dropdown d-flex align-items-center">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo htmlspecialchars($_SESSION['user_fullname'] ?? $_SESSION['username']); ?> 
                            <span class="badge bg-secondary ms-2">
                                <?php echo htmlspecialchars($_SESSION['user_role']); ?>
                            </span>
                        </a>
                        <a href="index.php?controller=auth&action=logout" class="btn btn-outline-danger btn-sm ms-3" title="Đăng Xuất">
                            <i class="bi bi-power"></i> <!-- Thay icon -->
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="index.php?controller=profile&action=view">
                                    <i class="bi bi-person-lines-fill me-2"></i> Hồ Sơ Cá Nhân <!-- Thay icon -->
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="index.php?controller=auth&action=logout">
                                    <i class="bi bi-power me-2"></i> Đăng Xuất <!-- Thay icon -->
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=auth&action=register">
                            <i class="bi bi-person-plus-fill"></i> Đăng Ký
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=auth&action=login">
                            <i class="bi bi-box-arrow-in-left"></i> Đăng Nhập <!-- Thay icon -->
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Bootstrap JS and Popper -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>