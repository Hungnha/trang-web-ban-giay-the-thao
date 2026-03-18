<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thương Hiệu - Giày Hiện Đại</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="Public/Css/style.css">

    <style>
        .brand-logo-container {
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
            border-bottom: 1px solid #f0f0f0;
            margin-bottom: 15px;
            background: #fff;
        }

        .brand-card-full {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .brand-card-full:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            border-color: #dc3545;
        }

        .brand-desc {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100 bg-light">

    <?php include_once "layout_header.php"; ?>

    <main class="flex-grow-1 pt-5 pb-5">

        <section class="mb-5">
            <div class="container text-center">
                <span class="text-danger fw-bold text-uppercase small ls-1">Đối Tác Của Chúng Tôi</span>
                <h1 class="fw-bold display-5 mt-2 mb-3">Thương Hiệu Nổi Bật</h1>
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <p class="text-secondary fs-5">
                            Khám phá các thương hiệu hàng đầu thế giới mà chúng tôi tự hào phân phối chính hãng.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <div class="container mb-5">
            <div class="row g-4">

                <?php if (!empty($brands)): ?>
                    <?php foreach ($brands as $brand): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="brand-card-full shadow-sm">
                                <div class="brand-logo-container">
                                    <img src="<?= !empty($brand['hinh_anh']) ? 'Public/images/' . htmlspecialchars($brand['hinh_anh']) : 'Public/images/logo.jpg' ?>"
                                        alt="<?= htmlspecialchars($brand['ten_thuonghieu']) ?>" class="img-fluid"
                                        style="max-height: 100px; width: auto; object-fit: contain;"
                                        onerror="this.src='https://placehold.co/200x100?text=No+Logo'">
                                </div>

                                <h3 class="text-center fw-bold mb-3 text-uppercase text-dark">
                                    <?= htmlspecialchars($brand['ten_thuonghieu']) ?>
                                </h3>

                                <div class="brand-desc flex-grow-1">
                                    <?= !empty($brand['mo_ta']) ? htmlspecialchars($brand['mo_ta']) : 'Thương hiệu uy tín với các sản phẩm chất lượng cao, thiết kế độc đáo.' ?>
                                </div>

                                <div class="bg-light p-3 rounded mb-3">
                                    <ul class="list-unstyled mb-0 small text-secondary">
                                        <li class="mb-1"><i class="fa-solid fa-circle-check text-danger me-2"></i>Chính hãng
                                            100%</li>
                                        <li><i class="fa-solid fa-star text-warning me-2"></i>Bộ sưu tập mới nhất</li>
                                    </ul>
                                </div>

                                <a href="index.php?ctrl=product&act=list&brand[]=<?= $brand['ma_thuonghieu'] ?>"
                                    class="btn btn-outline-danger w-100 fw-bold rounded-pill mt-auto">
                                    Xem Sản Phẩm <i class="fa-solid fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <div class="alert alert-warning">
                            Đang cập nhật danh sách thương hiệu...
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>

        <section class="why-choose-section py-5 mt-5 bg-white border-top">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold text-dark">Tại Sao Chọn Giày Hiện Đại?</h2>
                </div>

                <div class="row g-4 text-center">
                    <div class="col-md-4">
                        <div class="p-4 border rounded-4 h-100 hover-shadow transition">
                            <i class="fa-solid fa-medal fa-3x text-danger mb-3"></i>
                            <h4 class="fw-bold mb-3">Chất Lượng Đảm Bảo</h4>
                            <p class="text-secondary small">Cam kết 100% sản phẩm chính hãng, đền bù gấp đôi nếu phát
                                hiện hàng giả.</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="p-4 border rounded-4 h-100 hover-shadow transition">
                            <i class="fa-solid fa-truck-fast fa-3x text-danger mb-3"></i>
                            <h4 class="fw-bold mb-3">Giao Hàng Nhanh</h4>
                            <p class="text-secondary small">Vận chuyển siêu tốc toàn quốc, cho phép kiểm tra hàng trước
                                khi thanh toán.</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="p-4 border rounded-4 h-100 hover-shadow transition">
                            <i class="fa-solid fa-rotate fa-3x text-danger mb-3"></i>
                            <h4 class="fw-bold mb-3">Đổi Trả Dễ Dàng</h4>
                            <p class="text-secondary small">Hỗ trợ đổi size, đổi mẫu miễn phí trong vòng 30 ngày nếu lỗi
                                sản xuất.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <?php include_once "layout_footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>