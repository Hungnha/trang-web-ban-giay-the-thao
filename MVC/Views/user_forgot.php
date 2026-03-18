<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu - Giày Hiện Đại</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Public/Css/style.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include_once "layout_header.php"; ?>

    <main class="auth-container my-5">
        <div class="auth-card mx-auto"
            style="max-width: 500px; padding: 30px; border: 1px solid #ddd; border-radius: 10px;">
            <div class="text-center mb-4">
                <h3 class="fw-bold">Quên Mật Khẩu?</h3>
                <p class="text-secondary">Nhập email để nhận liên kết đặt lại mật khẩu</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <?php if (!empty($message)): ?>
                <div class="alert alert-success"><?= $message ?></div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-bold">Email đăng ký</label>
                    <input type="email" name="email" class="form-control form-control-lg"
                        placeholder="nhap_email@gmail.com" required>
                </div>

                <button type="submit" name="btn_gui_yeu_cau" class="btn btn-danger w-100 py-2 rounded-pill fw-bold">GỬI
                    YÊU CẦU</button>
            </form>

            <div class="text-center mt-3">
                <a href="index.php?ctrl=user&act=login" class="text-decoration-none text-muted">Quay lại đăng nhập</a>
            </div>
        </div>
    </main>

    <?php include_once "layout_footer.php"; ?>
</body>

</html>