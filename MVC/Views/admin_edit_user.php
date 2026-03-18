<div class="container mt-5">
    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0"><i class="fas fa-id-card me-2"></i> Chi tiết tài khoản người dùng</h4>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Họ và Tên:</label>
                    <p class="form-control bg-light"><?= $user['ho_ten'] ?? 'N/A'; ?></p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Email:</label>
                    <p class="form-control bg-light"><?= $user['email'] ?? 'N/A'; ?></p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Số điện thoại:</label>
                    <p class="form-control bg-light"><?= $user['dien_thoai'] ?? 'Chưa cập nhật'; ?></p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Vai trò:</label>
                    <p class="form-control bg-light">
                        <?= ($user['vaitro'] == 'quan_tri') ? 'Quản trị viên' : 'Khách hàng'; ?>
                    </p>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="fw-bold">Địa chỉ:</label>
                    <p class="form-control bg-light"><?= $user['dia_chi'] ?? 'Chưa có địa chỉ'; ?></p>
                </div>
                <div class="col-md-6">
                    <label class="fw-bold">Trạng thái:</label>
                    <p>
                        <?= (($user['trang_thai'] ?? 1) == 1) 
                            ? '<span class="badge bg-success">Đang hoạt động</span>' 
                            : '<span class="badge bg-danger">Đang bị khóa</span>'; ?>
                    </p>
                </div>
            </div>
            <div class="mt-4 border-top pt-3">
                <a href="index.php?ctrl=admin&act=users" class="btn btn-secondary px-4">Quay lại danh sách</a>
            </div>
        </div>
    </div>
</div>