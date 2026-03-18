<?php include_once './MVC/Views/layout_header_admin.php'; ?>
<main>
    <div class="container-fluid px-lg-5">
        <h1 class="h2 fw-bold mb-4">Quản lý Thương hiệu</h1>

        <div class="row g-4">
            <?php include_once './MVC/Views/layout_admin_sidebar.php'; ?>

            <div class="col-lg-9 col-xl-10">
                <div class="card p-4 shadow-sm">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h4 fw-bold mb-0">Danh sách Thương hiệu</h2>
                        <a href="index.php?ctrl=admin&act=addBrand"
                            class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm">
                            <i class="fas fa-plus me-1"></i> Thêm mới
                        </a>
                    </div>

                    <?php if (isset($_SESSION['info'])): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i> <?= $_SESSION['info'];
                            unset($_SESSION['info']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?= $_SESSION['error'];
                            unset($_SESSION['error']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle border">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 ps-3" style="width: 5%">ID</th>
                                    <th class="py-3" style="width: 15%">Logo</th>
                                    <th class="py-3" style="width: 20%">Tên Thương hiệu</th>
                                    <th class="py-3" style="width: 35%">Mô tả</th>
                                    <th class="py-3 text-center" style="width: 10%">Sản phẩm</th>
                                    <th class="py-3 text-end pe-3" style="width: 15%">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($brands) && count($brands) > 0): ?>
                                    <?php foreach ($brands as $b): ?>
                                        <tr>
                                            <td class="ps-3 fw-bold text-secondary">#<?= $b['ma_thuonghieu'] ?></td>
                                            <td>
                                                <?php
                                                $imgSrc = !empty($b['hinh_anh']) ? 'Public/images/' . $b['hinh_anh'] : 'https://placehold.co/100x60?text=No+Logo';
                                                ?>
                                                <div class="bg-light rounded border d-flex align-items-center justify-content-center"
                                                    style="width: 80px; height: 50px; overflow: hidden;">
                                                    <img src="<?= htmlspecialchars($imgSrc) ?>"
                                                        onerror="this.src='https://placehold.co/100x60?text=Error'" alt="Logo"
                                                        class="img-fluid object-fit-contain" style="max-height: 100%;">
                                                </div>
                                            </td>
                                            <td class="fw-bold text-dark fs-6"><?= htmlspecialchars($b['ten_thuonghieu']) ?>
                                            </td>
                                            <td class="text-muted small">
                                                <div class="text-truncate" style="max-width: 250px;">
                                                    <?= !empty($b['mo_ta']) ? htmlspecialchars($b['mo_ta']) : '<i class="text-secondary opacity-50">Đang cập nhật...</i>' ?>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3">
                                                    <?= $b['so_luong_sp'] ?> SP
                                                </span>
                                            </td>
                                            <td class="text-end pe-3 text-nowrap">
                                                <a href="index.php?ctrl=admin&act=editBrand&id=<?= $b['ma_thuonghieu'] ?>"
                                                    class="btn btn-sm btn-outline-primary me-1" title="Sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <?php if ($b['so_luong_sp'] > 0): ?>
                                                    <button class="btn btn-sm btn-outline-secondary opacity-50" disabled
                                                        title="Không thể xóa vì đang có sản phẩm" style="cursor: not-allowed;">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                <?php else: ?>
                                                    <a href="index.php?ctrl=admin&act=deleteBrand&id=<?= $b['ma_thuonghieu'] ?>"
                                                        class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa thương hiệu này?')"
                                                        title="Xóa">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div
                                                class="d-flex flex-column align-items-center justify-content-center text-muted">
                                                <i class="fas fa-box-open fa-3x mb-3 opacity-25"></i>
                                                <p class="mb-0">Chưa có thương hiệu nào.</p>
                                            </div>
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
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>