<?php require_once '../views/layouts/header.php'; ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-0">
                        <i class="bi bi-person-plus-fill me-2"></i>Thêm Nhân Viên Mới
                    </h3>
                </div>

                <form action="index.php?controller=nhanvien&action=add" method="post" class="needs-validation" novalidate>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="Ma_NV" class="form-label">Mã Nhân Viên <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control" 
                                   id="Ma_NV" 
                                   name="Ma_NV" 
                                   required 
                                   maxlength="3" 
                                   pattern="[A-Z][0-9]{2}"
                                   placeholder="Nhập mã nhân viên"
                                   title="Mã nhân viên gồm 1 chữ in hoa và 2 chữ số (VD: A05, B04)">
                            <small class="form-text text-muted">
                                <i class="bi bi-info-circle me-1"></i>Ví dụ: A05, B04 (1 chữ in hoa + 2 chữ số)
                            </small>
                            <div class="invalid-feedback">
                                Vui lòng nhập mã nhân viên (VD: A05)
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
                                   placeholder="Nhập tên nhân viên">
                            <div class="invalid-feedback">
                                Vui lòng nhập tên nhân viên
                            </div>
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
                                           checked 
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
                                   placeholder="Nhập nơi sinh (không bắt buộc)">
                        </div>

                        <div class="mb-3">
                            <label for="Ma_Phong" class="form-label">Phòng Ban <span class="text-danger">*</span></label>
                            <select id="Ma_Phong" 
                                    name="Ma_Phong" 
                                    class="form-select" 
                                    required>
                                <option value="">-- Chọn Phòng Ban --</option>
                                <?php foreach ($phongbans as $pb): ?>
                                    <option value="<?php echo htmlspecialchars($pb['Ma_Phong']); ?>">
                                        <?php echo htmlspecialchars($pb['Ten_Phong']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                Vui lòng chọn phòng ban
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="Luong" class="form-label">Lương</label>
                            <div class="input-group">
                                <input type="number" 
                                       class="form-control" 
                                       id="Luong" 
                                       name="Luong" 
                                       min="0" 
                                       step="10"
                                       placeholder="Nhập mức lương">
                                <span class="input-group-text">VNĐ</span>
                            </div>
                            <small class="form-text text-muted">
                                <i class="bi bi-info-circle me-1"></i>Để trống nếu chưa xác định
                            </small>
                        </div>
                    </div>

                    <div class="card-footer bg-light d-flex justify-content-between">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save me-1"></i>Lưu Nhân Viên
                        </button>
                        <a href="index.php?controller=nhanvien&action=index" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i>Hủy
                        </a>
                    </div>
                </form>
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