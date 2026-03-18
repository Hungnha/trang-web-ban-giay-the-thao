<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký - Giày Hiện Đại</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="Public/Css/style.css">
</head>

<body class="d-flex flex-column min-vh-100">

    <?php include_once "layout_header.php"; ?>

    <main class="auth-container">
        <div class="auth-card">
            <div class="text-center mb-4">
                <h2 class="fw-bold mb-2">Tạo Tài Khoản Mới</h2>
                <p class="text-secondary">Đăng ký để nhận ưu đãi thành viên</p>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger py-2"><?= $_SESSION['error'];
                unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <form action="index.php?ctrl=user&act=postRegister" method="POST">
                <div class="mb-3">
                    <input type="text" name="name" class="form-control form-control-lg-custom" placeholder="Họ và tên"
                        required>
                </div>
                <div class="mb-3">
                    <input type="tel" name="phone" class="form-control form-control-lg-custom"
                        placeholder="Số điện thoại" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control form-control-lg-custom" placeholder="Email"
                        required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control form-control-lg-custom"
                        placeholder="Mật khẩu (tối thiểu 6 ký tự)" required minlength="6">
                </div>
                <div class="mb-4">
                    <input type="password" name="re_password" class="form-control form-control-lg-custom"
                        placeholder="Xác nhận mật khẩu" required>
                </div>

                <div class="form-check mb-4 small">
                    <input class="form-check-input" type="checkbox" id="agree" required>
                    <label class="form-check-label text-secondary" for="agree">
                        Tôi đồng ý với <a href="#" class="text-danger text-decoration-none">Điều khoản</a> và <a
                            href="#" class="text-danger text-decoration-none">Chính sách bảo mật</a>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary-custom w-100 py-3 rounded-pill fw-bold fs-6">ĐĂNG KÝ
                    NGAY</button>
            </form>

            <div class="text-center mt-4 mb-3">
                <span class="text-muted bg-white px-2 position-relative" style="z-index: 1;">Hoặc đăng ký bằng</span>
                <hr class="mt-n2 position-absolute w-100" style="left:0; z-index: 0; opacity: 0.1;">
            </div>

            <div class="row g-2">
                <div class="col-6">
                    <a href="#" class="btn btn-social w-100 rounded-pill py-2">
                        <i class="fab fa-google text-danger me-2"></i> Google
                    </a>
                </div>
                <div class="col-6">
                    <a href="#" class="btn btn-social w-100 rounded-pill py-2">
                        <i class="fab fa-facebook text-primary me-2"></i> Facebook
                    </a>
                </div>
            </div>

            <p class="text-center mt-4 mb-0 text-secondary">
                Đã có tài khoản? <a href="index.php?ctrl=user&act=login"
                    class="text-danger fw-bold text-decoration-none">Đăng nhập</a>
            </p>
        </div>
    </main>

    <?php include_once "layout_footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>