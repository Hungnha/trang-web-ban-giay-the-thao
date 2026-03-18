<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên Hệ - Giày Hiện Đại</title>

</head>

<body class="d-flex flex-column min-vh-100 bg-light">

    <?php include_once "layout_header.php"; ?>

    <main class="flex-grow-1">

        <section class="position-relative bg-dark text-white overflow-hidden" style="height: 350px;">
            <img src="Public/images/slide.png" alt="Contact Banner"
                class="w-100 h-100 object-fit-cover position-absolute top-0 start-0" style="opacity: 0.4;">
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
                <div class="container text-center">
                    <h1 class="fw-bold display-4 mb-3 text-uppercase">Liên Hệ Với Chúng Tôi</h1>
                    <p class="fs-5 opacity-75">Giày Hiện Đại luôn sẵn sàng hỗ trợ bạn 24/7</p>
                </div>
            </div>
        </section>

        <section class="py-5 bg-white border-bottom">
            <div class="container py-4">
                <div class="row g-4 justify-content-center text-center">

                    <div class="col-md-4">
                        <div class="p-4 rounded-4 h-100 border hover-shadow transition bg-light">
                            <div class="d-inline-flex align-items-center justify-content-center bg-danger text-white rounded-circle mb-4 shadow-sm"
                                style="width: 70px; height: 70px;">
                                <i class="fa-solid fa-phone fs-3"></i>
                            </div>
                            <h4 class="fw-bold mb-3">Hotline</h4>
                            <p class="text-danger fw-bold fs-4 mb-1">0933 800 190</p>
                            <p class="text-secondary small">Hỗ trợ 8h00 – 22h00 tất cả các ngày</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="p-4 rounded-4 h-100 border hover-shadow transition bg-light">
                            <div class="d-inline-flex align-items-center justify-content-center bg-danger text-white rounded-circle mb-4 shadow-sm"
                                style="width: 70px; height: 70px;">
                                <i class="fa-solid fa-envelope fs-3"></i>
                            </div>
                            <h4 class="fw-bold mb-3">Email</h4>
                            <p class="text-danger fw-bold fs-5 mb-1">info@giayhiendai.vn</p>
                            <p class="text-secondary small">Phản hồi trong vòng 2 giờ làm việc</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="p-4 rounded-4 h-100 border hover-shadow transition bg-light">
                            <div class="d-inline-flex align-items-center justify-content-center bg-danger text-white rounded-circle mb-4 shadow-sm"
                                style="width: 70px; height: 70px;">
                                <i class="fa-solid fa-location-dot fs-3"></i>
                            </div>
                            <h4 class="fw-bold mb-3">Showroom HCM</h4>
                            <p class="text-danger fw-bold fs-5 mb-1">Quận 10, TP.HCM</p>
                            <p class="text-secondary small">268 Lý Thường Kiệt</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section class="py-5 bg-light">
            <div class="container py-4">
                <div class="row g-5">

                    <div class="col-lg-6">
                        <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border h-100">
                            <h3 class="fw-bold mb-4 text-uppercase border-bottom pb-3">Gửi Tin Nhắn</h3>

                            <form action="#" method="POST">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control rounded-3" id="name"
                                                placeholder="Họ tên" required>
                                            <label for="name">Họ và tên *</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="tel" class="form-control rounded-3" id="phone"
                                                placeholder="Số điện thoại" required>
                                            <label for="phone">Số điện thoại *</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control rounded-3" id="email" placeholder="Email"
                                        required>
                                    <label for="email">Email *</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control rounded-3" id="subject" placeholder="Chủ đề">
                                    <label for="subject">Chủ đề (Tư vấn size, bảo hành...)</label>
                                </div>

                                <div class="form-floating mb-4">
                                    <textarea class="form-control rounded-3" placeholder="Nội dung" id="message"
                                        style="height: 150px" required></textarea>
                                    <label for="message">Nội dung tin nhắn *</label>
                                </div>

                                <button type="submit"
                                    class="btn btn-primary-custom w-100 py-3 rounded-pill fw-bold text-uppercase shadow">
                                    <i class="fa-regular fa-paper-plane me-2"></i> Gửi Tin Nhắn Ngay
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="h-100 rounded-4 overflow-hidden shadow-sm border">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d246.62722825148!2d106.62563239753021!3d10.85386877314188!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752b6c59ba4c97%3A0x535e784068f1558b!2zVHLGsOG7nW5nIENhbyDEkeG6s25nIEZQVCBQb2x5dGVjaG5pYw!5e1!3m2!1svi!2s!4v1764487113412!5m2!1svi!2s"
                                width="100%" height="100%" style="border:0; min-height: 450px;" allowfullscreen=""
                                loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section class="py-5 bg-white">
            <div class="container text-center py-4">
                <h2 class="fw-bold mb-5 text-uppercase">Hệ Thống Cửa Hàng</h2>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="p-4 border rounded-3 bg-light h-100">
                            <h5 class="fw-bold text-danger mb-3">TP. Hồ Chí Minh</h5>
                            <p class="mb-1 fw-bold">268 Lý Thường Kiệt, Q.10</p>
                            <p class="text-muted">Hotline: 0933 800 190</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-4 border rounded-3 bg-light h-100">
                            <h5 class="fw-bold text-danger mb-3">Hà Nội</h5>
                            <p class="mb-1 fw-bold">123 Bà Triệu, Q. Hoàn Kiếm</p>
                            <p class="text-muted">Hotline: 0933 800 191</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-4 border rounded-3 bg-light h-100">
                            <h5 class="fw-bold text-danger mb-3">Đà Nẵng</h5>
                            <p class="mb-1 fw-bold">56 Lê Duẩn, Q. Hải Châu</p>
                            <p class="text-muted">Hotline: 0933 800 192</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <?php include_once "layout_footer.php"; ?>

    <script src="https://kit.fontawesome.com/your-code.js" crossorigin="anonymous"></script>
</body>

</html>