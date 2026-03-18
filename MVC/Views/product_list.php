<main class="bg-light pb-5">
    <div class="bg-white border-bottom py-3 mb-4 shadow-sm">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php" class="text-secondary text-decoration-none">Trang chủ</a></li>
                    <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">Sản phẩm</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm p-3">
                    <h5 class="fw-bold mb-3 text-uppercase border-bottom pb-2 text-danger">Bộ Lọc</h5>

                    <form action="index.php" method="GET">
                        <input type="hidden" name="ctrl" value="product">
                        <input type="hidden" name="act" value="list">

                        <div class="mb-4">
                            <label class="form-label fw-bold">Tìm kiếm</label>
                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                    value="<?= htmlspecialchars($keyword ?? '') ?>" placeholder="Tên giày...">
                                <button class="btn btn-danger" type="submit"><i
                                        class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Thương hiệu</label>
                            <div class="d-flex flex-column gap-2">
                                <?php if (!empty($brands)): ?>
                                    <?php foreach ($brands as $brand): ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="brand[]"
                                                value="<?= $brand['ma_thuonghieu'] ?>" id="brand_<?= $brand['ma_thuonghieu'] ?>"
                                                <?= (isset($brandIds) && in_array($brand['ma_thuonghieu'], $brandIds)) ? 'checked' : '' ?>>
                                            <label class="form-check-label cursor-pointer hover-red"
                                                for="brand_<?= $brand['ma_thuonghieu'] ?>">
                                                <?= htmlspecialchars($brand['ten_thuonghieu']) ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Mức giá</label>
                            <div class="d-flex flex-column gap-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="price" value="" id="price_all"
                                        <?= empty($priceRange) ? 'checked' : '' ?>>
                                    <label class="form-check-label cursor-pointer hover-red" for="price_all">Tất
                                        cả</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="price" value="duoi-2tr"
                                        id="price_1" <?= ($priceRange ?? '') == 'duoi-2tr' ? 'checked' : '' ?>>
                                    <label class="form-check-label cursor-pointer hover-red" for="price_1">Dưới 2
                                        triệu</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="price" value="2tr-4tr"
                                        id="price_2" <?= ($priceRange ?? '') == '2tr-4tr' ? 'checked' : '' ?>>
                                    <label class="form-check-label cursor-pointer hover-red" for="price_2">2 triệu - 4
                                        triệu</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="price" value="tren-4tr"
                                        id="price_3" <?= ($priceRange ?? '') == 'tren-4tr' ? 'checked' : '' ?>>
                                    <label class="form-check-label cursor-pointer hover-red" for="price_3">Trên 4
                                        triệu</label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-danger w-100 fw-bold rounded-pill">ÁP DỤNG LỌC</button>
                        <a href="index.php?ctrl=product&act=list"
                            class="btn btn-light w-100 mt-2 border rounded-pill text-secondary">Xóa bộ lọc</a>
                    </form>
                </div>
            </div>

            <div class="col-lg-9">
                <div
                    class="d-flex justify-content-between align-items-center mb-3 bg-white p-3 rounded shadow-sm border">
                    <span class="text-secondary">Hiển thị <strong><?= $totalProducts ?? 0 ?></strong> kết quả</span>
                    <form action="index.php" method="GET" class="d-flex align-items-center gap-2">
                        <input type="hidden" name="ctrl" value="product">
                        <input type="hidden" name="act" value="list">
                        <?php if (!empty($keyword)): ?><input type="hidden" name="search"
                                value="<?= htmlspecialchars($keyword) ?>"><?php endif; ?>

                        <label class="text-nowrap text-secondary small">Sắp xếp:</label>
                        <select name="sort" class="form-select form-select-sm border-secondary"
                            onchange="this.form.submit()" style="width: 150px;">
                            <option value="newest" <?= ($sort ?? '') == 'newest' ? 'selected' : '' ?>>Mới nhất</option>
                            <option value="price_asc" <?= ($sort ?? '') == 'price_asc' ? 'selected' : '' ?>>Giá tăng dần
                            </option>
                            <option value="price_desc" <?= ($sort ?? '') == 'price_desc' ? 'selected' : '' ?>>Giá giảm dần
                            </option>
                            <option value="name_asc" <?= ($sort ?? '') == 'name_asc' ? 'selected' : '' ?>>Tên A-Z</option>
                        </select>
                    </form>
                </div>

                <div class="row g-3">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $p): ?>
                            <?php $gia_ban = $p['gia'] * (1 - $p['giam_gia'] / 100); ?>

                            <div class="col-6 col-md-4 col-lg-4">
                                <div class="card h-100 border-0 shadow-sm product-card-hover">
                                    <div class="position-relative overflow-hidden p-3 bg-white d-flex align-items-center justify-content-center"
                                        style="height: 220px;">
                                        <a href="index.php?ctrl=product&act=detail&id=<?= $p['ma_sanpham'] ?>">
                                            <img src="Public/images/<?= htmlspecialchars($p['hinh_anh_chinh']) ?>"
                                                class="img-fluid hover-zoom" style="max-height: 100%; width: auto;"
                                                alt="<?= htmlspecialchars($p['ten_sanpham']) ?>">
                                        </a>
                                        <?php if ($p['giam_gia'] > 0): ?>
                                            <span
                                                class="position-absolute top-0 start-0 m-2 badge bg-danger rounded-pill">-<?= $p['giam_gia'] ?>%</span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="card-body text-center d-flex flex-column">
                                        <h6 class="card-title fw-bold mb-2 text-truncate">
                                            <a href="index.php?ctrl=product&act=detail&id=<?= $p['ma_sanpham'] ?>"
                                                class="text-decoration-none text-dark stretched-link">
                                                <?= htmlspecialchars($p['ten_sanpham']) ?>
                                            </a>
                                        </h6>
                                        <div class="mt-auto">
                                            <span
                                                class="text-danger fw-bold fs-5"><?= number_format($gia_ban, 0, ',', '.') ?>đ</span>
                                            <?php if ($p['giam_gia'] > 0): ?>
                                                <br><small
                                                    class="text-muted text-decoration-line-through"><?= number_format($p['gia'], 0, ',', '.') ?>đ</small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center py-5">
                            <img src="https://cdn-icons-png.flaticon.com/512/2748/2748558.png" width="100"
                                class="mb-3 opacity-50">
                            <p class="text-muted">Không tìm thấy sản phẩm nào phù hợp.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (isset($totalPages) && $totalPages > 1): ?>
                    <nav class="mt-5">
                        <ul class="pagination justify-content-center">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <?php
                                $params = $_GET;
                                $params['page'] = $i;
                                $query = http_build_query($params);
                                ?>
                                <li class="page-item <?= ($page ?? 1) == $i ? 'active' : '' ?>">
                                    <a class="page-link <?= ($page ?? 1) == $i ? 'bg-danger border-danger' : 'text-danger' ?>"
                                        href="index.php?<?= $query ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>