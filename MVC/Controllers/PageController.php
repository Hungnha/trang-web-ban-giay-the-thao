<?php
include_once __DIR__ . '/../Models/ProductModel.php';
include_once __DIR__ . '/../Models/BrandModel.php';

class PageController {
    function home() {
        $productModel = new ProductModel();
        
        // Lấy dữ liệu tĩnh (Thương hiệu, Tin tức giả lập)
        $topBrands = $productModel->getAllBrands(); 
        $latestPosts = [
            ['title' => 'Xu hướng Sneaker 2025', 'excerpt' => 'Những mẫu giày sẽ làm mưa làm gió...', 'image' => 'slide.png'],
            ['title' => 'Cách bảo quản giày da lộn', 'excerpt' => 'Hướng dẫn vệ sinh giày da lộn...', 'image' => 'slide.png']
        ];

        // --- XỬ LÝ BỘ LỌC SẢN PHẨM ---
        $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all'; // Mặc định là 'all'
        $limit = 8; // Số lượng hiển thị

        switch ($filter) {
            case 'banchay':
                $displayProducts = $productModel->BestSelling($limit);
                break;
            case 'khuyenmai':
                $displayProducts = $productModel->getSaleProducts($limit);
                break;
            case 'moi':
                $displayProducts = $productModel->NewProducts($limit);
                break;
            case 'all':
            default:
                $displayProducts = $productModel->RecommendedProducts($limit);
                break;
        }

        // Gọi View và truyền biến $filter để active nút bấm
        include_once __DIR__ . '/../Views/page_home.php';
    }

    function brands() {
        $brandModel = new BrandModel();
        $brands = $brandModel->getAllBrands(); // Lấy dữ liệu từ DB
        
        include_once __DIR__ . '/../Views/page_brand.php'; // Gọi View
    }
    function contact() {
        include_once __DIR__ . '/../Views/page_contact.php';
    }

    function search() {
        // 1. Khởi tạo Model
        $productModel = new ProductModel();
        $brandModel = new BrandModel();
        
        // 2. Lấy các tham số từ URL
        $keyword = isset($_GET['search']) ? trim($_GET['search']) : '';
        $brandIds = isset($_GET['brand']) ? $_GET['brand'] : [];
        $priceRange = isset($_GET['price']) ? $_GET['price'] : null;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
        
        // --- XỬ LÝ PHÂN TRANG (QUAN TRỌNG) ---
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        
        $limit = 9; // Hiển thị 8 sản phẩm mỗi trang theo yêu cầu
        $offset = ($page - 1) * $limit;
        
        // 3. Lấy dữ liệu cho Sidebar và Danh sách sản phẩm
        $brands = $brandModel->getAllBrands();
        
        // Gọi hàm getProducts với đầy đủ tham số phân trang
        $products = $productModel->getProducts($keyword, $brandIds, $priceRange, $sort, $limit, $offset);
        
        // Tính tổng số trang
        $totalProducts = $productModel->countTotalProducts($keyword, $brandIds, $priceRange);
        $totalPages = ceil($totalProducts / $limit); // Ví dụ: 17 sp / 8 = 2.125 -> làm tròn lên 3 trang

        // 4. Thông báo nếu không có kết quả
        $message = "";
        if (empty($products)) {
            $message = "Không tìm thấy sản phẩm nào phù hợp với từ khóa: '$keyword'";
        }
        
        // 5. Gọi View hiển thị
        include_once __DIR__ . '/../Views/page_search.php';
    }
}
?>