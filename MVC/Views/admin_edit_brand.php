<?php include_once './MVC/Views/layout_header_admin.php'; ?>
<main>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0">Cập nhật Thương hiệu</h4>
                    </div>
                    <div class="card-body">
                        <form action="index.php?ctrl=admin&act=updateBrand" method="POST" enctype="multipart/form-data">

                            <input type="hidden" name="id" value="<?= $brand['ma_thuonghieu'] ?>">

                            <div class="mb-3">
                                <label class="form-label fw-bold">Tên Thương hiệu</label>
                                <input type="text" name="name" class="form-control" required
                                    value="<?= htmlspecialchars($brand['ten_thuonghieu']) ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Logo hiện tại</label><br>
                                <?php if (!empty($brand['hinh_anh'])): ?>
                                    <img src="Public/images/<?= htmlspecialchars($brand['hinh_anh']) ?>"
                                        class="img-thumbnail mb-2" width="150">
                                <?php else: ?>
                                    <p class="text-muted small">Chưa có logo</p>
                                <?php endif; ?>
                                <input type="file" name="image" class="form-control" accept="image/*">
                                <div class="form-text">Bỏ trống nếu không muốn thay đổi logo.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Mô tả</label>
                                <textarea name="description" class="form-control"
                                    rows="4"><?= htmlspecialchars($brand['mo_ta']) ?></textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="index.php?ctrl=admin&act=brands" class="btn btn-secondary">Hủy bỏ</a>
                                <button type="submit" class="btn btn-warning px-4 fw-bold">Cập nhật</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>