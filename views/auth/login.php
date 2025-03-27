<?php require_once '../views/layouts/header.php'; // Use header ?>
<link rel="stylesheet" href="public/css/style.css">
<div class="login-container">
    <h2>Đăng Nhập Hệ Thống</h2>

    <?php if (!empty($error)): ?>
        <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
     <?php if (isset($_GET['loggedout'])): ?>
        <p class="success-message">Bạn đã đăng xuất thành công.</p>
    <?php endif; ?>


    <form action="index.php?controller=auth&action=login" method="post">
        <div>
            <label for="username">Tài khoản:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <button type="submit">Đăng Nhập</button>
        </div>
    </form>
</div>

