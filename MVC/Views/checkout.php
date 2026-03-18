<?php
// TÍNH LẠI CÁC BIẾN CẦN THIẾT CHO VIEW NẾU CONTROLLER CHƯA TRUYỀN
if (!isset($finalTotal)) {
    $total = 0;
    foreach ($checkout_items as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    $finalTotal = $total - ($discount ?? 0);
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán</title>
</head>

<body class="d-flex flex-column min-vh-100 bg-light">
    <?php include_once './MVC/Views/layout_header.php'; ?>
    <main class="flex-grow-1 pt-5 pb-5">
        <div class="container">
            <h1 class="fw-bold text-center mb-5 text-uppercase">Thanh Toán</h1>
            <div class="row g-4">
                <div class="col-lg-8">
                    <form id="checkout-form" action="index.php?ctrl=order&act=processCheckout" method="POST">
                        <div class="d-flex flex-column gap-4">
                            <div class="card border-0 shadow-sm rounded-4 p-4">
                                <h4 class="fw-bold mb-3">Thông tin giao hàng</h4>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="fw-bold small">Họ tên</label>
                                        <input type="text" name="hoten" class="form-control"
                                            value="<?= htmlspecialchars($_SESSION['user']['ho_ten'] ?? '') ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fw-bold small">Số điện thoại</label>
                                        <input type="tel" name="sdt" class="form-control"
                                            value="<?= htmlspecialchars($_SESSION['user']['dien_thoai'] ?? '') ?>"
                                            required>
                                    </div>
                                    <div class="col-12">
                                        <label class="fw-bold small">Địa chỉ nhận hàng</label>
                                        <textarea name="diachi" class="form-control" rows="2"
                                            required><?= htmlspecialchars($_SESSION['user']['dia_chi'] ?? '') ?></textarea>
                                        <div class="form-text text-success"><i class="fa-solid fa-pen"></i> Bạn có thể
                                            sửa địa chỉ tại đây.</div>
                                    </div>
                                    <div class="col-12">
                                        <label class="fw-bold small">Ghi chú</label>
                                        <textarea name="ghichu" class="form-control" rows="1"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 shadow-sm rounded-4 p-4">
                                <h4 class="fw-bold mb-3">Thanh toán</h4>
                                <div class="form-check mb-2">
                                    <input type="radio" class="form-check-input" name="payment_method" value="COD"
                                        checked>
                                    <label class="form-check-label">Thanh toán khi nhận hàng (COD)</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="payment_method" value="vnpay">
                                    <label class="form-check-label text-primary fw-bold">Thanh toán Online
                                        (VNPAY)</label>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="tong_tien" value="<?= $finalTotal ?>">
                    </form>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h4 class="fw-bold mb-3">Đơn hàng</h4>
                        <?php foreach ($checkout_items as $item): ?>
                            <div class="d-flex justify-content-between mb-2">
                                <span><?= htmlspecialchars($item['name']) ?> (x<?= $item['quantity'] ?>)</span>
                                <span><?= number_format($item['price'] * $item['quantity']) ?>đ</span>
                            </div>
                        <?php endforeach; ?>
                        <hr>

                        <div class="mb-3">
                            <label class="fw-bold small mb-2 text-secondary">Mã ưu đãi / Voucher</label>
                            <form action="index.php?ctrl=cart&act=applyCoupon" method="POST" class="d-flex gap-2">
                                <input type="hidden" name="total_amount" value="<?= $total ?>">
                                <input type="text" name="code" class="form-control form-control-sm text-uppercase"
                                    placeholder="Nhập mã..." value="<?= $_SESSION['coupon']['code'] ?? '' ?>">
                                <button type="submit" class="btn btn-dark btn-sm px-3">Áp dụng</button>
                            </form>

                            <?php if (isset($_SESSION['coupon'])): ?>
                                <div class="mt-2 small text-success bg-light p-2 rounded border border-success">
                                    <i class="fa-solid fa-ticket me-1"></i> Đang dùng:
                                    <strong><?= $_SESSION['coupon']['code'] ?></strong>
                                    <a href="index.php?ctrl=cart&act=removeCoupon"
                                        class="text-danger float-end text-decoration-none fw-bold" title="Gỡ bỏ">X</a>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($_SESSION['error'])): ?>
                                <div class="text-danger small mt-2"><i class="fa-solid fa-circle-exclamation me-1"></i>
                                    <?= $_SESSION['error'];
                                    unset($_SESSION['error']); ?></div>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['success'])): ?>
                                <div class="text-success small mt-2"><i class="fa-solid fa-check me-1"></i>
                                    <?= $_SESSION['success'];
                                    unset($_SESSION['success']); ?></div>
                            <?php endif; ?>
                        </div>
                        <hr>

                        <div class="d-flex justify-content-between mb-2 text-secondary">
                            <span>Tạm tính</span>
                            <span><?= number_format($total) ?>đ</span>
                        </div>

                        <?php if ($discount > 0): ?>
                            <div class="d-flex justify-content-between mb-2 text-success">
                                <span>Giảm giá
                                    (<?= ($_SESSION['coupon']['loai_giam'] == 0) ? $_SESSION['coupon']['gia_tri'] . '%' : number_format($_SESSION['coupon']['gia_tri']) . 'đ' ?>)
                                </span>
                                <span>-<?= number_format($discount) ?>đ</span>
                            </div>
                        <?php endif; ?>

                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5 text-danger">
                            <span>Tổng cộng</span>
                            <span><?= number_format($finalTotal) ?>đ</span>
                        </div>
                        <button type="submit" form="checkout-form"
                            class="btn btn-danger w-100 mt-4 py-3 rounded-pill fw-bold">ĐẶT HÀNG NGAY</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include_once './MVC/Views/layout_footer.php'; ?>
</body>

</html>