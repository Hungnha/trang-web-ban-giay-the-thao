<div class="col-lg-3 col-xl-2">
    <div class="card shadow-sm"
        style="position: sticky; top: 100px; z-index: 100; max-height: calc(100vh - 120px); overflow-y: auto;">
        <div class="card-body p-2">
            <div class="nav flex-column nav-pills">
                <?php
                $act = $_GET['act'] ?? 'dashboard';
                ?>

                <a href="index.php?ctrl=admin&act=dashboard"
                    class="nav-link text-start <?= $act == 'dashboard' ? 'active' : '' ?>">
                    <i class="fas fa-chart-line me-2"></i> Dashboard
                </a>

                <a href="index.php?ctrl=admin&act=products"
                    class="nav-link text-start <?= ($act == 'products' || $act == 'addProduct' || $act == 'editProduct') ? 'active' : '' ?>">
                    <i class="fas fa-box me-2"></i> Quản lý Sản phẩm
                </a>

                <a href="index.php?ctrl=admin&act=brands"
                    class="nav-link text-start <?= ($act == 'brands' || $act == 'addBrand' || $act == 'editBrand') ? 'active' : '' ?>">
                    <i class="fas fa-box me-2"></i> Quản lý Thương hiệu
                </a>

                <a href="index.php?ctrl=admin&act=orders"
                    class="nav-link text-start <?= ($act == 'orders' || $act == 'orderDetail') ? 'active' : '' ?>">
                    <i class="fas fa-shopping-bag me-2"></i> Quản lý Đơn hàng
                </a>

                <a href="index.php?ctrl=admin&act=users"
                    class="nav-link text-start <?= ($act == 'users' || $act == 'addUser' || $act == 'edit_user') ? 'active' : '' ?>">
                    <i class="fas fa-box me-2"></i> Quản lý Người dùng
                </a>

                <a href="index.php?ctrl=admin&act=coupons"
                    class="nav-link text-start <?= ($act == 'coupons' || $act == 'addCoupon') ? 'active' : '' ?>">
                    <i class="fas fa-tags me-2"></i> Quản lý Coupons
                </a>

                <hr class="my-2">

                <a href="index.php?ctrl=user&act=logout" class="nav-link text-danger fw-medium text-start">
                    <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                </a>
            </div>
        </div>
    </div>
</div>