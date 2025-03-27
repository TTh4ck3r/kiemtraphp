<?php require_once '../views/layouts/header.php'; ?>

<h2>Chỉnh Sửa Vai Trò Người Dùng</h2>

<?php if (empty($user)): ?>
    <p class="error-message">Không tìm thấy người dùng.</p>
    <p><a href="index.php?controller=user&action=index">Quay lại danh sách người dùng</a></p>
<?php else: ?>

    <?php if (isset($_GET['error'])): ?>
     <p class="error-message">
         <?php
            $error_map = [
                'invalidrole' => 'Vai trò được chọn không hợp lệ.',
                'updatefailed' => 'Không thể cập nhật vai trò người dùng.',
                'selfedit' => 'Bạn không thể thay đổi vai trò của chính mình.',
                 'lastadmin' => 'Không thể thay đổi vai trò của quản trị viên cuối cùng.'
            ];
            echo htmlspecialchars($error_map[$_GET['error']] ?? 'Đã xảy ra lỗi không xác định.');
         ?>
     </p>
    <?php endif; ?>


    <form action="index.php?controller=user&action=edit&id=<?php echo htmlspecialchars($user['Id']); ?>" method="post" class="user-form">
        <div>
            <label>ID:</label>
            <span><?php echo htmlspecialchars($user['Id']); ?></span>
        </div>
         <div>
            <label>Tên đăng nhập:</label>
            <span><?php echo htmlspecialchars($user['username']); ?></span>
        </div>
         <div>
            <label>Họ và Tên:</label>
            <span><?php echo htmlspecialchars($user['fullname']); ?></span>
        </div>
         <div>
            <label>Email:</label>
            <span><?php echo htmlspecialchars($user['email']); ?></span>
        </div>

        <div>
            <label for="role">Vai trò:</label>
            <select id="role" name="role" required <?php /* echo ($user['Id'] == $_SESSION['user_id']) ? 'disabled' : ''; */ ?>>
                <option value="user" <?php echo ($user['role'] == 'user') ? 'selected' : ''; ?>>User</option>
                <option value="admin" <?php echo ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
            </select>
             <?php /* if ($user['Id'] == $_SESSION['user_id']): ?>
                <small>Bạn không thể thay đổi vai trò của chính mình.</small>
             <?php endif; */ ?>
        </div>

        <div>
             <?php // Optional: Disable button if editing self ?>
             <?php // if ($user['Id'] != $_SESSION['user_id']): ?>
                 <button type="submit">Cập Nhật Vai Trò</button>
             <?php // endif; ?>
            <a href="index.php?controller=user&action=index" class="button cancel-button">Hủy</a>
        </div>
    </form>
<?php endif; ?>

<?php require_once '../views/layouts/footer.php'; ?>