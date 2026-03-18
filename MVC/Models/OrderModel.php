<?php
include_once 'database.php';

class OrderModel
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    // 1. Tạo đơn hàng (Đã bỏ cột so_tien_giam theo yêu cầu)
    public function createOrder($userId, $name, $phone, $address, $note, $total, $payment_method, $ma_giamgia = null)
    {
        $sql = "INSERT INTO donhang (ma_nguoidung, ho_ten_nguoi_nhan, sdt_nguoi_nhan, dia_chi_giao, ghi_chu, tong_tien, phuong_thuc_tt, ngay_dat, trang_thai, ma_giamgia) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), 'cho_xac_nhan', ?)";
        
        return $this->db->insert($sql, $userId, $name, $phone, $address, $note, $total, $payment_method, $ma_giamgia);
    }

    // 2. Lưu chi tiết đơn hàng
    public function createOrderDetail($orderId, $productId, $price, $quantity, $size)
    {
        $sql = "INSERT INTO donhang_chitiet (ma_donhang, ma_sanpham, gia, so_luong, size) 
                VALUES (?, ?, ?, ?, ?)";
        return $this->db->insert($sql, $orderId, $productId, $price, $quantity, $size);
    }

    // 3. Lấy chi tiết đơn hàng (JOIN để lấy thông tin sản phẩm)
    public function getOrderDetails($orderId)
    {
        $sql = "SELECT ct.*, sp.ten_sanpham, sp.hinh_anh_chinh 
                FROM donhang_chitiet ct
                JOIN sanpham sp ON ct.ma_sanpham = sp.ma_sanpham
                WHERE ct.ma_donhang = ?";
        return $this->db->query($sql, $orderId);
    }

    // 4. Lấy tất cả đơn hàng (Dùng cho Admin)
    public function getAllOrders()
    {
        $sql = "SELECT * FROM donhang ORDER BY ma_donhang DESC";
        return $this->db->query($sql);
    }

    // 5. Lấy đơn hàng theo User (Dùng cho Lịch sử đơn hàng - ĐÃ FIX LỖI)
    public function getOrdersByUser($userId)
    {
        $sql = "SELECT * FROM donhang WHERE ma_nguoidung = ? ORDER BY ma_donhang DESC";
        return $this->db->query($sql, $userId);
    }

    // 6. Lấy 1 đơn hàng theo ID
    public function getOrderById($id)
    {
        $sql = "SELECT * FROM donhang WHERE ma_donhang = ?";
        return $this->db->queryOne($sql, $id);
    }

    // 7. Cập nhật trạng thái đơn hàng
    public function updateStatus($id, $status)
    {
        $sql = "UPDATE donhang SET trang_thai = ? WHERE ma_donhang = ?";
        return $this->db->update($sql, $status, $id);
    }
}
?>