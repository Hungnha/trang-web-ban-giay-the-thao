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
    <title>Chi Tiết Đơn Hàng #<?= $order['ma_donhang'] ?></title>
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
            <div class="row g-4">
                <?php include_once "layout_user_sidebar.php"; ?>

                <div class="col-lg-9">
                    <div class="profile-content-box bg-white p-4 rounded shadow-sm">

                        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                            <h4 class="fw-bold m-0 text-uppercase">Chi Tiết Đơn Hàng #<?= $order['ma_donhang'] ?></h4>
                            <a href="index.php?ctrl=order&act=history" class="btn btn-sm btn-outline-secondary">
                                <i class="fa-solid fa-arrow-left me-1"></i> Quay lại
                            </a>
                        </div>

                        <div class="row mb-4 g-3">
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded h-100 border">
                                    <h6 class="fw-bold text-uppercase text-secondary small mb-3"><i
                                            class="fa-solid fa-location-dot me-1"></i> Địa chỉ nhận hàng</h6>
                                    <p class="mb-1 fw-bold fs-5"><?= htmlspecialchars($order['ho_ten_nguoi_nhan']) ?>
                                    </p>
                                    <p class="mb-1 text-muted"><i
                                            class="fa-solid fa-phone me-2"></i><?= htmlspecialchars($order['sdt_nguoi_nhan']) ?>
                                    </p>
                                    <p class="mb-0 text-muted small"><?= htmlspecialchars($order['dia_chi_giao']) ?></p>
                                    <?php if (!empty($order['ghi_chu'])): ?>
                                        <p class="mt-2 mb-0 text-danger small"><em>Note:
                                                <?= htmlspecialchars($order['ghi_chu']) ?></em></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded h-100 border text-md-end">
                                    <h6 class="fw-bold text-uppercase text-secondary small mb-3"><i
                                            class="fa-solid fa-circle-info me-1"></i> Thông tin đơn hàng</h6>
                                    <?php
                                    // LOGIC TRẠNG THÁI (dùng da_huy)
                                    $statusLabels = [
                                        'cho_xac_nhan' => ['bg' => 'warning', 'text' => 'Chờ xác nhận'],
                                        'da_xac_nhan' => ['bg' => 'info', 'text' => 'Đã xác nhận'],
                                        'dang_giao' => ['bg' => 'primary', 'text' => 'Đang giao hàng'],
                                        'hoan_thanh' => ['bg' => 'success', 'text' => 'Giao thành công'],
                                        'da_huy' => ['bg' => 'danger', 'text' => 'Đã hủy']
                                    ];
                                    $st = $statusLabels[$order['trang_thai']] ?? ['bg' => 'secondary', 'text' => $order['trang_thai']];
                                    ?>
                                    <div class="mb-2">Trạng thái: <span
                                            class="badge bg-<?= $st['bg'] ?> fs-6"><?= $st['text'] ?></span></div>
                                    <p class="text-muted small mb-1">Ngày đặt:
                                        <?= date('d/m/Y H:i', strtotime($order['ngay_dat'])) ?></p>
                                    <p class="text-muted small mb-0">Thanh toán:
                                        <strong><?= $order['phuong_thuc_tt'] ?></strong></p>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive mb-4">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th class="text-center" width="100">Số lượng</th>
                                        <th class="text-end" width="150">Đơn giá</th>
                                        <th class="text-end" width="150">Thành tiền</th>
                                        <?php if ($order['trang_thai'] == 'hoan_thanh'): ?>
                                            <th class="text-center" width="150">Hành động</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($orderDetails)): ?>
                                        <?php foreach ($orderDetails as $item): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="Public/images/<?= htmlspecialchars($item['hinh_anh_chinh']) ?>"
                                                            class="rounded border me-3"
                                                            style="width: 60px; height: 60px; object-fit: cover;">
                                                        <div>
                                                            <a href="index.php?ctrl=product&act=detail&id=<?= $item['ma_sanpham'] ?>"
                                                                class="text-dark text-decoration-none fw-bold">
                                                                <?= htmlspecialchars($item['ten_sanpham']) ?>
                                                            </a>
                                                            <div class="text-muted small mt-1">Size: <?= $item['size'] ?></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center fw-bold"><?= $item['so_luong'] ?></td>
                                                <td class="text-end text-muted"><?= number_format($item['gia']) ?> ₫</td>
                                                <td class="text-end fw-bold text-dark">
                                                    <?= number_format($item['gia'] * $item['so_luong']) ?> ₫</td>

                                                <?php if ($order['trang_thai'] == 'hoan_thanh'): ?>
                                                    <td class="text-center">
                                                        <a href="index.php?ctrl=product&act=detail&id=<?= $item['ma_sanpham'] ?>#review-form-box"
                                                            class="btn btn-sm btn-warning text-dark fw-bold shadow-sm">
                                                            <i class="fa-regular fa-star me-1"></i> Đánh giá
                                                        </a>
                                                    </td>
                                                <?php endif; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">
                                                <i class="fa-solid fa-triangle-exclamation text-warning fs-3 mb-2"></i><br>
                                                Không có thông tin sản phẩm cho đơn hàng này.<br>
                                                (Có thể do đơn hàng cũ chưa lưu chi tiết hoặc lỗi dữ liệu)
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="<?= ($order['trang_thai'] == 'hoan_thanh') ? 4 : 3 ?>"
                                            class="text-end fw-bold fs-5">TỔNG THANH TOÁN:</td>
                                        <td class="text-end fw-bold text-danger fs-4">
                                            <?= number_format($order['tong_tien']) ?> ₫</td>
                                        <?php if ($order['trang_thai'] == 'hoan_thanh'): ?>
                                            <td></td><?php endif; ?>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <?php if ($order['trang_thai'] == 'cho_xac_nhan'): ?>
                                <a href="index.php?ctrl=order&act=cancel&id=<?= $order['ma_donhang'] ?>"
                                    class="btn btn-danger fw-bold"
                                    onclick="return confirm('Bạn chắc chắn muốn hủy đơn hàng này?')">
                                    <i class="fa-solid fa-trash me-2"></i> Hủy đơn hàng
                                </a>
                            <?php endif; ?>

                            <?php if ($order['trang_thai'] == 'hoan_thanh' || $order['trang_thai'] == 'da_huy'): ?>
                                <a href="index.php?ctrl=order&act=reBuy&id=<?= $order['ma_donhang'] ?>"
                                    class="btn btn-primary-custom text-white fw-bold shadow">
                                    <i class="fa-solid fa-cart-plus me-2"></i> Mua lại đơn này
                                </a>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include_once "layout_footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>