<?php require_once '../views/layouts/header.php'; ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">
                        <i class="bi bi-pencil-square me-2"></i>Sửa Thông Tin Nhân Viên
                    </h3>
                </div>

                <?php if (empty($nhanvien)): ?>
                    <div class="card-body">
                        <div class="alert alert-warning d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-triangle me-3 fs-4"></i>
                            <div>
                                Không tìm thấy thông tin nhân viên.
                            </div>
                        </div>
                        <div class="text-center">
                            <a href="index.php?controller=nhanvien&action=index" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Quay lại danh sách
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <form action="index.php?controller=nhanvien&action=edit&id=<?php echo htmlspecialchars($nhanvien['Ma_NV']); ?>" method="post" class="needs-validation" novalidate>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Mã Nhân Viên</label>
                                <div class="form-control bg-light" readonly>
                                    <?php echo htmlspecialchars($nhanvien['Ma_NV']); ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="Ten_NV" class="form-label">Tên Nhân Viên <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control" 
                                       id="Ten_NV" 
                                       name="Ten_NV" 
                                       required 
                                       maxlength="100" 
                                       value="<?php echo htmlspecialchars($nhanvien['Ten_NV']); ?>"
                                       placeholder="Nhập tên nhân viên">
                                <div class="invalid-feedback">Vui lòng nhập tên nhân viên</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Giới tính <span class="text-danger">*</span></label>
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" 
                                               type="radio" 
                                               name="Phai" 
                                               id="phai_nam" 
                                               value="NAM" 
                                               <?php echo (strtoupper($nhanvien['Phai']) == 'NAM') ? 'checked' : ''; ?> 
                                               required>
                                        <label class="form-check-label" for="phai_nam">
                                            <i class="bi bi-gender-male text-primary me-1"></i>Nam
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="radio" 
                                               name="Phai" 
                                               id="phai_nu" 
                                               value="NU" 
                                               <?php echo (strtoupper($nhanvien['Phai']) == 'NU') ? 'checked' : ''; ?> 
                                               required>
                                        <label class="form-check-label" for="phai_nu">
                                            <i class="bi bi-gender-female text-danger me-1"></i>Nữ
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="Noi_Sinh" class="form-label">Nơi Sinh</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="Noi_Sinh" 
                                       name="Noi_Sinh" 
                                       maxlength="200" 
                                       value="<?php echo htmlspecialchars($nhanvien['Noi_Sinh']); ?>"
                                       placeholder="Nhập nơi sinh">
                            </div>

                            <div class="mb-3">
                                <label for="Ma_Phong" class="form-label">Phòng Ban <span class="text-danger">*</span></label>
                                <select id="Ma_Phong" 
                                        name="Ma_Phong" 
                                        class="form-select" 
                                        required>
                                    <option value="">-- Chọn Phòng Ban --</option>
                                    <?php foreach ($phongbans as $pb): ?>
                                        <option value="<?php echo htmlspecialchars($pb['Ma_Phong']); ?>" 
                                                <?php echo ($pb['Ma_Phong'] == $nhanvien['Ma_Phong']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($pb['Ten_Phong']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">Vui lòng chọn phòng ban</div>
                            </div>

                            <div class="mb-3">
                                <label for="Luong" class="form-label">Lương <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" 
                                           class="form-control" 
                                           id="Luong" 
                                           name="Luong" 
                                           min="0" 
                                           step="10" 
                                           required
                                           value="<?php echo htmlspecialchars($nhanvien['Luong']); ?>"
                                           placeholder="Nhập mức lương">
                                    <span class="input-group-text">VNĐ</span>
                                    <div class="invalid-feedback">Vui lòng nhập mức lương hợp lệ</div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-light d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i>Cập Nhật
                            </button>
                            <a href="index.php?controller=nhanvien&action=index" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i>Hủy
                            </a>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
// Bootstrap form validation
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
</script>

<?php require_once '../views/layouts/footer.php'; ?>