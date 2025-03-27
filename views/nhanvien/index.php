<?php require_once '../views/layouts/header.php'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">
                        <i class="bi bi-people-fill me-2"></i>THÔNG TIN NHÂN VIÊN
                    </h3>
                    <?php if ($isAdmin): ?>
                        <a href="index.php?controller=nhanvien&action=add" class="btn btn-success btn-sm">
                            <i class="bi bi-plus-circle-fill me-1"></i>Thêm Nhân Viên Mới
                        </a>
                    <?php endif; ?>
                </div>

                <div class="card-body">
                    <?php if (isset($_GET['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php
                            switch ($_GET['success']) {
                                case 'add': echo "Thêm nhân viên thành công!"; break;
                                case 'edit': echo "Cập nhật nhân viên thành công!"; break;
                                case 'delete': echo "Xóa nhân viên thành công!"; break;
                            }
                            ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Đã xảy ra lỗi. Vui lòng thử lại.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center">Mã NV</th>
                                    <th>Tên Nhân Viên</th>
                                    <th class="text-center">Giới Tính</th>
                                    <th>Nơi Sinh</th>
                                    <th>Tên Phòng</th>
                                    <th class="text-end">Lương</th>
                                    <?php if ($isAdmin): ?>
                                        <th class="text-center">Thao Tác</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($nhanviens) > 0): ?>
                                    <?php foreach ($nhanviens as $nv): ?>
                                    <tr>
                                        <td class="text-center"><?php echo htmlspecialchars($nv['Ma_NV']); ?></td>
                                        <td><?php echo htmlspecialchars($nv['Ten_NV']); ?></td>
                                        <td class="text-center">
                                            <?php if (strtoupper($nv['Phai']) == 'NU'): ?>
                                                <img src="public/images/woman.png" alt="Nữ" style="width: 30px; height: 30px;" title="Nữ">
                                            <?php elseif (strtoupper($nv['Phai']) == 'NAM'): ?>
                                                <img src="public/images/man.png" alt="Nam" style="width: 30px; height: 30px;" title="Nam">
                                            <?php else: ?>
                                                <?php echo htmlspecialchars($nv['Phai']); ?>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($nv['Noi_Sinh']); ?></td>
                                        <td><?php echo htmlspecialchars($nv['Ten_Phong'] ?? 'N/A'); ?></td>
                                        <td class="text-end text-success fw-bold"><?php echo number_format($nv['Luong']) . ' VNĐ'; ?></td>
                                        <?php if ($isAdmin): ?>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="index.php?controller=nhanvien&action=edit&id=<?php echo $nv['Ma_NV']; ?>" 
                                                       class="btn btn-warning btn-sm" 
                                                       title="Chỉnh sửa">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </a>
                                                    <a href="index.php?controller=nhanvien&action=delete&id=<?php echo $nv['Ma_NV']; ?>" 
                                                       class="btn btn-danger btn-sm" 
                                                       title="Xóa" 
                                                       onclick="return confirm('Bạn có chắc chắn muốn xóa nhân viên này?');">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="<?php echo $isAdmin ? '7' : '6'; ?>" class="text-center text-muted">
                                            <i class="bi bi-info-circle me-2"></i>Không có nhân viên nào.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php if ($totalPages > 1): ?>
                <div class="card-footer">
                    <nav aria-label="Phân trang nhân viên">
                        <ul class="pagination justify-content-center mb-0">
                            <li class="page-item <?php echo ($currentPage <= 1) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="index.php?controller=nhanvien&action=index&page=<?php echo max(1, $currentPage - 1); ?>" aria-label="Trang trước">
                                    <span aria-hidden="true">«</span>
                                </a>
                            </li>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                                    <a class="page-link" href="index.php?controller=nhanvien&action=index&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <li class="page-item <?php echo ($currentPage >= $totalPages) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="index.php?controller=nhanvien&action=index&page=<?php echo min($totalPages, $currentPage + 1); ?>" aria-label="Trang sau">
                                    <span aria-hidden="true">»</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once '../views/layouts/footer.php'; ?>