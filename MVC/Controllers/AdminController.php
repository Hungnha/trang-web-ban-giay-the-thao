<?php
include_once './MVC/Models/AdminModel.php';
include_once './MVC/Models/ProductModel.php';
include_once './MVC/Models/OrderModel.php';
include_once './MVC/Models/User.php';
include_once './MVC/Models/CouponModel.php';
include_once './MVC/Models/BrandModel.php';

class AdminController
{
    private $adminModel;
    private $productModel;
    private $orderModel;
    private $couponModel;
    private $brandModel;

    public function __construct()
    {
        // 1. Kiểm tra quyền Admin (Chỉ quản trị viên mới được vào)
        if (!isset($_SESSION['user']) || $_SESSION['user']['vaitro'] != 'quan_tri') {
            header("Location: index.php?ctrl=user&act=login");
            exit();
        }

        // 2. Khởi tạo các Model
        $this->adminModel = new AdminModel();
        $this->productModel = new ProductModel();
        $this->orderModel = new OrderModel();
        $this->couponModel = new CouponModel();
        $this->brandModel = new BrandModel();
    }

    // =========================================================
    // DASHBOARD (THỐNG KÊ)
    // =========================================================
    public function dashboard()
    {
        $countPro = $this->adminModel->countProducts();
        $countUser = $this->adminModel->countUsers();
        $countOrder = method_exists($this->adminModel, 'countOrders') ? $this->adminModel->countOrders() : 0;
        $revenue = $this->adminModel->getTotalRevenue();
        $recentOrders = $this->adminModel->getRecentOrders();

        // Biểu đồ 7 ngày
        $stats = method_exists($this->adminModel, 'getOrdersStatistics') ? $this->adminModel->getOrdersStatistics() : $this->adminModel->getOrdersLast7Days();
        $chartOrderLabels = [];
        $chartOrderData = [];

        for ($i = 6; $i >= 0; $i--) {
            $dateCheck = date('Y-m-d', strtotime("-$i days"));
            $chartOrderLabels[] = date('d/m', strtotime($dateCheck));
            $quantity = 0;
            if (!empty($stats)) {
                foreach ($stats as $item) {
                    if ($item['ngay'] == $dateCheck) {
                        $quantity = (int) $item['so_luong'];
                        break;
                    }
                }
            }
            $chartOrderData[] = $quantity;
        }

        // Biểu đồ trạng thái đơn hàng
        $statsStatus = $this->adminModel->getOrderStatusStats();
        $chartPieLabels = [];
        $chartPieData = [];
        $statusName = [
            'cho_xac_nhan' => 'Chờ xác nhận',
            'da_xac_nhan' => 'Đã xác nhận',
            'dang_giao' => 'Đang giao',
            'hoan_thanh' => 'Hoàn thành',
            'da_huy' => 'Đã hủy'
        ];

        if (!empty($statsStatus)) {
            foreach ($statsStatus as $item) {
                $chartPieLabels[] = $statusName[$item['trang_thai']] ?? $item['trang_thai'];
                $chartPieData[] = (int) $item['so_luong'];
            }
        }

        include_once './MVC/Views/admin_dashboard.php';
    }

    // =========================================================
    // QUẢN LÝ THƯƠNG HIỆU
    // =========================================================
    public function brands()
    {
        $brands = $this->brandModel->getAllBrandsWithCount();
        include_once './MVC/Views/admin_brands.php';
    }

    public function addBrand()
    {
        include_once './MVC/Views/admin_add_brands.php';
    }

    public function storeBrand()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $image = "";
            if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
                $image = time() . "_" . basename($_FILES["image"]["name"]);
                move_uploaded_file($_FILES["image"]["tmp_name"], "Public/images/" . $image);
            }
            $this->brandModel->insertBrand($_POST['name'], $image, $_POST['description']);
            $_SESSION['info'] = "Thêm thương hiệu thành công!";
            header("Location: index.php?ctrl=admin&act=brands");
            exit;
        }
    }

    public function editBrand()
    {
        $brand = $this->brandModel->getBrandById($_GET['id']);
        include_once './MVC/Views/admin_edit_brand.php';
    }

    public function updateBrand()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $image = "";
            if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
                $image = time() . "_" . basename($_FILES["image"]["name"]);
                move_uploaded_file($_FILES["image"]["tmp_name"], "Public/images/" . $image);
            }
            $this->brandModel->updateBrand($_POST['id'], $_POST['name'], $image, $_POST['description']);
            $_SESSION['info'] = "Cập nhật thành công!";
            header("Location: index.php?ctrl=admin&act=brands");
            exit;
        }
    }

    public function deleteBrand()
    {
        $count = $this->brandModel->countProductsInBrand($_GET['id']);
        if ($count > 0) {
            $_SESSION['error'] = "Không thể xóa! Đang có $count sản phẩm.";
        } else {
            $this->brandModel->deleteBrand($_GET['id']);
            $_SESSION['info'] = "Đã xóa!";
        }
        header("Location: index.php?ctrl=admin&act=brands");
        exit;
    }

    // =========================================================
    // QUẢN LÝ SẢN PHẨM
    // =========================================================
    public function products()
    {
        $productList = $this->productModel->getAllProducts();
        include_once './MVC/Views/admin_products.php';
    }

    public function addProduct()
    {
        $brands = $this->productModel->getAllBrands();
        include_once './MVC/Views/admin_add.php';
    }

    public function storeProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $image = "";
            if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
                $image = time() . "_" . basename($_FILES["image"]["name"]);
                move_uploaded_file($_FILES["image"]["tmp_name"], "Public/images/" . $image);
            }
            $this->productModel->insertProduct($_POST['name'], $_POST['price'], $image, $_POST['description'], $_POST['cate_id']);
            $_SESSION['info'] = "Đã thêm sản phẩm!";
            header("Location: index.php?ctrl=admin&act=products");
            exit;
        }
    }

    public function editProduct()
    {
        $product = $this->productModel->getProductById($_GET['id']);
        $brands = $this->productModel->getAllBrands();
        include_once './MVC/Views/admin_edit.php';
    }

    public function updateProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $image = "";
            if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
                $image = time() . "_" . basename($_FILES["image"]["name"]);
                move_uploaded_file($_FILES["image"]["tmp_name"], "Public/images/" . $image);
            }
            $this->productModel->updateProduct($_POST['id'], $_POST['name'], $_POST['price'], $image, $_POST['description'], $_POST['cate_id']);
            $_SESSION['info'] = "Cập nhật thành công!";
            header("Location: index.php?ctrl=admin&act=products");
            exit;
        }
    }

    public function deleteProduct()
    {
        $this->productModel->deleteProduct($_GET['id']);
        $_SESSION['info'] = "Đã xóa sản phẩm!";
        header("Location: index.php?ctrl=admin&act=products");
        exit;
    }

    // =========================================================
    // QUẢN LÝ ĐƠN HÀNG
    // =========================================================
    public function orders()
    {
        $orders = $this->orderModel->getAllOrders();
        include_once './MVC/Views/admin_orders.php';
    }

    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->orderModel->updateStatus($_POST['order_id'], $_POST['status']);
        }
        header("Location: index.php?ctrl=admin&act=orders");
        exit;
    }

    public function orderDetail()
    {
        $id = $_GET['id'] ?? 0;
        $order = $this->orderModel->getOrderById($id);
        $orderDetails = $this->orderModel->getOrderDetails($id);
        include_once './MVC/Views/admin_order_detail.php';
    }

    // =========================================================
    // QUẢN LÝ MÃ GIẢM GIÁ
    // =========================================================
    public function coupons()
    {
        $coupons = $this->couponModel->getAllCoupons();
        include_once './MVC/Views/admin_coupons.php';
    }

    public function addCoupon()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->couponModel->insertCoupon($_POST['code'], $_POST['loai_giam'], $_POST['amount'], $_POST['min_order'], $_POST['qty'], $_POST['start_date'], $_POST['end_date']);
            $_SESSION['info'] = "Đã thêm mã giảm giá!";
            header("Location: index.php?ctrl=admin&act=coupons");
            exit;
        }
    }

    public function deleteCoupon()
    {
        $this->couponModel->deleteCoupon($_GET['id']);
        $_SESSION['info'] = "Đã xóa mã!";
        header("Location: index.php?ctrl=admin&act=coupons");
        exit;
    }

    // =========================================================
    // QUẢN LÝ NGƯỜI DÙNG (CHỈ XEM VÀ KHÓA)
    // =========================================================

    // 1. Hiển thị danh sách người dùng
    public function users()
    {
        $userModel = new User();
        $users = $userModel->getAllUsers();
        include_once 'MVC/Views/admin_users.php';
    }

    // 2. Xử lý Khóa/Mở khóa tài khoản
    public function toggleUserStatus()
    {
        if (isset($_GET['id']) && isset($_GET['status'])) {
            $id = (int) $_GET['id'];
            $status = (int) $_GET['status'];

            $userModel = new User();
            $userModel->updateStatus($id, $status);

            $_SESSION['info'] = "Cập nhật trạng thái người dùng thành công!";
            header("Location: index.php?ctrl=admin&act=users");
            exit;
        }
    }

    // 3. Xem chi tiết thông tin (Chỉ xem)
    public function viewUser()
    {
        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            $userModel = new User();
            // QUAN TRỌNG: Gán kết quả vào biến $user để khớp với file admin_edit_user.php
            $user = $userModel->getUserById($id);

            if ($user) {
                include_once './MVC/Views/admin_edit_user.php';
            } else {
                $_SESSION['error'] = "Người dùng không tồn tại!";
                header("Location: index.php?ctrl=admin&act=users");
                exit;
            }
        }
    }

}
?>