<?php
include_once './MVC/Models/Database.php';

class CouponModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Lấy tất cả mã (Dùng cho Admin)
    public function getAllCoupons()
    {
        $sql = "SELECT * FROM magiamgia ORDER BY ma_giamgia DESC";
        return $this->db->query($sql);
    }

    // Thêm mã mới (Cập nhật đầy đủ trường)
    public function insertCoupon($code, $loai_giam, $amount, $min_order, $qty, $start, $end)
    {
        $sql = "INSERT INTO magiamgia (code, loai_giam, so_tien_giam, don_toithieu, so_luong, ngay_bat_dau, ngay_het_han, trang_thai) 
                VALUES (?, ?, ?, ?, ?, ?, ?, 1)";
        return $this->db->insert($sql, strtoupper($code), $loai_giam, $amount, $min_order, $qty, $start, $end);
    }

    // Xóa mã
    public function deleteCoupon($id)
    {
        $sql = "DELETE FROM magiamgia WHERE ma_giamgia = ?";
        return $this->db->delete($sql, $id);
    }

    // Kiểm tra mã giảm giá (Logic chặt chẽ hơn)
    public function checkCoupon($code, $totalOrder)
    {
        $today = date('Y-m-d');

        $sql = "SELECT * FROM magiamgia 
                WHERE code = ? 
                AND so_luong > 0 
                AND trang_thai = 1";

        $coupon = $this->db->queryOne($sql, strtoupper($code));

        if (!$coupon)
            return "Mã giảm giá không tồn tại!";

        // Kiểm tra ngày
        if ($today < $coupon['ngay_bat_dau'])
            return "Mã chưa đến thời gian hiệu lực!";
        if ($today > $coupon['ngay_het_han'])
            return "Mã đã hết hạn sử dụng!";

        // Kiểm tra đơn tối thiểu
        if ($totalOrder < $coupon['don_toithieu']) {
            return "Đơn hàng phải từ " . number_format($coupon['don_toithieu']) . "đ mới được dùng mã này!";
        }

        return $coupon; // Trả về mảng dữ liệu nếu hợp lệ
    }

    // Giảm số lượng mã
    public function decreaseQuantity($code)
    {
        $sql = "UPDATE magiamgia SET so_luong = so_luong - 1 WHERE code = ?";
        return $this->db->update($sql, $code);
    }
}
?>