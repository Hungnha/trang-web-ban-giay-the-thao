<?php include_once './MVC/Views/layout_header_admin.php'; ?>

<main>
    <div class="container-fluid px-lg-5">
        <h1 class="h2 fw-bold mb-4">Chi tiết đơn hàng #<?= $order['ma_donhang'] ?></h1>
        <div class="row g-4">
            <?php include_once './MVC/Views/layout_admin_sidebar.php'; ?>

            <div class="col-lg-9 col-xl-10">
                <div class="card p-4 shadow-sm">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="fw-bold text-accent">Thông tin người nhận</h5>
                            <p class="mb-1"><strong>Họ tên:</strong> <?= $order['ho_ten_nguoi_nhan'] ?></p>
                            <p class="mb-1"><strong>SĐT:</strong> <?= $order['sdt_nguoi_nhan'] ?></p>
                            <p class="mb-1"><strong>Địa chỉ:</strong> <?= $order['dia_chi_giao'] ?></p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h5 class="fw-bold text-accent">Trạng thái đơn hàng</h5>
                            <form action="index.php?ctrl=admin&act=updateStatus" method="POST" class="d-flex justify-content-md-end gap-2">
                                <input type="hidden" name="order_id" value="<?= $order['ma_donhang'] ?>">
                                <select name="status" class="form-select w-auto">
                                    <option value="cho_xac_nhan" <?= $order['trang_thai'] == 'cho_xac_nhan' ? 'selected' : '' ?>>Chờ xác nhận</option>
                                    <option value="da_xac_nhan" <?= $order['trang_thai'] == 'da_xac_nhan' ? 'selected' : '' ?>>Đã xác nhận</option>
                                    <option value="dang_giao" <?= $order['trang_thai'] == 'dang_giao' ? 'selected' : '' ?>>Đang giao</option>
                                    <option value="hoan_thanh" <?= $order['trang_thai'] == 'hoan_thanh' ? 'selected' : '' ?>>Hoàn thành</option>
                                    <option value="da_huy" <?= $order['trang_thai'] == 'da_huy' ? 'selected' : '' ?>>Đã hủy</option>
                                </select>
                                <button type="submit" class="btn btn-dark">Cập nhật</button>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Size</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orderDetails as $item): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="Public/images/<?= $item['hinh_anh_chinh'] ?>" width="50" class="rounded">
                                            <span><?= $item['ten_sanpham'] ?></span>
                                        </div>
                                    </td>
                                    <td><?= number_format($item['gia']) ?>đ</td>
                                    <td><?= $item['so_luong'] ?></td>
                                    <td><?= $item['size'] ?></td>
                                    <td class="fw-bold text-danger"><?= number_format($item['gia'] * $item['so_luong']) ?>đ</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end fw-bold">Tổng cộng:</td>
                                    <td class="fw-bold text-danger fs-5"><?= number_format($order['tong_tien']) ?>đ</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="mt-3">
                        <a href="index.php?ctrl=admin&act=orders" class="btn btn-outline-secondary">Quay lại danh sách đơn hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>