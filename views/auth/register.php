<?php require_once '../views/layouts/header.php'; ?>
<link rel="stylesheet" href="public/css/style.css">

<div class="register-container">
    <h2>Đăng Ký Tài Khoản Mới</h2>

    <?php if (!empty($errors['general'])): ?>
        <p class="error-message"><?php echo htmlspecialchars($errors['general']); ?></p>
    <?php endif; ?>

    <form action="index.php?controller=auth&action=register" method="post" class="user-form">
        <div>
            <label for="username">Tên đăng nhập:</label>
            <input type="text" id="username" name="username" required value="<?php echo htmlspecialchars($input['username'] ?? ''); ?>">
            <?php if (!empty($errors['username'])): ?>
                <span class="error-text"><?php echo htmlspecialchars($errors['username']); ?></span>
            <?php endif; ?>
             <small>Chỉ chứa chữ cái, số, dấu gạch dưới (_).</small>
        </div>
        <div>
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required>
             <?php if (!empty($errors['password'])): ?>
                <span class="error-text"><?php echo htmlspecialchars($errors['password']); ?></span>
            <?php endif; ?>
             <small>Ít nhất 6 ký tự.</small>
        </div>
        <div>
            <label for="confirm_password">Xác nhận Mật khẩu:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
             <?php if (!empty($errors['confirm_password'])): ?>
                <span class="error-text"><?php echo htmlspecialchars($errors['confirm_password']); ?></span>
            <?php endif; ?>
        </div>
        <div>
            <label for="fullname">Họ và Tên:</label>
            <input type="text" id="fullname" name="fullname" required value="<?php echo htmlspecialchars($input['fullname'] ?? ''); ?>">
             <?php if (!empty($errors['fullname'])): ?>
                <span class="error-text"><?php echo htmlspecialchars($errors['fullname']); ?></span>
            <?php endif; ?>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($input['email'] ?? ''); ?>">
             <?php if (!empty($errors['email'])): ?>
                <span class="error-text"><?php echo htmlspecialchars($errors['email']); ?></span>
            <?php endif; ?>
        </div>
        <div>
            <button type="submit">Đăng Ký</button>
            <p style="margin-top: 15px;">Đã có tài khoản? <a href="index.php?controller=auth&action=login">Đăng nhập tại đây</a></p>
        </div>
    </form>
</div>

<?php require_once '../views/layouts/footer.php'; ?>