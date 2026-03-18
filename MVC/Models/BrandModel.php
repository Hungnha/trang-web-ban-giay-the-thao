<?php
require_once __DIR__ . '/Database.php';

class BrandModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // 1. Lấy tất cả thương hiệu kèm số lượng sản phẩm (QUAN TRỌNG)
    public function getAllBrandsWithCount()
    {
        $sql = "SELECT th.*, COUNT(sp.ma_sanpham) as so_luong_sp 
                FROM thuonghieu th 
                LEFT JOIN sanpham sp ON th.ma_thuonghieu = sp.ma_thuonghieu 
                GROUP BY th.ma_thuonghieu 
                ORDER BY th.ma_thuonghieu DESC";
        return $this->db->query($sql);
    }

    // Lấy tất cả thương hiệu (Hàm cũ - giữ nguyên để dùng cho trang chủ)
    public function getAllBrands()
    {
        $sql = "SELECT * FROM thuonghieu";
        return $this->db->query($sql);
    }

    // 2. Lấy 1 thương hiệu theo ID
    public function getBrandById($id)
    {
        $sql = "SELECT * FROM thuonghieu WHERE ma_thuonghieu = ?";
        return $this->db->queryOne($sql, $id);
    }

    // 3. Thêm thương hiệu mới
    public function insertBrand($name, $image, $desc)
    {
        $sql = "INSERT INTO thuonghieu (ten_thuonghieu, hinh_anh, mo_ta) VALUES (?, ?, ?)";
        return $this->db->insert($sql, $name, $image, $desc);
    }

    // 4. Cập nhật thương hiệu
    public function updateBrand($id, $name, $image, $desc)
    {
        if ($image != "") {
            $sql = "UPDATE thuonghieu SET ten_thuonghieu=?, hinh_anh=?, mo_ta=? WHERE ma_thuonghieu=?";
            return $this->db->update($sql, $name, $image, $desc, $id);
        } else {
            $sql = "UPDATE thuonghieu SET ten_thuonghieu=?, mo_ta=? WHERE ma_thuonghieu=?";
            return $this->db->update($sql, $name, $desc, $id);
        }
    }

    // 5. Kiểm tra có sản phẩm nào thuộc thương hiệu này không
    public function countProductsInBrand($id)
    {
        $sql = "SELECT COUNT(*) as total FROM sanpham WHERE ma_thuonghieu = ?";
        $result = $this->db->queryOne($sql, $id);
        return $result['total'] ?? 0;
    }

    // 6. Xóa thương hiệu
    public function deleteBrand($id)
    {
        $sql = "DELETE FROM thuonghieu WHERE ma_thuonghieu = ?";
        return $this->db->delete($sql, $id);
    }
}
?>