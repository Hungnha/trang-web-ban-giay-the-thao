<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Đơn hàng - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --accent-color: #DC2626;
            --bg-light: #f8f9fa;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
        }

        .text-accent {
            color: var(--accent-color) !important;
        }

        .nav-pills .nav-link {
            color: #495057;
            font-weight: 500;
            padding: 12px 20px;
            margin-bottom: 4px;
            border-radius: 8px;
        }

        .nav-pills .nav-link:hover {
            background-color: #e9ecef;
        }

        .nav-pills .nav-link.active {
            background-color: white;
            color: var(--accent-color);
            border-left: 4px solid var(--accent-color);
            font-weight: 700;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        main {
            padding-top: 100px;
            padding-bottom: 80px;
        }
    </style>
</head>

<body>
    <?php include_once 'MVC/Views/layout_header_admin.php'; ?>
    <main>
        <div class="container-fluid px-lg-5">
            <h1 class="h2 fw-bold mb-4">Quản lý Đơn hàng</h1>
            <div class="row g-4">
                <?php require_once 'MVC/Views/layout_admin_sidebar.php'; ?>
                <div class="col-lg-9 col-xl-10">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h3 class="mb-0 h5 fw-bold">Danh sách Đơn hàng</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered align-middle">
                                    <thead>
                                        <tr>
                                            <th>Mã ĐH</th>
                                            <th>Người nhận</th>
                                            <th>Ngày đặt</th>
                                            <th>Tổng tiền</th>
                                            <th>Trạng thái</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($orders)): ?>
                                            <?php foreach ($orders as $row): ?>
                                                <tr>
                                                    <td><strong>#<?= $row['ma_donhang'] ?></strong></td>
                                                    <td><?= htmlspecialchars($row['ho_ten_nguoi_nhan'] ?? $row['ho_ten'] ?? 'Khách lẻ') ?>
                                                    </td>
                                                    <td><?= date('d/m/Y', strtotime($row['ngay_dat'])) ?></td>
                                                    <td class="text-accent fw-bold"><?= number_format($row['tong_tien']) ?> đ
                                                    </td>

                                                    <td>
                                                        <?php $stt = $row['trang_thai']; ?>

                                                        <?php if ($stt == 'hoan_thanh'): ?>
                                                            <span class="badge bg-success p-2"><i
                                                                    class="fas fa-check-circle me-1"></i> Đã hoàn thành</span>

                                                        <?php elseif ($stt == 'da_huy'): ?>
                                                            <span class="badge bg-danger p-2"><i
                                                                    class="fas fa-times-circle me-1"></i> Đã hủy</span>

                                                        <?php else: ?>
                                                            <form action="index.php?ctrl=admin&act=updateStatus" method="POST"
                                                                class="d-flex gap-2">
                                                                <input type="hidden" name="order_id"
                                                                    value="<?= $row['ma_donhang'] ?>">
                                                                <select name="status" class="form-select form-select-sm fw-bold"
                                                                    style="width: 160px;" onchange="this.form.submit()">
                                                                    <?php if ($stt == 'cho_xac_nhan'): ?>
                                                                        <option value="cho_xac_nhan" selected>Chờ xác nhận</option>
                                                                        <option value="dang_giao" class="text-primary">Duyệt & Giao
                                                                        </option>
                                                                        <option value="da_huy" class="text-danger">✖ Hủy đơn</option>
                                                                    <?php elseif ($stt == 'dang_giao'): ?>
                                                                        <option value="dang_giao" selected>Đang giao hàng</option>
                                                                        <option value="hoan_thanh" class="text-success">Đã giao xong
                                                                        </option>
                                                                        <option value="da_huy" class="text-danger">✖ Hủy đơn</option>
                                                                    <?php endif; ?>
                                                                </select>
                                                            </form>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <a href="index.php?ctrl=admin&act=orderDetail&id=<?= $row['ma_donhang'] ?>"
                                                            class="btn btn-info btn-sm text-white">
                                                            <i class="fas fa-eye"></i> Xem
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center py-4">Chưa có đơn hàng nào.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>