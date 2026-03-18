<?php
include_once __DIR__ . '/../Models/OrderModel.php';
include_once __DIR__ . '/../Models/Payment.php';
include_once __DIR__ . '/../Models/CartModel.php';
include_once __DIR__ . '/../Models/CouponModel.php';
include_once __DIR__ . '/../Models/User.php'; // Thêm User model để check khóa

class OrderController
{
    private $orderModel;
    private $paymentModel;
    private $cartModel;
    private $couponModel;
    private $userModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->paymentModel = new Payment();
        $this->cartModel = new CartModel();
        $this->couponModel = new CouponModel();
        $this->userModel = new User();
    }

    // 1. HIỂN THỊ TRANG THANH TOÁN
    public function checkout()
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Vui lòng đăng nhập để thanh toán!";
            header("Location: index.php?ctrl=user&act=login");
            exit;
        }

        // --- KIỂM TRA TRẠNG THÁI TÀI KHOẢN (REALTIME) ---
        $u = $this->userModel->getUserById($_SESSION['user']['ma_nguoidung']);
        if ($u && $u['trang_thai'] == 0) {
            $_SESSION['error'] = "Tài khoản của bạn đã bị khóa. Không thể thực hiện thanh toán!";
            header("Location: index.php?ctrl=cart&act=view");
            exit;
        }

        $checkout_items = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['selected_items'])) {
            foreach ($_POST['selected_items'] as $key) {
                if (isset($_SESSION['cart'][$key]))
                    $checkout_items[$key] = $_SESSION['cart'][$key];
            }
        } else if (isset($_GET['key']) && isset($_SESSION['cart'][$_GET['key']])) {
            $checkout_items[$_GET['key']] = $_SESSION['cart'][$_GET['key']];
        } else {
            $checkout_items = $_SESSION['checkout_items'] ?? [];
        }

        if (empty($checkout_items)) {
            $_SESSION['error'] = "Vui lòng chọn sản phẩm trong giỏ hàng!";
            header("Location: index.php?ctrl=cart&act=view");
            exit;
        }
        $_SESSION['checkout_items'] = $checkout_items;

        // TÍNH TOÁN TIỀN
        $total = 0;
        foreach ($checkout_items as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $discount = 0;
        if (isset($_SESSION['coupon'])) {
            $coupon = $_SESSION['coupon'];
            $check = $this->couponModel->checkCoupon($coupon['code'], $total);

            if (is_array($check)) {
                if ($coupon['loai_giam'] == 0) {
                    $discount = ($total * $coupon['gia_tri']) / 100;
                } else {
                    $discount = $coupon['gia_tri'];
                }
            } else {
                unset($_SESSION['coupon']);
                $_SESSION['error'] = "Mã giảm giá đã bị hủy: " . $check;
            }
        }

        if ($discount > $total) $discount = $total;
        $finalTotal = $total - $discount;

        include_once __DIR__ . '/../Views/checkout.php';
    }

    // 2. XỬ LÝ LƯU ĐƠN HÀNG
    public function processCheckout()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user'])) {
            
            // --- KIỂM TRA TRẠNG THÁI TÀI KHOẢN LẦN CUỐI ---
            $u = $this->userModel->getUserById($_SESSION['user']['ma_nguoidung']);
            if ($u && $u['trang_thai'] == 0) {
                $_SESSION['error'] = "Tài khoản bị khóa, không thể đặt hàng!";
                header("Location: index.php?ctrl=cart&act=view"); exit;
            }

            $userId = $_SESSION['user']['ma_nguoidung'];
            $name = $_POST['hoten'];
            $phone = $_POST['sdt'];
            $address = $_POST['diachi'];
            $note = $_POST['ghichu'] ?? '';
            $payment_method = $_POST['payment_method'];
            $total = $_POST['tong_tien'];
            
            $items = $_SESSION['checkout_items'] ?? [];
            if (empty($items)) {
                header("Location: index.php?ctrl=cart&act=view"); exit;
            }

            // Lấy thông tin mã giảm giá
            $ma_giamgia_id = $_SESSION['coupon']['id'] ?? null;
            $so_tien_giam = 0;
            if (isset($_SESSION['coupon'])) {
                // Tính lại số tiền giảm thực tế để lưu vào DB
                $subtotal = 0;
                foreach ($items as $it) { $subtotal += $it['price'] * $it['quantity']; }
                if ($_SESSION['coupon']['loai_giam'] == 0) {
                    $so_tien_giam = ($subtotal * $_SESSION['coupon']['gia_tri']) / 100;
                } else {
                    $so_tien_giam = $_SESSION['coupon']['gia_tri'];
                }
            }

            // TẠO ĐƠN HÀNG (Cần đảm bảo OrderModel đã cập nhật hàm createOrder nhận ma_giamgia và so_tien_giam)
            $orderId = $this->orderModel->createOrder($userId, $name, $phone, $address, $note, $total, $payment_method, $ma_giamgia_id);

            if ($orderId) {
                // 1. Lưu chi tiết đơn hàng
                foreach ($items as $item) {
                    $this->orderModel->createOrderDetail($orderId, $item['id'], $item['price'], $item['quantity'], $item['size']);
                }

                // 2. Trừ số lượng mã giảm giá
                if (isset($_SESSION['coupon'])) {
                    $this->couponModel->decreaseQuantity($_SESSION['coupon']['code']);
                }

                // 3. Xóa các sản phẩm đã mua khỏi giỏ hàng
                foreach ($items as $key => $value) {
                    if (isset($_SESSION['cart'][$key])) {
                        unset($_SESSION['cart'][$key]);
                    }
                }

                unset($_SESSION['checkout_items']);
                unset($_SESSION['coupon']);

                if ($payment_method == 'vnpay') {
                    $this->paymentModel->create($orderId, $total);
                    exit;
                }
                
                $_SESSION['success'] = "Đặt hàng thành công! Mã đơn: #" . $orderId;
                header("Location: index.php?ctrl=order&act=history");
                exit;
            } else {
                $_SESSION['error'] = "Lỗi: Không thể tạo đơn hàng.";
                header("Location: index.php?ctrl=cart&act=view");
                exit;
            }
        }
    }

    // Các hàm history, detail, cancel, paymentResult, reBuy giữ nguyên theo code của bạn...
    public function paymentResult()
    {
        if ($this->paymentModel->checkSecureHash()) {
            if (isset($_GET['vnp_ResponseCode']) && $_GET['vnp_ResponseCode'] == '00') {
                $this->orderModel->updateStatus($_GET['vnp_TxnRef'], 'da_xac_nhan');
                $_SESSION['success'] = "Thanh toán thành công!";
                header("Location: index.php?ctrl=order&act=history");
            } else {
                $_SESSION['error'] = "Thanh toán thất bại!";
                header("Location: index.php?ctrl=cart&act=view");
            }
        }
    }

    public function history()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?ctrl=user&act=login");
            exit;
        }
        $orders = $this->orderModel->getOrdersByUser($_SESSION['user']['ma_nguoidung']);
        include_once __DIR__ . '/../Views/user_orders.php';
    }

    public function detail()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?ctrl=user&act=login");
            exit;
        }
        if (isset($_GET['id'])) {
            $orderId = $_GET['id'];
            $order = $this->orderModel->getOrderById($orderId);
            $orderDetails = $this->orderModel->getOrderDetails($orderId);
            include_once __DIR__ . '/../Views/user_order_detail.php';
        }
    }

    public function confirmReceived()
    {
        if (isset($_GET['id'])) {
            $this->orderModel->updateStatus($_GET['id'], 'hoan_thanh');
            $_SESSION['success'] = "Đã xác nhận nhận hàng!";
        }
        header("Location: index.php?ctrl=order&act=history");
    }

    public function cancel()
    {
        if (!isset($_SESSION['user'])) { header("Location: index.php"); exit; }
        $id = (int)($_GET['id'] ?? 0);
        $order = $this->orderModel->getOrderById($id);
        if ($order && $order['ma_nguoidung'] == $_SESSION['user']['ma_nguoidung']) {
            if ($order['trang_thai'] == 'cho_xac_nhan') {
                $this->orderModel->updateStatus($id, 'da_huy');
                $_SESSION['success'] = "Đã hủy đơn hàng thành công.";
            } else {
                $_SESSION['error'] = "Không thể hủy đơn hàng ở trạng thái này!";
            }
        }
        header("Location: index.php?ctrl=order&act=history");
    }

    public function reBuy()
    {
        if (!isset($_SESSION['user'])) { header("Location: index.php"); exit; }
        $id = (int)($_GET['id'] ?? 0);
        $orderDetails = $this->orderModel->getOrderDetails($id);
        if ($orderDetails) {
            $itemsForCheckout = [];
            foreach ($orderDetails as $item) {
                $this->cartModel->addItem($item['ma_sanpham'], $item['size'], $item['so_luong']);
                $key = $item['ma_sanpham'] . '_' . $item['size'];
                if (isset($_SESSION['cart'][$key])) {
                    $itemsForCheckout[$key] = $_SESSION['cart'][$key];
                }
            }
            $_SESSION['checkout_items'] = $itemsForCheckout;
            header("Location: index.php?ctrl=order&act=checkout");
        } else {
            header("Location: index.php?ctrl=order&act=history");
        }
        exit;
    }
}