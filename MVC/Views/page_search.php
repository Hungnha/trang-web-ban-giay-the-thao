<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm kiếm: <?= htmlspecialchars($keyword) ?> - Giày Hiện Đại</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="Public/Css/style.css">
    
    <style>
        /* CSS CHO THANH TÌM KIẾM HERO */
        .search-hero-section {
            background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);
            padding: 3rem 0;
            border-bottom: 1px solid #ffebeb;
            margin-bottom: 2rem;
        }
        
        .search-box-container {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
        }

        .search-input-hero {
            height: 70px; /* Làm thanh tìm kiếm to và dài ra */
            font-size: 1.3rem;
            border-radius: 50px;
            padding-left: 35px;
            padding-right: 140px; /* Chừa chỗ cho nút tìm kiếm */
            border: 2px solid #e5e7eb;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .search-input-hero:focus {
            border-color: var(--primary-color);
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.15);
        }

        .btn-search-hero {
            position: absolute;
            right: 8px;
            top: 8px;
            height: 54px;
            border-radius: 40px;
            padding: 0 35px;
            font-size: 1.1rem;
            background-color: var(--primary-color);
            color: white;
            border: none;
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-search-hero:hover {
            background-color: #b91c1c;
            transform: scale(1.02);
        }
        
        .btn-search-hero i {
            font-size: 1.2rem; /* Kính lúp to hơn */
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100 bg-light">

    <?php include_once "layout_header.php"; ?>

    <main class="flex-grow-1 pb-5">
        
        <section class="search-hero-section">
            <div class="container text-center">
                <h2 class="fw-bold mb-3">Bạn muốn tìm gì hôm nay?</h2>
                <div class="search-box-container">
                    <form action="index.php" method="GET" class="w-100">
                        <input type="hidden" name="ctrl" value="page">
                        <input type="hidden" name="act" value="search">
                        
                        <input type="text" name="search" class="form-control search-input-hero" 
                               value="<?= htmlspecialchars($keyword ?? '') ?>" 
                               placeholder="Tìm kiếm . . ." 
                               autocomplete="off">
                               
                        <button type="submit" class="btn btn-search-hero">
                            <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm
                        </button>
                    </form>
                </div>
                
                <?php if (!empty($keyword)): ?>
                    <div class="mt-3 text-secondary">
                        Kết quả cho: <strong class="text-danger">"<?= htmlspecialchars($keyword) ?>"</strong> 
                        (<?= isset($totalProducts) ? $totalProducts : (isset($products) ? count($products) : 0) ?> sản phẩm)
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <div class="container">
            <div class="row">
                <div class="col-lg-3 mb-4">
                    <div class="card border-0 shadow-sm p-3 sticky-top" style="top: 20px; z-index: 1;">
                        <h5 class="fw-bold mb-3 text-uppercase border-bottom pb-2 text-danger">Bộ Lọc</h5>

                        <form action="index.php" method="GET">
                            <input type="hidden" name="ctrl" value="page">
                            <input type="hidden" name="act" value="search">
                            <?php if (!empty($keyword)): ?>
                                <input type="hidden" name="search" value="<?= htmlspecialchars($keyword) ?>">
                            <?php endif; ?>

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
                                        <label class="form-check-label" for="price_all">Tất cả</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="price" value="duoi-2tr"
                                            id="price_1" <?= ($priceRange ?? '') == 'duoi-2tr' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="price_1">Dưới 2 triệu</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="price" value="tren-4tr"
                                            id="price_3" <?= ($priceRange ?? '') == 'tren-4tr' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="price_3">Trên 4 triệu</label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-danger w-100 fw-bold rounded-pill">Áp Dụng Lọc</button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-9">
                    <?php if (!empty($message) && empty($products)): ?>
                        <div class="text-center py-5 bg-white rounded shadow-sm">
                            <img src="https://cdn-icons-png.flaticon.com/512/6134/6134065.png" width="100" class="mb-3 opacity-50">
                            <h4 class="fw-bold text-secondary"><?= $message ?></h4>
                            <p class="text-muted">Hãy thử tìm với từ khóa chung chung hơn (ví dụ: "Nike").</p>
                        </div>
                    <?php endif; ?>

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
                                                <span class="position-absolute top-0 start-0 m-2 badge bg-danger rounded-pill">-<?= $p['giam_gia'] ?>%</span>
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
                                                <span class="text-danger fw-bold fs-5"><?= number_format($gia_ban, 0, ',', '.') ?>đ</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <?php if (isset($totalPages) && $totalPages > 1): ?>
                        <nav class="mt-5">
                            <ul class="pagination justify-content-center">
                                <?php if (isset($page) && $page > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link text-danger" href="index.php?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>">
                                            <i class="fa-solid fa-chevron-left"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <?php
                                    // Tạo link giữ nguyên các tham số search, filter, chỉ thay đổi page
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

                                <?php if (isset($page) && $page < $totalPages): ?>
                                    <li class="page-item">
                                        <a class="page-link text-danger" href="index.php?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>">
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </main>

    <?php include_once "layout_footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>