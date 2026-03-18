<?php include_once './MVC/Views/layout_header_admin.php'; ?>
<main>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-danger text-white">
                        <h4 class="mb-0">Thêm Thương hiệu Mới</h4>
                    </div>
                    <div class="card-body">
                        <form action="index.php?ctrl=admin&act=storeBrand" method="POST" enctype="multipart/form-data">

                            <div class="mb-3">
                                <label class="form-label fw-bold">Tên Thương hiệu</label>
                                <input type="text" name="name" class="form-control" required
                                    placeholder="Ví dụ: Nike, Adidas...">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Logo Thương hiệu</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Mô tả</label>
                                <textarea name="description" class="form-control" rows="4"
                                    placeholder="Giới thiệu về thương hiệu..."></textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="index.php?ctrl=admin&act=brands" class="btn btn-secondary">Quay lại</a>
                                <button type="submit" class="btn btn-danger px-4 fw-bold">Lưu Thương hiệu</button>
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