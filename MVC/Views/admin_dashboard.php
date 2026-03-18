<?php
    include_once 'MVC/Views/layout_header_admin.php';
?>
<main>
    <div class="container-fluid px-lg-5">
        <h1 class="h2 fw-bold mb-4">Tổng quan hệ thống</h1>
        <div class="row g-4">
        <?php include_once './MVC/Views/layout_admin_sidebar.php'; ?>
            <div class="col-lg-9 col-xl-10">
                
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="p-4 rounded-3 shadow-sm" style="background-color: #dbeafe;">
                            <p class="h6 fw-bold text-primary">Doanh thu thực tế</p>
                            <p class="h3 fw-bold text-accent"><?= number_format($revenue ?? 0) ?> ₫</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-4 rounded-3 shadow-sm" style="background-color: #dcfce7;">
                            <p class="h6 fw-bold text-success">Tổng Đơn hàng</p>
                            <p class="h3 fw-bold text-accent"><?= number_format($countOrder ?? 0) ?></p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-4 rounded-3 shadow-sm" style="background-color: #fef9c3;">
                            <p class="h6 fw-bold text-warning">Sản phẩm</p>
                            <p class="h3 fw-bold text-accent"><?= number_format($countPro ?? 0) ?></p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-4 rounded-3 shadow-sm" style="background-color: #f3e8ff;">
                            <p class="h6 fw-bold text-info">Khách hàng</p>
                            <p class="h3 fw-bold text-accent"><?= number_format($countUser ?? 0) ?></p>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-8">
                        <div class="card p-4 shadow-sm h-100">
                            <h3 class="h5 fw-bold mb-3 text-secondary">Đơn hàng 7 ngày qua</h3>
                            <canvas id="orderChart"></canvas>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card p-4 shadow-sm h-100">
                            <h3 class="h5 fw-bold mb-3 text-secondary">Tỷ lệ trạng thái đơn</h3>
                            <div style="height: 250px; display: flex; justify-content: center;">
                                <canvas id="statusChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card p-4 shadow-sm">
                    <h3 class="h5 fw-bold mb-3">Đơn hàng mới nhất</h3>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Mã ĐH</th>
                                    <th>Ngày đặt</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($recentOrders)): ?>
                                    <?php foreach($recentOrders as $order): ?>
                                    <tr>
                                        <td>#<?= $order['ma_donhang'] ?></td>
                                        <td><?= date('d/m H:i', strtotime($order['ngay_dat'])) ?></td>
                                        <td class="text-accent fw-bold"><?= number_format($order['tong_tien']) ?> ₫</td>
                                        <td>
                                            <?php if($order['trang_thai'] == 'cho_xac_nhan'): ?>
                                                <span class="badge bg-warning text-dark">Chờ duyệt</span>
                                            <?php elseif($order['trang_thai'] == 'hoan_thanh'): ?>
                                                <span class="badge bg-success">Hoàn thành</span>
                                            <?php elseif($order['trang_thai'] == 'huy'): ?>
                                                <span class="badge bg-danger">Đã hủy</span>
                                            <?php else: ?>
                                                <span class="badge bg-primary"><?= $order['trang_thai'] ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="4" class="text-center">Chưa có đơn hàng nào</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // --- 1. BIỂU ĐỒ CỘT (Dữ liệu thật từ Controller) ---
    const ctxOrder = document.getElementById('orderChart').getContext('2d');
    new Chart(ctxOrder, {
        type: 'bar',
        data: {
            // Nhận mảng ngày tháng từ PHP
            labels: <?php echo json_encode($chartOrderLabels); ?>, 
            datasets: [{
                label: 'Số đơn hàng',
                // Nhận mảng số lượng từ PHP
                data: <?php echo json_encode($chartOrderData); ?>, 
                backgroundColor: 'rgba(220, 38, 38, 0.7)', // Màu đỏ
                borderColor: 'rgba(220, 38, 38, 1)',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { 
                    beginAtZero: true,
                    ticks: { stepSize: 1 } // Chỉ hiện số nguyên (1 đơn, 2 đơn...)
                }
            }
        }
    });

    // --- 2. BIỂU ĐỒ TRÒN ---
    const ctxStatus = document.getElementById('statusChart').getContext('2d'); // Đổi ID thành statusChart cho đúng layout
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($chartPieLabels); ?>,
            datasets: [{
                data: <?php echo json_encode($chartPieData); ?>,
                backgroundColor: [
                    '#F59E0B', // Vàng
                    '#3B82F6', // Xanh
                    '#10B981', // Xanh lá
                    '#EF4444', // Đỏ
                    '#6B7280'  // Xám (dự phòng)
                ],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>
</body>
</html>