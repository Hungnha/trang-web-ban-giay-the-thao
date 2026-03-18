<?php
include_once './MVC/Models/Database.php';

class AdminModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // 1. Đếm tổng số sản phẩm
    public function countProducts()
    {
        $sql = "SELECT COUNT(*) as total FROM sanpham";
        return $this->db->queryOne($sql)['total'] ?? 0;
    }

    // 2. Đếm tổng số khách hàng
    public function countUsers()
    {
        // Chỉ đếm user thường, không đếm admin
        $sql = "SELECT COUNT(*) as total FROM nguoidung WHERE vaitro != 'quan_tri'";
        return $this->db->queryOne($sql)['total'] ?? 0;
    }

    // 3. Đếm tổng đơn hàng
    public function countOrders()
    {
        $sql = "SELECT COUNT(*) as total FROM donhang";
        return $this->db->queryOne($sql)['total'] ?? 0;
    }

    // 4. Tính tổng doanh thu (Chỉ tính các đơn đã hoàn thành)
    public function getTotalRevenue()
    {
        $sql = "SELECT SUM(tong_tien) as total FROM donhang WHERE trang_thai = 'hoan_thanh'";
        $result = $this->db->queryOne($sql);
        return $result['total'] ?? 0;
    }


    // 6. Dữ liệu biểu đồ tròn: Thống kê theo Trạng thái đơn hàng
    // (Dễ thực hiện hơn doanh thu theo danh mục vì không cần JOIN nhiều bảng phức tạp)
    public function getOrderStatusStats()
    {
        $sql = "SELECT trang_thai, COUNT(*) as so_luong FROM donhang GROUP BY trang_thai";
        return $this->db->query($sql);
    }

    // 7. Lấy danh sách đơn hàng mới nhất (5 đơn)
    public function getRecentOrders()
    {
        $sql = "SELECT * FROM donhang ORDER BY ma_donhang DESC LIMIT 5";
        return $this->db->query($sql);
    }
    public function getOrdersLast7Days()
    {
        // Lấy số lượng đơn hàng theo ngày (chỉ tính 7 ngày gần nhất)
        $sql = "SELECT DATE(ngay_dat) as ngay, COUNT(*) as so_luong 
            FROM donhang 
            WHERE ngay_dat >= DATE(NOW()) - INTERVAL 7 DAY 
            GROUP BY DATE(ngay_dat) 
            ORDER BY ngay ASC";
        return $this->db->query($sql);
    }
}
?>