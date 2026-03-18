<?php
include_once './MVC/Views/layout_header_admin.php';
?>
<main>
    <div class="container-fluid px-lg-5">
        <h1 class="h2 fw-bold mb-4">Quản lý Khuyến mãi</h1>

        <div class="row g-4">
            <?php include_once './MVC/Views/layout_admin_sidebar.php'; ?>

            <div class="col-lg-9 col-xl-10">

                <?php if (isset($_SESSION['info'])): ?>
                    <div class="alert alert-success alert-dismissible fade show mb-4">
                        <i class="fas fa-check-circle me-2"></i><?= $_SESSION['info'];
                        unset($_SESSION['info']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card p-4 h-100 shadow-sm">
                            <h4 class="h5 fw-bold mb-3 text-secondary">Thêm Mã Mới</h4>
                            <form action="index.php?ctrl=admin&act=addCoupon" method="POST">
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Mã Code</label>
                                    <input type="text" name="code" class="form-control text-uppercase"
                                        placeholder="VD: SALE10" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Loại giảm giá</label>
                                    <select name="loai_giam" class="form-select">
                                        <option value="0">Theo Phần trăm (%)</option>
                                        <option value="1">Theo Tiền mặt (VNĐ)</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Giá trị giảm</label>
                                    <input type="number" name="amount" class="form-control"
                                        placeholder="VD: 10 hoặc 50000" required>
                                    <div class="form-text">Nhập số % (VD: 10) hoặc số tiền (VD: 50000).</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Đơn tối thiểu</label>
                                    <input type="number" name="min_order" class="form-control" value="0" required>
                                    <div class="form-text">Nhập 0 nếu không giới hạn.</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Số lượng phát hành</label>
                                    <input type="number" name="qty" class="form-control" value="50" min="1" required>
                                </div>

                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label class="form-label fw-bold small">Ngày bắt đầu</label>
                                        <input type="date" name="start_date" class="form-control" required>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label fw-bold small">Ngày kết thúc</label>
                                        <input type="date" name="end_date" class="form-control" required>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-danger w-100 py-2 fw-bold">
                                    <i class="fas fa-plus-circle me-1"></i> Tạo Mã
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card p-4 h-100 shadow-sm">
                            <h4 class="h5 fw-bold mb-3 text-secondary">Danh Sách Mã Đang Hoạt Động</h4>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Code</th>
                                            <th>Loại</th>
                                            <th>Giá trị</th>
                                            <th>Còn lại</th>
                                            <th>Hết hạn</th>
                                            <th class="text-end">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($coupons)): ?>
                                            <?php foreach ($coupons as $c): ?>
                                                <?php
                                                $isExpired = strtotime($c['ngay_het_han']) < time();
                                                $isOutOfStock = $c['so_luong'] <= 0;
                                                $opacity = ($isExpired || $isOutOfStock) ? 'opacity-50' : '';
                                                ?>
                                                <tr class="<?= $opacity ?>">
                                                    <td>
                                                        <span
                                                            class="badge bg-light text-dark border fs-6"><?= htmlspecialchars($c['code']) ?></span>
                                                        <?php if ($isExpired): ?> <span class="badge bg-danger ms-1">Hết
                                                                hạn</span>
                                                        <?php elseif ($isOutOfStock): ?> <span
                                                                class="badge bg-secondary ms-1">Hết lượt</span> <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?= ($c['loai_giam'] == 0) ? 'Phần trăm' : 'Tiền mặt' ?>
                                                    </td>
                                                    <td class="text-success fw-bold">
                                                        <?= ($c['loai_giam'] == 0) ? '-' . $c['so_tien_giam'] . '%' : '-' . number_format($c['so_tien_giam']) . 'đ' ?>
                                                    </td>
                                                    <td><?= $c['so_luong'] ?></td>
                                                    <td><?= date('d/m/Y', strtotime($c['ngay_het_han'])) ?></td>
                                                    <td class="text-end">
                                                        <a href="index.php?ctrl=admin&act=deleteCoupon&id=<?= $c['ma_giamgia'] ?>"
                                                            class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Xóa mã này?');">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center py-4 text-muted">Chưa có mã giảm giá nào.
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>