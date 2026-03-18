<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Cập nhật Sản phẩm: <?= $product['ten_sanpham'] ?></h4>
                </div>
                <div class="card-body">

                    <form action="index.php?ctrl=admin&act=updateProduct" method="POST" enctype="multipart/form-data">

                        <!-- INPUT HIDDEN: Để gửi ID sản phẩm cần sửa lên Controller -->
                        <input type="hidden" name="id" value="<?= $product['ma_sanpham'] ?>">

                        <div class="mb-3">
                            <label class="form-label">Tên sản phẩm</label>
                            <input type="text" name="name" class="form-control" required
                                value="<?= $product['ten_sanpham'] ?>">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Giá (VNĐ)</label>
                                <input type="number" name="price" class="form-control" required
                                    value="<?= $product['gia'] ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Thương hiệu</label>
                                <select name="cate_id" class="form-select" required>
                                    <?php if (isset($brands)): ?>
                                        <?php foreach ($brands as $br): ?>
                                            <option value="<?= $br['ma_thuonghieu'] ?>"
                                                <?= ($br['ma_thuonghieu'] == $product['ma_thuonghieu']) ? 'selected' : '' ?>>
                                                <?= $br['ten_thuonghieu'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Hình ảnh hiện tại</label><br>
                            <?php if ($product['hinh_anh_chinh']): ?>
                                <img src="Public/images/<?= $product['hinh_anh_chinh'] ?>" width="100"
                                    class="img-thumbnail mb-2">
                            <?php endif; ?>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <div class="form-text">Bỏ trống nếu không muốn thay đổi ảnh.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mô tả chi tiết</label>
                            <textarea name="description" class="form-control"
                                rows="4"><?= $product['mo_ta'] ?></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="index.php?ctrl=admin&act=products" class="btn btn-secondary">Hủy bỏ</a>
                            <button type="submit" class="btn btn-warning px-4">Cập nhật</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>