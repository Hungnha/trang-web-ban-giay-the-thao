    <?php include_once 'MVC/Views/layout_header_admin.php'; ?>
    <main>
        <div class="container-fluid px-lg-5">
            <h1 class="h2 fw-bold mb-4">Admin Dashboard</h1>
            <div class="row g-4">
                <?php include_once './MVC/Views/layout_admin_sidebar.php'; ?>

                <div class="col-lg-9 col-xl-10">
                    <div class="card p-4 shadow-sm">

                        <h2 class="mb-3 text-accent fw-bold">Quản Lý Người Dùng</h2>

                        <?php if (isset($_SESSION['info'])): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo $_SESSION['info'];
                                unset($_SESSION['info']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Họ Tên</th>
                                        <th>Email</th>
                                        <th>Số điện thoại</th>
                                        <th>Vai trò</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($users) && is_array($users)):
                                        foreach ($users as $u):
                                            // SỬA LỖI: Đảm bảo trang_thai luôn có giá trị mặc định là 1 nếu database chưa có cột
                                            $status = $u['trang_thai'] ?? 1;
                                            ?>
                                            <tr>
                                                <td><?php echo $u['ma_nguoidung']; ?></td>
                                                <td><?php echo $u['ho_ten']; ?></td>
                                                <td><?php echo $u['email']; ?></td>
                                                <td><?php echo $u['dien_thoai']; ?></td>
                                                <td>
                                                    <?php
                                                    if ($u['vaitro'] == 'quan_tri') {
                                                        echo '<span class="badge bg-danger">Admin</span>';
                                                    } else {
                                                        echo '<span class="badge bg-primary">User</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td class="btn-action">
                                                    <a href="index.php?ctrl=admin&act=viewUser&id=<?= $u['ma_nguoidung'] ?>"
                                                        class="btn btn-outline-info btn-sm me-1">
                                                        <i class="fas fa-eye"></i> Xem
                                                    </a>

                                                    <?php if ($status == 1): ?>
                                                        <a href="index.php?ctrl=admin&act=toggleUserStatus&id=<?= $u['ma_nguoidung'] ?>&status=0"
                                                            class="btn btn-outline-danger btn-sm"
                                                            onclick="return confirm('Bạn có chắc muốn KHÓA tài khoản này?')">
                                                            <i class="fas fa-user-slash"></i> Khóa
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="index.php?ctrl=admin&act=toggleUserStatus&id=<?= $u['ma_nguoidung'] ?>&status=1"
                                                            class="btn btn-outline-success btn-sm">
                                                            <i class="fas fa-user-check"></i> Mở khóa
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Chưa có người dùng nào.</td>
                                        </tr>
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
</body>

</html>