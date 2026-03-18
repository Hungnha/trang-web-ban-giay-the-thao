<?php
$act = $_GET['act'] ?? 'profile';
$ctrl = $_GET['ctrl'] ?? 'user';
?>
<div class="col-lg-3">
    <div class="profile-sidebar">
        <div class="d-flex align-items-center mb-4 px-2">
            <div class="user-avatar-box me-3">
                <i class="fa-regular fa-user"></i>
            </div>
            <div class="overflow-hidden">
                <small class="text-muted d-block">Tài khoản của</small>
                <strong class="text-dark text-truncate d-block">
                    <?= htmlspecialchars($_SESSION['user']['ho_ten'] ?? 'Khách hàng') ?>
                </strong>
            </div>
        </div>
        <nav>
            <a href="?ctrl=user&act=profile"
                class="profile-link <?= ($ctrl == 'user' && $act == 'profile') ? 'active' : '' ?>">
                <i class="fa-regular fa-id-card me-2"></i> Thông tin cá nhân
            </a>
            <a href="?ctrl=order&act=history"
                class="profile-link <?= ($ctrl == 'order' && $act == 'history') ? 'active' : '' ?>">
                <i class="fa-solid fa-box-open me-2"></i> Đơn hàng của tôi
            </a>
            <a href="?ctrl=user&act=profile&tab=wishlist"
                class="profile-link <?= $currentTab == 'wishlist' ? 'active' : '' ?>">
                <i class="fa-solid fa-heart me-2"></i> Yêu thích
            </a>
            <hr class="my-2">
            <a href="?ctrl=user&act=logout" class="profile-link text-danger">
                <i class="fa-solid fa-right-from-bracket me-2"></i> Đăng xuất
            </a>
        </nav>
    </div>
</div>