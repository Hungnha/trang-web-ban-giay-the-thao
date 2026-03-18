<main>
    <section class="hero-banner">
        <img src="Public/images/slide.png" alt="Banner Chính">
        <div class="hero-overlay">
            <div class="container">
                <h1 class="hero-title mb-3">KHÁM PHÁ STREETWEAR HIỆN ĐẠI</h1>
                <p class="text-white fs-5 mb-4">Từ Nike đến Yeezy, cập nhật mới nhất 2025</p>
                <a href="index.php?ctrl=product&act=list" class="btn btn-primary-custom btn-lg shadow-lg">Mua Ngay</a>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container py-4">
            <div class="section-header">
                <h2 class="section-title">Sản Phẩm Dành Cho Bạn</h2>
                
                <div class="d-flex justify-content-center gap-2 flex-wrap mt-4">
                    <a href="index.php?ctrl=page&act=home&filter=all" 
                       class="btn btn-outline-custom text-decoration-none <?= ($filter == 'all') ? 'active' : '' ?>">Tất Cả</a>
                    
                    <a href="index.php?ctrl=page&act=home&filter=banchay" 
                       class="btn btn-outline-custom text-decoration-none <?= ($filter == 'banchay') ? 'active' : '' ?>">Bán Chạy</a>
                    
                    <a href="index.php?ctrl=page&act=home&filter=khuyenmai" 
                       class="btn btn-outline-custom text-decoration-none <?= ($filter == 'khuyenmai') ? 'active' : '' ?>">Khuyến Mãi</a>
                    
                    <a href="index.php?ctrl=page&act=home&filter=moi" 
                       class="btn btn-outline-custom text-decoration-none <?= ($filter == 'moi') ? 'active' : '' ?>">Sản Phẩm Mới</a>
                </div>
            </div>

            <div class="row g-4">
                <?php if (!empty($displayProducts)): ?>
                    <?php foreach ($displayProducts as $p): ?>
                        <?php 
                            $gia_ban = $p['gia'] * (1 - $p['giam_gia'] / 100); 
                        ?>
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="product-card position-relative h-100">
                                <?php if ($p['giam_gia'] > 0): ?>
                                    <span class="badge-sale">-<?= $p['giam_gia'] ?>%</span>
                                <?php endif; ?>
                                
                                <a href="index.php?ctrl=product&act=detail&id=<?= $p['ma_sanpham'] ?>">
                                    <img src="Public/images/<?= htmlspecialchars($p['hinh_anh_chinh']) ?>" 
                                         class="card-img-top" 
                                         alt="<?= htmlspecialchars($p['ten_sanpham']) ?>">
                                </a>
                                
                                <div class="card-body text-center">
                                    <h5 class="product-title">
                                        <a href="index.php?ctrl=product&act=detail&id=<?= $p['ma_sanpham'] ?>" class="text-dark text-decoration-none">
                                            <?= htmlspecialchars($p['ten_sanpham']) ?>
                                        </a>
                                    </h5>
                                    
                                    <div class="mb-3">
                                        <span class="product-price d-block"><?= number_format($gia_ban, 0, ',', '.') ?>đ</span>
                                        <?php if ($p['giam_gia'] > 0): ?>
                                            <small class="text-muted text-decoration-line-through"><?= number_format($p['gia'], 0, ',', '.') ?>đ</small>
                                        <?php endif; ?>
                                    </div>

                                    <div class="d-flex gap-2 justify-content-center">
                                    <a href="index.php?ctrl=cart&act=add&id=<?= $p['ma_sanpham'] ?>" 
                                       class="btn btn-light border rounded-pill btn-sm fw-bold px-3">
                                        Thêm Giỏ
                                    </a>
                                        <a href="index.php?ctrl=product&act=detail&id=<?= $p['ma_sanpham'] ?>" class="btn btn-primary-custom btn-sm px-3">Xem</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5 text-muted fs-5">Không tìm thấy sản phẩm nào cho mục này!</div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="position-relative py-5 bg-dark text-white">
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: url('Public/images/slide.png') center/cover; opacity: 0.2;"></div>
        <div class="container position-relative py-5 text-center">
            <h2 class="fw-bold display-5 mb-4">KHUYẾN MÃI ĐẶC BIỆT</h2>
            <p class="fs-4 mb-5">Giảm giá lên đến 20% cho các dòng Nike & Adidas</p>
            <a href="index.php?ctrl=product&act=list" class="btn btn-light btn-lg rounded-pill px-5 fw-bold text-danger">XEM NGAY</a>
        </div>
    </section>

    <section class="mb-5 py-5 bg-light rounded-3 px-4">
        <div class="text-center mb-5">
            <h3 class="fw-bold m-0 text-uppercase d-inline-block border-bottom border-danger border-3 pb-2">
                Thương Hiệu Nổi Bật
            </h3>
        </div>
        
        <div class="row g-4 justify-content-center">
            <?php if (!empty($topBrands)): ?>
                <?php foreach ($topBrands as $brand): ?>
                    <?php $imgName = strtolower($brand['ten_thuonghieu']) . '.png'; ?>
                    
                    <div class="col-6 col-sm-4 col-md-2">
                        <a href="index.php?ctrl=product&act=list&brand[]=<?= $brand['ma_thuonghieu'] ?>" 
                           class="text-decoration-none">
                            
                            <div class="brand-box shadow-sm bg-white">
                                <img src="Public/images/<?= $imgName ?>" 
                                     alt="<?= htmlspecialchars($brand['ten_thuonghieu']) ?>" 
                                     class="brand-logo mb-2"
                                     onerror="this.style.display='none'"> <span class="brand-name text-uppercase"><?= htmlspecialchars($brand['ten_thuonghieu']) ?></span>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-4">
            <a href="index.php?ctrl=product&act=list" class="text-danger fw-bold text-decoration-none">
                Xem tất cả thương hiệu <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>
    </section>
    </section>

    <section class="py-5 bg-light">
        <div class="container py-4">
            <h2 class="section-title text-center mb-5">Tin Tức & Review</h2>
            <div class="row g-4">
                <?php if (!empty($latestPosts)): ?>
                    <?php foreach ($latestPosts as $post): ?>
                        <div class="col-md-6">
                            <div class="card news-card h-100">
                                <div class="row g-0 h-100">
                                    <div class="col-4">
                                        <img src="Public/images/<?= htmlspecialchars($post['image']) ?>" class="news-img h-100" alt="...">
                                    </div>
                                    <div class="col-8">
                                        <div class="card-body d-flex flex-column justify-content-center">
                                            <h5 class="card-title fw-bold mb-2"><?= htmlspecialchars($post['title']) ?></h5>
                                            <p class="card-text text-muted small mb-3 text-truncate-2"><?= htmlspecialchars($post['excerpt']) ?></p>
                                            <a href="#" class="text-danger fw-bold text-decoration-none small">ĐỌC TIẾP <i class="fas fa-arrow-right ms-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>