<?php
// Nhúng Header chuẩn (Đã bao gồm CSS và Bootstrap)
include_once './MVC/Views/layout_header_admin.php';
?>
<main>
    <div class="container-fluid px-lg-5">
        <h1 class="h2 fw-bold mb-4">Quản lý Sản phẩm</h1>

        <div class="row g-4">
            <?php include_once './MVC/Views/layout_admin_sidebar.php'; ?>

            <div class="col-lg-9 col-xl-10">
                <div class="card p-4 shadow-sm">

                    <div">
                        <h2 class="h4 fw-bold mb-0">Danh sách Sản phẩm</h2>
                        <a href="index.php?ctrl=admin&act=addProduct" class="btn btn-danger rounded-pill px-4 fw-bold">
                            <i class="fas fa-plus me-1"></i> Thêm Sản phẩm
                        </a>
                </div>

                <?php if (isset($_SESSION['info'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> <?= $_SESSION['info'];
                        unset($_SESSION['info']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%">ID</th>
                                <th style="width: 15%">Hình ảnh</th>
                                <th style="width: 30%">Tên Sản phẩm</th>
                                <th style="width: 15%">Giá</th>
                                <th style="width: 15%">Thương hiệu</th>
                                <th style="width: 20%" class="text-end">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($productList) && count($productList) > 0): ?>
                                <?php foreach ($productList as $sp): ?>
                                    <tr>
                                        <td>#<?= $sp['ma_sanpham'] ?></td>
                                        <td>
                                            <?php if (!empty($sp['hinh_anh_chinh'])): ?>
                                                <img src="Public/images/<?= $sp['hinh_anh_chinh'] ?>" alt="Product" width="60"
                                                    height="60" class="rounded border object-fit-cover">
                                            <?php else: ?>
                                                <span class="text-muted small bg-light p-2 rounded">No Image</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <p class="fw-bold mb-0 text-dark"><?= htmlspecialchars($sp['ten_sanpham']) ?>
                                            </p>
                                        </td>
                                        <td class="text-danger fw-bold">
                                            <?= number_format($sp['gia']) ?> ₫
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border">
                                                <?= htmlspecialchars($sp['ten_thuonghieu'] ?? 'Chưa rõ') ?>
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a href="index.php?ctrl=admin&act=editProduct&id=<?= $sp['ma_sanpham'] ?>"
                                                class="btn btn-sm btn-outline-primary me-1" title="Sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="index.php?ctrl=admin&act=deleteProduct&id=<?= $sp['ma_sanpham'] ?>"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')"
                                                title="Xóa">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fas fa-box-open fa-3x mb-3 opacity-50"></i>
                                        <p>Chưa có sản phẩm nào. Hãy thêm mới!</p>
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