<?php require_once '../views/layouts/header.php'; ?>

<h2>Quản Lý Người Dùng</h2>

 <?php if (isset($_GET['success']) && $_GET['success'] == 'editrole'): ?>
    <p class="success-message">Cập nhật vai trò người dùng thành công!</p>
<?php endif; ?>
<?php if (isset($_GET['error'])): ?>
     <p class="error-message">
         <?php
            // Simple error mapping - enhance as needed
            $error_map = [
                'invalidid' => 'ID người dùng không hợp lệ.',
                'notfound' => 'Không tìm thấy người dùng.',
                'invalidrole' => 'Vai trò được chọn không hợp lệ.',
                'updatefailed' => 'Không thể cập nhật vai trò người dùng.',
                'selfedit' => 'Bạn không thể thay đổi vai trò của chính mình.',
                'lastadmin' => 'Không thể thay đổi vai trò của quản trị viên cuối cùng.'
            ];
            echo htmlspecialchars($error_map[$_GET['error']] ?? 'Đã xảy ra lỗi không xác định.');
         ?>
     </p>
<?php endif; ?>


<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên đăng nhập</th>
            <th>Họ và Tên</th>
            <th>Email</th>
            <th>Vai trò</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($users) > 0): ?>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['Id']); ?></td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars(ucfirst($user['role'])); // Capitalize role ?></td>
                <td class="action-links">
                    <?php // Optional: Prevent editing self or add other conditions ?>
                    <?php // if ($user['Id'] != $_SESSION['user_id']): ?>
                        <a href="index.php?controller=user&action=edit&id=<?php echo $user['Id']; ?>" class="button edit-button">Sửa Vai Trò</a>
                    <?php // else: ?>
                        <?php // echo "(Current User)"; ?>
                   <?php // endif; ?>
                   <?php // Add delete button/logic here if needed ?>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">Không có người dùng nào trong hệ thống.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php require_once '../views/layouts/footer.php'; ?>