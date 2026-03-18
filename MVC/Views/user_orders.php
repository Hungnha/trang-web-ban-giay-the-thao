<?php
if (!isset($_SESSION['user'])) {
    header("Location: index.php?ctrl=user&act=login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn Hàng Của Tôi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="Public/Css/style.css">
    <style>
        .profile-link.active {
            color: #dc2626;
            font-weight: bold;
            border-left: 3px solid #dc2626;
            background: #f8f9fa;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100 bg-light">

    <?php include_once "layout_header.php"; ?>

    <main class="flex-grow-1 pt-5 pb-5">
        <div class="container">

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show mb-4">
                    <i class="fa-solid fa-circle-check me-2"></i><?= $_SESSION['success'];
                    unset($_SESSION['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show mb-4">
                    <i class="fa-solid fa-circle-exclamation me-2"></i><?= $_SESSION['error'];
                    unset($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row g-4">
                <?php include_once "layout_user_sidebar.php"; ?>

                <div class="col-lg-9">
                    <div class="profile-content-box bg-white p-4 rounded shadow-sm">
                        <h4 class="fw-bold mb-4 pb-2 border-bottom">Lịch Sử Đơn Hàng</h4>

                        <?php if (!empty($orders)): ?>
                            <?php foreach ($orders as $order): ?>
                                <?php
                                $statusColor = 'secondary';
                                $statusLabel = $order['trang_thai'];

                                // SỬA: Cập nhật đúng các giá trị ENUM trong DB
                                switch ($order['trang_thai']) {
                                    case 'cho_xac_nhan':
                                        $statusColor = 'warning text-dark';
                                        $statusLabel = 'Chờ xác nhận';
                                        break;
                                    case 'da_xac_nhan':
                                        $statusColor = 'info text-white';
                                        $statusLabel = 'Đã xác nhận';
                                        break;
                                    case 'dang_giao':
                                        $statusColor = 'primary';
                                        $statusLabel = 'Đang giao hàng';
                                        break;
                                    case 'hoan_thanh':
                                        $statusColor = 'success';
                                        $statusLabel = 'Giao thành công';
                                        break;
                                    case 'da_huy':
                                        $statusColor = 'danger';
                                        $statusLabel = 'Đã hủy';
                                        break; // Đã sửa thành da_huy
                                }
                                ?>

                                <div class="border rounded p-3 mb-3 bg-white shadow-sm">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <strong class="me-2 text-uppercase">Đơn hàng #<?= $order['ma_donhang'] ?></strong>
                                            <span class="badge bg-<?= $statusColor ?>"><?= $statusLabel ?></span>
                                        </div>
                                        <small class="text-muted"><i
                                                class="fa-regular fa-clock me-1"></i><?= date('d/m/Y H:i', strtotime($order['ngay_dat'])) ?></small>
                                    </div>

                                    <div class="d-flex justify-content-between text-muted small mb-3 border-top pt-2 mt-2">
                                        <span>Thanh toán: <strong
                                                class="text-dark"><?= $order['phuong_thuc_tt'] == 'COD' ? 'Khi nhận hàng' : $order['phuong_thuc_tt'] ?></strong></span>
                                        <span class="fs-6">Tổng tiền: <span
                                                class="text-danger fw-bold fs-5"><?= number_format($order['tong_tien'], 0, ',', '.') ?>
                                                ₫</span></span>
                                    </div>

                                    <div class="d-flex justify-content-end gap-2 align-items-center mt-3">

                                        <?php if ($order['trang_thai'] == 'cho_xac_nhan'): ?>
                                            <a href="index.php?ctrl=order&act=cancel&id=<?= $order['ma_donhang'] ?>"
                                                class="btn btn-sm btn-outline-danger fw-bold"
                                                onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')">
                                                <i class="fa-solid fa-xmark me-1"></i> Hủy đơn
                                            </a>
                                        <?php endif; ?>

                                        <?php if ($order['trang_thai'] == 'dang_giao'): ?>
                                            <a href="index.php?ctrl=order&act=confirmReceived&id=<?= $order['ma_donhang'] ?>"
                                                class="btn btn-sm btn-success fw-bold text-white shadow-sm"
                                                onclick="return confirm('Xác nhận bạn đã nhận được hàng?')">
                                                <i class="fa-solid fa-check me-1"></i> Đã nhận hàng
                                            </a>
                                        <?php endif; ?>

                                        <?php if ($order['trang_thai'] == 'hoan_thanh'): ?>
                                            <a href="index.php?ctrl=order&act=detail&id=<?= $order['ma_donhang'] ?>"
                                                class="btn btn-sm btn-warning fw-bold text-dark shadow-sm">
                                                <i class="fa-regular fa-star me-1"></i> Đánh giá
                                            </a>
                                            <a href="index.php?ctrl=order&act=reBuy&id=<?= $order['ma_donhang'] ?>"
                                                class="btn btn-sm btn-primary-custom text-white shadow-sm">
                                                <i class="fa-solid fa-cart-plus me-1"></i> Mua lại
                                            </a>
                                        <?php endif; ?>

                                        <?php if ($order['trang_thai'] == 'da_huy'): ?>
                                            <a href="index.php?ctrl=order&act=reBuy&id=<?= $order['ma_donhang'] ?>"
                                                class="btn btn-sm btn-primary-custom text-white shadow-sm">
                                                <i class="fa-solid fa-cart-plus me-1"></i> Mua lại
                                            </a>
                                        <?php endif; ?>

                                        <a href="?ctrl=order&act=detail&id=<?= $order['ma_donhang'] ?>"
                                            class="btn btn-sm btn-outline-secondary">
                                            Xem chi tiết
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fa-solid fa-box-open fs-1 text-muted mb-3" style="font-size: 4rem;"></i>
                                <p class="text-muted">Bạn chưa có đơn hàng nào.</p>
                                <a href="index.php" class="btn btn-danger rounded-pill px-4">Mua sắm ngay</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include_once "layout_footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>