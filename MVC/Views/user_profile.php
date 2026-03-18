<?php
// 1. Logic lấy user và tab hiện tại
if (!isset($user) && isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
$currentTab = isset($_GET['tab']) ? $_GET['tab'] : 'info';
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài Khoản - Giày Hiện Đại</title>
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
            <h1 class="fw-bold mb-4">Tài Khoản Của Tôi</h1>

            <div class="row g-4">
                <div class="col-lg-3">
                    <div class="profile-sidebar">
                        <div class="d-flex align-items-center mb-4 px-2">
                            <div class="bg-light rounded-circle p-3 me-3 text-danger">
                                <i class="fa-solid fa-user fs-4"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Tài khoản của</small>
                                <strong><?= htmlspecialchars($user['ho_ten'] ?? 'Khách hàng') ?></strong>
                            </div>
                        </div>
                        <nav>
                            <a href="?ctrl=user&act=profile&tab=info"
                                class="profile-link <?= $currentTab == 'info' ? 'active' : '' ?>">
                                <i class="fa-solid fa-user me-2"></i> Thông tin cá nhân
                            </a>

                            <a href="?ctrl=order&act=history" class="profile-link">
                                <i class="fa-solid fa-box me-2"></i> Đơn hàng của tôi
                            </a>

                            <a href="?ctrl=user&act=profile&tab=wishlist"
                                class="profile-link <?= $currentTab == 'wishlist' ? 'active' : '' ?>">
                                <i class="fa-solid fa-heart me-2"></i> Yêu thích
                            </a>

                            <hr class="my-2">
                            <a href="index.php?ctrl=user&act=logout" class="profile-link text-danger">
                                <i class="fa-solid fa-right-from-bracket me-2"></i> Đăng xuất
                            </a>
                        </nav>
                    </div>
                </div>

                <div class="col-lg-9">

                    <div class="<?= $currentTab == 'info' ? '' : 'd-none' ?>">
                        <div class="profile-content-box">
                            <h4 class="fw-bold mb-4 pb-2 border-bottom">Thông Tin Cá Nhân</h4>

                            <?php if (isset($_SESSION['success'])): ?>
                                <div class="alert alert-success"><?= $_SESSION['success'];
                                unset($_SESSION['success']); ?>
                                </div>
                            <?php endif; ?>

                            <form action="index.php?ctrl=user&act=updateProfile" method="POST">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small">Họ và tên</label>
                                        <input type="text" name="ho_ten" class="form-control bg-light"
                                            value="<?= htmlspecialchars($user['ho_ten'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small">Số điện thoại</label>
                                        <input type="text" name="dien_thoai" class="form-control bg-light"
                                            value="<?= htmlspecialchars($user['dien_thoai'] ?? '') ?>">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-bold small">Địa chỉ mặc định</label>
                                        <input type="text" name="dia_chi" class="form-control bg-light"
                                            value="<?= htmlspecialchars($user['dia_chi'] ?? '') ?>"
                                            placeholder="Địa chỉ giao hàng...">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-bold small">Email (Không thể thay đổi)</label>
                                        <input type="email" class="form-control bg-light text-muted"
                                            value="<?= htmlspecialchars($user['email'] ?? '') ?>" readonly>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary-custom px-4 py-2 rounded-pill fw-bold">
                                        Cập nhật thông tin
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="<?= $currentTab == 'wishlist' ? '' : 'd-none' ?>">
                        <div class="profile-content-box">
                            <h4 class="fw-bold mb-4 pb-2 border-bottom">Sản Phẩm Yêu Thích</h4>

                            <?php if (!empty($wishlist)): ?>
                                <div class="row g-3">
                                    <?php foreach ($wishlist as $item): ?>
                                        <div class="col-md-6">
                                            <div
                                                class="d-flex align-items-center p-3 border rounded bg-white position-relative">
                                                <a href="index.php?ctrl=user&act=toggleFavorite&id=<?= $item['ma_sanpham'] ?>"
                                                    class="position-absolute top-0 end-0 m-2 text-secondary"
                                                    onclick="return confirm('Bỏ thích?')" title="Xóa">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </a>

                                                <img src="Public/images/<?= htmlspecialchars($item['hinh_anh_chinh']) ?>"
                                                    class="rounded border me-3"
                                                    style="width: 70px; height: 70px; object-fit: contain;">

                                                <div>
                                                    <h6 class="mb-1 text-truncate" style="max-width: 180px;">
                                                        <a href="index.php?ctrl=product&act=detail&id=<?= $item['ma_sanpham'] ?>"
                                                            class="text-dark text-decoration-none">
                                                            <?= htmlspecialchars($item['ten_sanpham']) ?>
                                                        </a>
                                                    </h6>
                                                    <span
                                                        class="text-danger fw-bold"><?= number_format($item['gia'] * (1 - $item['giam_gia'] / 100)) ?>đ</span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <i class="fa-regular fa-heart fs-1 text-muted mb-3"></i>
                                    <p class="text-muted">Danh sách yêu thích trống.</p>
                                    <a href="index.php?ctrl=product&act=list"
                                        class="btn btn-outline-danger rounded-pill btn-sm">Mua sắm ngay</a>
                                </div>
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