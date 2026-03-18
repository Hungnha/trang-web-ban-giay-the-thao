<?php
include_once __DIR__ . '/../Models/CartModel.php';
include_once __DIR__ . '/../Models/CouponModel.php';
include_once __DIR__ . '/../Models/User.php'; // Cần thêm User Model để check khóa

class CartController
{
    private $cartModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
    }

    // 1. THÊM SẢN PHẨM VÀO GIỎ
    public function add()
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Vui lòng đăng nhập để mua hàng!";
            header("Location: ?ctrl=user&act=login");
            exit;
        }

        // --- LOGIC CHẶN TÀI KHOẢN KHÓA ---
        $userModel = new User();
        $userData = $userModel->getUserById($_SESSION['user']['ma_nguoidung']);
        
        if ($userData['trang_thai'] == 0) {
            $_SESSION['error'] = "Tài khoản của bạn đã bị khóa. Không thể thực hiện chức năng này!";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }
        // --- HẾT LOGIC CHẶN ---

        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            $quantity = isset($_GET['quantity']) ? (int) $_GET['quantity'] : 1;
            $size = isset($_GET['size']) ? (int) $_GET['size'] : 40;

            $this->cartModel->addItem($id, $size, $quantity);

            if (isset($_GET['buy_now']) && $_GET['buy_now'] == 1) {
                $cartKey = $id . '_' . $size;
                header("Location: ?ctrl=order&act=checkout&key=" . $cartKey);
            } else {
                $_SESSION['cart_notify'] = "Đã thêm sản phẩm vào giỏ hàng!";
                header("Location: " . $_SERVER['HTTP_REFERER']);
            }
            exit;
        } else {
            header("Location: index.php");
        }
    }

    public function view()
    {
        $data = $this->cartModel->getCartData();
        include_once __DIR__ . '/../Views/cart.php';
    }

    // 2. ÁP DỤNG MÃ GIẢM GIÁ
    public function applyCoupon()
    {
        if (isset($_POST['code'])) {
            $code = $_POST['code'];
            $totalOrder = $_POST['total_amount'] ?? 0;

            $couponModel = new CouponModel();
            $result = $couponModel->checkCoupon($code, $totalOrder);

            if (is_array($result)) {
                // SỬA LẠI: Lưu đầy đủ cả ID để OrderController dùng được
                $_SESSION['coupon'] = [
                    'id'        => $result['ma_giamgia'], // Rất quan trọng để lưu vào DB
                    'code'      => $result['code'],
                    'loai_giam' => $result['loai_giam'], 
                    'gia_tri'   => $result['so_tien_giam']
                ];
                $_SESSION['success'] = "Áp dụng mã thành công!";
            } else {
                $_SESSION['error'] = $result; 
                unset($_SESSION['coupon']);
            }
        }
        header("Location: index.php?ctrl=order&act=checkout");
        exit;
    }

    public function removeCoupon()
    {
        unset($_SESSION['coupon']);
        $_SESSION['info'] = "Đã gỡ bỏ mã giảm giá.";
        header("Location: index.php?ctrl=order&act=checkout");
        exit;
    }

    // Các hàm Update/Remove bên dưới của bạn giữ nguyên
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $key = $_POST['cart_key'] ?? '';
            $qty = (int) ($_POST['quantity'] ?? 1);
            if ($qty < 1) $qty = 1;
            $data = $this->cartModel->updateItemQuantity($key, $qty);
            $itemTotal = $data['cartItems'][$key]['itemTotalFormatted'] ?? 0;
            echo json_encode([
                'success' => true,
                'subtotalFormatted' => $data['subtotalFormatted'],
                'itemTotalFormatted' => $itemTotal,
                'totalItems' => $data['totalItems']
            ]);
            exit;
        }
    }

    public function remove()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $key = $_POST['cart_key'] ?? '';
            $data = $this->cartModel->removeItem($key);
            echo json_encode(['success' => true, 'subtotalFormatted' => $data['subtotalFormatted'], 'totalItems' => $data['totalItems']]);
            exit;
        }
    }
}