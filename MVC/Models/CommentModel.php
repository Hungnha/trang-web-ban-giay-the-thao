<?php
include_once 'database.php';

class CommentModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // 1. Thêm đánh giá
    public function addComment($userId, $productId, $rating, $content)
    {
        $sql = "INSERT INTO danhgia (ma_nguoidung, ma_sanpham, so_sao, noi_dung, ngay_danhgia) VALUES (?, ?, ?, ?, NOW())";
        return $this->db->insert($sql, $userId, $productId, $rating, $content);
    }

    // 2. Lấy danh sách đánh giá của 1 sản phẩm
    public function getCommentsByProduct($productId)
    {
        $sql = "SELECT dg.*, nd.ho_ten 
                FROM danhgia dg
                JOIN nguoidung nd ON dg.ma_nguoidung = nd.ma_nguoidung
                WHERE dg.ma_sanpham = ? 
                ORDER BY dg.ma_danhgia DESC";
        return $this->db->query($sql, $productId);
    }

    // 3. Kiểm tra xem user đã mua hàng và đơn đã HOÀN THÀNH chưa
    public function hasPurchased($userId, $productId)
    {
        // Lưu ý: Tên bảng là 'chitietdonhang' (theo fix mới nhất)
        $sql = "SELECT dh.ma_donhang 
                FROM donhang dh
                JOIN chitietdonhang ct ON dh.ma_donhang = ct.ma_donhang
                WHERE dh.ma_nguoidung = ? 
                AND ct.ma_sanpham = ? 
                AND dh.trang_thai = 'hoan_thanh'";

        $result = $this->db->queryOne($sql, $userId, $productId);
        return $result ? true : false;
    }
}
?>