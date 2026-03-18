<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Nhập mã xác nhận - Giày Hiện Đại</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Public/Css/style.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include_once "layout_header.php"; ?>

    <main class="auth-container my-5">
        <div class="auth-card mx-auto"
            style="max-width: 500px; padding: 30px; border: 1px solid #ddd; border-radius: 10px;">

            <?php if (!empty($success)): ?>
                <div class="text-center">
                    <h3 class="fw-bold text-success mb-3"><i class="fa-solid fa-check-circle"></i> Thành công!</h3>
                    <p><?= $success ?></p>
                    <a href="index.php?ctrl=user&act=login" class="btn btn-primary rounded-pill px-4">Đăng nhập ngay</a>
                </div>
            <?php else: ?>

                <div class="text-center mb-4">
                    <h3 class="fw-bold">Xác Nhận & Đổi Mật Khẩu</h3>
                    <p class="text-secondary small">Mã PIN đã được gửi tới: <strong><?= $email ?></strong></p>

                </div>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger py-2"><?= $error ?></div>
                <?php endif; ?>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nhập mã PIN (6 số)</label>
                        <input type="text" name="pin" class="form-control text-center fw-bold letter-spacing-2"
                            style="letter-spacing: 5px; font-size: 1.2rem;" placeholder="______" maxlength="6" required
                            autocomplete="off">
                    </div>

                    <hr class="my-4">

                    <div class="mb-3">
                        <label class="form-label">Mật khẩu mới</label>
                        <input type="password" name="new_password" class="form-control" required minlength="6">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Nhập lại mật khẩu</label>
                        <input type="password" name="re_password" class="form-control" required>
                    </div>

                    <button type="submit" name="btn_xac_nhan" class="btn btn-danger w-100 py-2 rounded-pill fw-bold">
                        XÁC NHẬN ĐỔI MẬT KHẨU
                    </button>
                </form>

                <div class="text-center mt-3">
                    <a href="index.php?ctrl=user&act=forgot" class="text-secondary small text-decoration-none">Gửi lại
                        mã?</a>
                </div>
            <?php endif; ?>

        </div>
    </main>

    <?php include_once "layout_footer.php"; ?>
</body>

</html>