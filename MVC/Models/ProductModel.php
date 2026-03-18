<?php
include_once __DIR__ . '/Database.php';

class ProductModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // --- CÁC HÀM CHO USER ---
    function getAllBrands()
    {
        $sql = "SELECT * FROM thuonghieu";
        return $this->db->query($sql);
    }

    function BestSelling($limit = 8)
    {
        $sql = "SELECT * FROM sanpham ORDER BY giam_gia DESC LIMIT $limit";
        return $this->db->query($sql);
    }

    function NewProducts($limit = 8)
    {
        $sql = "SELECT * FROM sanpham ORDER BY ma_sanpham DESC LIMIT $limit";
        return $this->db->query($sql);
    }

    function RecommendedProducts($limit = 8)
    {
        $sql = "SELECT * FROM sanpham ORDER BY ma_sanpham DESC LIMIT $limit";
        return $this->db->query($sql);
    }

    function getSaleProducts($limit = 8)
    {
        $sql = "SELECT * FROM sanpham WHERE giam_gia > 0 ORDER BY giam_gia DESC LIMIT $limit";
        return $this->db->query($sql);
    }

    function getProductGallery($id)
    {
        $sql = "SELECT * FROM hinh_anh_san_pham WHERE ma_sanpham = $id";
        return $this->db->query($sql);
    }

    function getProductById($id)
    {
        $sql = "SELECT s.*, t.ten_thuonghieu 
                FROM sanpham s 
                JOIN thuonghieu t ON s.ma_thuonghieu = t.ma_thuonghieu 
                WHERE s.ma_sanpham = $id";
        return $this->db->queryOne($sql);
    }

    function getProducts($keyword, $brandIds, $priceRange, $sort, $limit, $offset)
    {
        $sql = "SELECT * FROM sanpham WHERE 1=1";
        if (!empty($keyword))
            $sql .= " AND ten_sanpham LIKE '%$keyword%'";
        if (!empty($brandIds)) {
            $ids = implode(',', $brandIds);
            $sql .= " AND ma_thuonghieu IN ($ids)";
        }
        if ($priceRange) {
            switch ($priceRange) {
                case 'duoi-2tr':
                    $sql .= " AND gia < 2000000";
                    break;
                case '2tr-4tr':
                    $sql .= " AND gia BETWEEN 2000000 AND 4000000";
                    break;
                case 'tren-4tr':
                    $sql .= " AND gia > 4000000";
                    break;
            }
        }
        switch ($sort) {
            case 'price_asc':
                $sql .= " ORDER BY gia ASC";
                break;
            case 'price_desc':
                $sql .= " ORDER BY gia DESC";
                break;
            case 'name_asc':
                $sql .= " ORDER BY ten_sanpham ASC";
                break;
            default:
                $sql .= " ORDER BY ma_sanpham DESC";
                break;
        }
        $sql .= " LIMIT $limit OFFSET $offset";
        return $this->db->query($sql);
    }

    function countTotalProducts($keyword, $brandIds, $priceRange)
    {
        $sql = "SELECT COUNT(*) as total FROM sanpham WHERE 1=1";
        if (!empty($keyword))
            $sql .= " AND ten_sanpham LIKE '%$keyword%'";
        if (!empty($brandIds)) {
            $ids = implode(',', $brandIds);
            $sql .= " AND ma_thuonghieu IN ($ids)";
        }
        if ($priceRange) {
            switch ($priceRange) {
                case 'duoi-2tr':
                    $sql .= " AND gia < 2000000";
                    break;
                case '2tr-4tr':
                    $sql .= " AND gia BETWEEN 2000000 AND 4000000";
                    break;
                case 'tren-4tr':
                    $sql .= " AND gia > 4000000";
                    break;
            }
        }
        $result = $this->db->queryOne($sql);
        return $result['total'];
    }

    function getRelatedProducts($brandId, $excludeId)
    {
        $sql = "SELECT * FROM sanpham WHERE ma_thuonghieu = $brandId AND ma_sanpham != $excludeId LIMIT 4";
        return $this->db->query($sql);
    }

    // --- CÁC HÀM CHO ADMIN ---
    // Tìm đến hàm getAllProducts() và thay thế bằng đoạn mã này:
    function getAllProducts()
    {
        // Sử dụng LEFT JOIN để lấy tên thương hiệu, ngay cả khi sản phẩm chưa được gán thương hiệu
        $sql = "SELECT s.*, t.ten_thuonghieu 
            FROM sanpham s 
            LEFT JOIN thuonghieu t ON s.ma_thuonghieu = t.ma_thuonghieu 
            ORDER BY s.ma_sanpham DESC";
        return $this->db->query($sql);
    }

    function insertProduct($name, $price, $image, $description, $cate_id)
    {
        $sql = "INSERT INTO sanpham (ten_sanpham, gia, hinh_anh, mo_ta, ma_thuonghieu) VALUES (?, ?, ?, ?, ?)";
        return $this->db->insert($sql, $name, $price, $image, $description, $cate_id);
    }

    function updateProduct($id, $name, $price, $image, $description, $cate_id)
    {
        if ($image != "") {
            $sql = "UPDATE sanpham SET ten_sanpham=?, gia=?, hinh_anh=?, mo_ta=?, ma_thuonghieu=? WHERE ma_sanpham=?";
            return $this->db->update($sql, $name, $price, $image, $description, $cate_id, $id);
        } else {
            $sql = "UPDATE sanpham SET ten_sanpham=?, gia=?, mo_ta=?, ma_thuonghieu=? WHERE ma_sanpham=?";
            return $this->db->update($sql, $name, $price, $description, $cate_id, $id);
        }
    }

    function deleteProduct($id)
    {
        $sql = "DELETE FROM sanpham WHERE ma_sanpham = ?";
        return $this->db->delete($sql, $id);
    }
}
?>