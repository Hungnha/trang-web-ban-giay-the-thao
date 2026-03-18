<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="Public/Css/style.css">
<?php include_once "layout_header.php"; ?>

<main class="auth-container">
    <div class="auth-card">
        <div class="text-center mb-4">
            <h2 class="fw-bold mb-2">Chào Mừng Trở Lại!</h2>
            <p class="text-secondary">Đăng nhập để tiếp tục mua sắm</p>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger py-2"><?= $_SESSION['error'];
            unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['info'])): ?>
            <div class="alert alert-success py-2"><?= $_SESSION['info'];
            unset($_SESSION['info']); ?></div>
        <?php endif; ?>

        <form action="index.php?ctrl=user&act=postLogin" method="POST">
            <div class="mb-3">
                <input type="email" name="email" class="form-control form-control-lg-custom" placeholder="Email của bạn"
                    required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control form-control-lg-custom"
                    placeholder="Mật khẩu" required>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4 small">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="rememberMe">
                    <label class="form-check-label text-secondary" for="rememberMe">Ghi nhớ</label>
                </div>
                <a href="index.php?ctrl=user&act=forgot" class="text-danger text-decoration-none fw-bold">Quên mật
                    khẩu?</a>
            </div>

            <button type="submit" href="?ctrl=page&?act=home"
                class="btn btn-primary-custom w-100 py-3 rounded-pill fw-bold fs-6">ĐĂNG NHẬP</button>
        </form>

        <div class="text-center mt-4">
            <p class="text-secondary">Chưa có tài khoản?
                <a href="index.php?ctrl=user&act=register" class="text-danger fw-bold text-decoration-none">Đăng ký
                    ngay</a>
            </p>
        </div>
    </div>
</main>

<?php include_once "layout_footer.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>