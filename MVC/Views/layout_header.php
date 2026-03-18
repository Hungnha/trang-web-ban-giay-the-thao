<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giày Hiện Đại - Streetwear & Sneakers</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="Public/Css/style.css">
</head>

<body class="d-flex flex-column min-vh-100 bg-white text-gray-900">
    <header class="bg-white py-3 fixed-top border-bottom shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">

            <a href="index.php" class="navbar-brand">
                <img src="Public/images/logo.jpg" alt="Logo" height="50">
            </a>

            <nav class="d-none d-lg-flex gap-4 fw-bold align-items-center">
                <a href="index.php" class="text-decoration-none text-dark hover-red">Trang Chủ</a>
                <div class="dropdown">
                    <a href="?ctrl=product&act=list" class="text-decoration-none text-dark hover-red ">
                        Sản Phẩm
                    </a>
                </div>
                <a href="?ctrl=page&act=brands" class="text-decoration-none text-dark hover-red">Thương Hiệu</a>
                <a href="#" class="text-decoration-none text-dark hover-red">Blog</a>
                <a href="?ctrl=page&act=contact" class="text-decoration-none text-dark hover-red">Liên Hệ</a>
            </nav>

            <div class="d-flex align-items-center gap-3">
                <a href="?ctrl=product&act=search&keyword=...." class="text-dark fs-5"><i
                        class="fa-solid fa-magnifying-glass"></i></a>

                <?php if (isset($_SESSION['user'])): ?>
                    <div class="d-flex align-items-center gap-2">
                        <a href="?ctrl=user&act=profile" class="text-decoration-none text-dark d-flex align-items-center"
                            title="Vào trang cá nhân">
                            <i class="fa-solid fa-circle-user fs-4 text-danger me-2"></i>
                            <span class="fw-bold d-none d-md-block">
                                Xin chào,
                                <?= htmlspecialchars($_SESSION['user']['ho_ten'] ?? $_SESSION['user']['name'] ?? 'Khách') ?>
                            </span>
                        </a>

                        <span class="text-muted mx-1">|</span>
                        <a href="?ctrl=user&act=logout" class="text-secondary small text-decoration-none" title="Đăng xuất">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </a>
                    </div>
                <?php else: ?>
                    <a href="?ctrl=user&act=login"
                        class="text-dark text-decoration-none fw-bold border px-3 py-1 rounded-pill hover-bg-light">
                        <i class="fa-regular fa-user me-1"></i> Đăng nhập
                    </a>
                <?php endif; ?>

                <a href="?ctrl=cart&act=view" class="text-dark fs-5 position-relative ms-2">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                        style="font-size: 0.6rem;">
                        <?= !empty($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0 ?>
                    </span>
                </a>

                <button class="btn border-0 d-lg-none p-0 ms-2" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#mobileMenu">
                    <i class="fa-solid fa-bars fs-3"></i>
                </button>
            </div>
        </div>
    </header>

    <?php if (isset($_SESSION['cart_notify'])): ?>
        <div id="toast-notify" class="custom-toast">
            <i class="fa-solid fa-circle-check text-success fs-4"></i>
            <div class="toast-content flex-grow-1">
                <h6 class="fw-bold">Thành công!</h6>
                <p><?= $_SESSION['cart_notify']; ?></p>
            </div>
            <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
        </div>
        <?php unset($_SESSION['cart_notify']); ?>
    <?php endif; ?>

    <div style="height: 76px;"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toast = document.getElementById('toast-notify');
            if (toast) {
                setTimeout(function () {
                    toast.style.transition = 'opacity 0.5s ease';
                    toast.style.opacity = '0';
                    setTimeout(function () {
                        toast.remove();
                    }, 500);
                }, 3000); // 3 giây
            }
        });
    </script>