<?php
include_once 'MVC/Views/layout_header_admin.php';
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Thêm Sản phẩm mới</h4>
                </div>
                <div class="card-body">
                    <!-- QUAN TRỌNG: enctype="multipart/form-data" để upload ảnh -->
                    <form action="index.php?ctrl=admin&act=storeProduct" method="POST" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên sản phẩm</label>
                            <input type="text" name="name" class="form-control" required placeholder="Nhập tên giày...">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Giá (VNĐ)</label>
                                <input type="number" name="price" class="form-control" required
                                    placeholder="Ví dụ: 2000000">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Thương hiệu</label>
                                <select name="cate_id" class="form-select" required>
                                    <option value="">-- Chọn Thương hiệu --</option>
                                    <!-- Đổ dữ liệu thương hiệu từ Controller -->
                                    <?php if (isset($brands) && is_array($brands)): ?>
                                        <?php foreach ($brands as $br): ?>
                                            <!-- Kiểm tra đúng tên cột ID và Tên trong bảng thuonghieu -->
                                            <option value="<?= $br['ma_thuonghieu'] ?>">
                                                <?= $br['ten_thuonghieu'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Hình ảnh chính</label>
                            <input type="file" name="image" class="form-control" accept="image/*" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Mô tả chi tiết</label>
                            <textarea name="description" class="form-control" rows="4"
                                placeholder="Mô tả về sản phẩm..."></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="index.php?ctrl=admin&act=products" class="btn btn-secondary">Quay lại</a>
                            <button type="submit" class="btn btn-success px-4 fw-bold">Lưu Sản phẩm</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>