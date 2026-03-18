<main class="bg-white pb-5">
    <div class="bg-light border-bottom py-3 mb-4">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small text-uppercase">
                    <li class="breadcrumb-item"><a href="index.php" class="text-secondary text-decoration-none">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="index.php?ctrl=product&act=list" class="text-secondary text-decoration-none">Sản phẩm</a></li>
                    <li class="breadcrumb-item active text-dark fw-bold" aria-current="page"><?= htmlspecialchars($product['ten_sanpham']) ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container">
        <form action="index.php" method="GET" id="productForm">
            <input type="hidden" name="ctrl" value="cart">
            <input type="hidden" name="act" value="add">
            <input type="hidden" name="id" value="<?= $product['ma_sanpham'] ?>">

            <div class="row g-5">
                <div class="col-lg-6">
                    <div class="product-gallery-box position-relative bg-light rounded-4 overflow-hidden border mb-3">
                        <img id="mainImage" src="Public/images/<?= htmlspecialchars($product['hinh_anh_chinh']) ?>" 
                             class="img-fluid object-fit-contain w-100" 
                             style="height: 500px;" 
                             alt="<?= htmlspecialchars($product['ten_sanpham']) ?>">
                        
                        <?php if ($product['giam_gia'] > 0): ?>
                            <span class="badge bg-danger position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill shadow-sm">
                                -<?= $product['giam_gia'] ?>%
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="row g-2">
                        <div class="col-3">
                            <div class="thumbnail-item active border rounded-3 overflow-hidden cursor-pointer" 
                                 onclick="changeImage(this, 'Public/images/<?= htmlspecialchars($product['hinh_anh_chinh']) ?>')">
                                <img src="Public/images/<?= htmlspecialchars($product['hinh_anh_chinh']) ?>" class="img-fluid w-100 h-100 object-fit-cover">
                            </div>
                        </div>
                        <?php if (!empty($gallery)): foreach ($gallery as $img): ?>
                            <div class="col-3">
                                <div class="thumbnail-item border rounded-3 overflow-hidden cursor-pointer" onclick="changeImage(this, 'Public/images/<?= htmlspecialchars($img['duong_dan']) ?>')">
                                    <img src="Public/images/<?= htmlspecialchars($img['duong_dan']) ?>" class="img-fluid w-100 h-100 object-fit-cover">
                                </div>
                            </div>
                        <?php endforeach; endif; ?>
                    </div>
                </div>

                <div class="col-lg-6 d-flex flex-column">
                    <h1 class="fw-bold text-dark mb-2 lh-base"><?= htmlspecialchars($product['ten_sanpham']) ?></h1>
                    
                    <div class="d-flex align-items-center mb-3">
                        <div class="text-warning me-2 fs-6">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                        </div>
                        <span class="text-muted border-start ps-3 ms-2 small">Đã bán 1.2k</span>
                        <a href="#reviews" class="text-primary text-decoration-none ms-3 small fw-bold" onclick="document.getElementById('reviews').scrollIntoView({behavior: 'smooth'})">Xem đánh giá</a>
                    </div>

                    <?php $gia_ban = $product['gia'] * (1 - $product['giam_gia'] / 100); ?>
                    <div class="p-3 bg-light rounded-3 mb-4">
                        <div class="d-flex align-items-end gap-2">
                            <span class="text-danger fw-bold display-6"><?= number_format($gia_ban, 0, ',', '.') ?>đ</span>
                            <?php if ($product['giam_gia'] > 0): ?>
                                <span class="text-muted text-decoration-line-through fs-5 mb-1"><?= number_format($product['gia'], 0, ',', '.') ?>đ</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold text-uppercase small text-secondary">Mô tả sản phẩm</h6>
                        <p class="text-secondary mb-0 line-clamp-3">
                            <?= nl2br(htmlspecialchars($product['mo_ta'])) ?>
                        </p>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <label class="fw-bold small text-uppercase">Kích thước</label>
                            <a href="#" class="text-decoration-none small text-danger fw-bold" data-bs-toggle="modal" data-bs-target="#sizeChartModal">Hướng dẫn chọn size</a>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <?php $sizes = [38, 39, 40, 41, 42, 43, 44]; foreach($sizes as $key => $s): ?>
                                <input type="radio" class="btn-check" name="size" id="size_<?= $s ?>" value="<?= $s ?>" <?= $key==2 ? 'checked' : '' ?>>
                                <label class="btn btn-outline-dark rounded-0 px-3 py-2 fw-bold" for="size_<?= $s ?>"><?= $s ?></label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold small text-uppercase mb-2 d-block">Số lượng</label>
                        <div class="input-group" style="width: 140px;">
                            <button class="btn btn-outline-secondary rounded-start-pill border-end-0" type="button" onclick="this.nextElementSibling.stepDown()"><i class="fa-solid fa-minus"></i></button>
                            <input type="number" name="quantity" value="1" min="1" class="form-control text-center border-secondary border-start-0 border-end-0 fw-bold">
                            <button class="btn btn-outline-secondary rounded-end-pill border-start-0" type="button" onclick="this.previousElementSibling.stepUp()"><i class="fa-solid fa-plus"></i></button>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex mt-auto">
                        <button type="submit" name="buy_now" value="0" class="btn btn-outline-danger btn-lg rounded-pill flex-grow-1 fw-bold">
                            <i class="fa-solid fa-cart-plus me-2"></i> THÊM VÀO GIỎ
                        </button>
                        <button type="submit" name="buy_now" value="1" class="btn btn-danger btn-lg rounded-pill flex-grow-1 fw-bold shadow">
                            MUA NGAY
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <div class="row mt-5 pt-5 border-top" id="reviews">
            <div class="col-lg-4 mb-4">
                <div class="sticky-top" style="top: 100px; z-index: 1;">
                    <div class="card border-0 shadow-sm bg-light">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Đánh giá sản phẩm</h5>
                            
                            <?php if (isset($_SESSION['user'])): ?>
                                <form action="index.php?ctrl=product&act=submitReview" method="POST">
                                    <input type="hidden" name="product_id" value="<?= $product['ma_sanpham'] ?>">
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold small text-uppercase">Mức độ hài lòng</label>
                                        <div class="rating-select d-flex gap-2 justify-content-center bg-white py-2 rounded border">
                                            <select name="rating" class="form-select border-0 text-center fw-bold text-warning">
                                                <option value="5">⭐⭐⭐⭐⭐ (Tuyệt vời)</option>
                                                <option value="4">⭐⭐⭐⭐ (Tốt)</option>
                                                <option value="3">⭐⭐⭐ (Bình thường)</option>
                                                <option value="2">⭐⭐ (Tệ)</option>
                                                <option value="1">⭐ (Rất tệ)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold small text-uppercase">Nội dung</label>
                                        <textarea name="content" class="form-control" rows="4" placeholder="Sản phẩm thế nào? Chất lượng ra sao?" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-dark w-100 rounded-pill fw-bold">Gửi Đánh Giá</button>
                                </form>
                            <?php else: ?>
                                <div class="text-center py-4">
                                    <p class="mb-3 text-secondary">Bạn cần đăng nhập để viết đánh giá.</p>
                                    <a href="index.php?ctrl=user&act=login" class="btn btn-outline-danger rounded-pill px-4 fw-bold">Đăng nhập ngay</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <h4 class="fw-bold mb-4">Khách hàng nói gì?</h4>
                
                <?php if(isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fa-solid fa-check-circle me-2"></i><?= $_SESSION['success']; unset($_SESSION['success']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="review-list">
                    <?php if (!empty($comments)): foreach ($comments as $cmt): ?>
                        <div class="d-flex gap-3 mb-4 pb-4 border-bottom">
                            <div class="flex-shrink-0">
                                <div class="avatar bg-secondary-subtle text-secondary fw-bold rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                    <?= strtoupper(substr($cmt['ho_ten'], 0, 1)) ?>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="fw-bold mb-0"><?= htmlspecialchars($cmt['ho_ten']) ?></h6>
                                    <small class="text-muted"><?= date('d/m/Y', strtotime($cmt['ngay_danhgia'])) ?></small>
                                </div>
                                <div class="text-warning small mb-2">
                                    <?php for($i=1; $i<=5; $i++) echo ($i <= $cmt['so_sao']) ? '<i class="fa-solid fa-star"></i>' : '<i class="fa-regular fa-star text-muted opacity-25"></i>'; ?>
                                </div>
                                <p class="text-secondary mb-0 bg-light p-3 rounded-3 border-start border-4 border-warning">
                                    <?= nl2br(htmlspecialchars($cmt['noi_dung'])) ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; else: ?>
                        <div class="text-center py-5 bg-light rounded-4 border border-dashed">
                            <i class="fa-regular fa-comments fs-1 text-muted mb-3 opacity-50"></i>
                            <p class="text-muted fw-medium">Chưa có đánh giá nào. Hãy là người đầu tiên!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="mt-5 pt-5">
            <h3 class="fw-bold text-center mb-4 text-uppercase ls-1">Có thể bạn sẽ thích</h3>
            
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
                <?php if (!empty($relatedProducts)): foreach ($relatedProducts as $rp): ?>
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm product-card-hover">
                            <div class="position-relative overflow-hidden bg-light rounded-top-3" style="padding-top: 100%;">
                                <a href="index.php?ctrl=product&act=detail&id=<?= $rp['ma_sanpham'] ?>" class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center p-3">
                                    <img src="Public/images/<?= htmlspecialchars($rp['hinh_anh_chinh']) ?>" 
                                         class="img-fluid object-fit-contain hover-zoom" 
                                         style="max-height: 100%;" 
                                         alt="<?= htmlspecialchars($rp['ten_sanpham']) ?>">
                                </a>
                            </div>
                            <div class="card-body text-center">
                                <h6 class="card-title text-truncate mb-2">
                                    <a href="index.php?ctrl=product&act=detail&id=<?= $rp['ma_sanpham'] ?>" class="text-dark text-decoration-none fw-bold stretched-link">
                                        <?= htmlspecialchars($rp['ten_sanpham']) ?>
                                    </a>
                                </h6>
                                <span class="text-danger fw-bold"><?= number_format($rp['gia']) ?>đ</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; endif; ?>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="sizeChartModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Bảng quy đổi kích thước</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <p>Chi tiết bảng size sẽ được cập nhật tại đây.</p>
        </div>
    </div>
  </div>
</div>

<style>
    .cursor-pointer { cursor: pointer; }
    .thumbnail-item { height: 80px; transition: all 0.2s; opacity: 0.6; }
    .thumbnail-item:hover, .thumbnail-item.active { opacity: 1; border-color: #DC2626 !important; box-shadow: 0 0 0 2px #DC2626; }
    
    .hover-zoom { transition: transform 0.3s ease; }
    .product-gallery-box:hover .hover-zoom { transform: scale(1.05); }
    
    .product-card-hover { transition: transform 0.3s, box-shadow 0.3s; }
    .product-card-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    
    input[type=number]::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
</style>

<script>
    function changeImage(element, newSrc) {
        document.getElementById('mainImage').src = newSrc;
        // Xóa active cũ
        document.querySelectorAll('.thumbnail-item').forEach(el => el.classList.remove('active'));
        // Thêm active mới
        element.classList.add('active');
    }
</script>