<?php
include_once __DIR__ . '/ProductModel.php';

class CartModel
{
    private $productModel;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
        $this->productModel = new ProductModel();
    }

    public function getCartData()
    {
        $cart = $_SESSION['cart'] ?? [];
        $subtotal = 0;
        $totalItems = 0;

        foreach ($cart as $key => $item) {
            $itemTotal = $item['quantity'] * $item['price'];
            $subtotal += $itemTotal;
            $totalItems += $item['quantity'];

            // Định dạng tiền tệ
            $cart[$key]['itemTotalFormatted'] = number_format($itemTotal, 0, ',', '.') . ' ₫';
            $cart[$key]['priceFormatted'] = number_format($item['price'], 0, ',', '.') . ' ₫';
        }

        return [
            'cartItems' => $cart,
            'subtotal' => $subtotal, // Tổng tiền dạng số
            'subtotalFormatted' => number_format($subtotal, 0, ',', '.') . ' ₫',
            'totalItems' => $totalItems
        ];
    }

    public function addItem($productId, $size, $quantity)
    {
        $product = $this->productModel->getProductById($productId);

        if (!$product)
            return false;

        // --- SỬA LỖI GIÁ VÀ ẢNH Ở ĐÂY ---
        // 1. Tính giá thực tế (Giá gốc - Khuyến mãi)
        $gia_goc = isset($product['gia']) ? (float) $product['gia'] : 0;
        $giam_gia = isset($product['giam_gia']) ? (float) $product['giam_gia'] : 0;
        $price = $gia_goc * (1 - ($giam_gia / 100));

        // 2. Lấy đúng tên cột ảnh (ưu tiên hinh_anh_chinh)
        $image = !empty($product['hinh_anh_chinh']) ? $product['hinh_anh_chinh'] : ($product['hinh_anh'] ?? 'no-image.png');

        $cartKey = "{$productId}_{$size}";

        if (isset($_SESSION['cart'][$cartKey])) {
            $_SESSION['cart'][$cartKey]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$cartKey] = [
                'key' => $cartKey,
                'id' => $productId,
                'name' => $product['ten_sanpham'],
                'image_url' => $image, // Đã sửa
                'size' => $size,
                'price' => $price, // Đã sửa
                'quantity' => $quantity,
            ];
        }
        return $this->getCartData();
    }

    public function updateItemQuantity($cartKey, $newQuantity)
    {
        if (isset($_SESSION['cart'][$cartKey])) {
            $_SESSION['cart'][$cartKey]['quantity'] = $newQuantity;
        }
        return $this->getCartData();
    }

    public function removeItem($cartKey)
    {
        if (isset($_SESSION['cart'][$cartKey])) {
            unset($_SESSION['cart'][$cartKey]);
        }
        return $this->getCartData();
    }
}
?>