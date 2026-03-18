<?php
include_once __DIR__ . '/../Models/ProductModel.php';
include_once __DIR__ . '/../Models/CommentModel.php';
include_once __DIR__ . '/../Models/User.php';

class ProductController
{
    private $productModel;
    private $commentModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->commentModel = new CommentModel();
    }

    // 1. TRANG DANH SÁCH SẢN PHẨM
    public function list()
    {
        $keyword = $_GET['search'] ?? '';
        $brandIds = $_GET['brand'] ?? [];
        $priceRange = $_GET['price'] ?? '';
        $sort = $_GET['sort'] ?? 'newest';

        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit = 12;
        $offset = ($page - 1) * $limit;

        $products = $this->productModel->getProducts($keyword, $brandIds, $priceRange, $sort, $limit, $offset);
        $totalProducts = $this->productModel->countTotalProducts($keyword, $brandIds, $priceRange);
        $totalPages = ceil($totalProducts / $limit);
        $brands = $this->productModel->getAllBrands();

        include_once __DIR__ . '/../Views/product_list.php';
    }

    // 2. TRANG CHI TIẾT SẢN PHẨM
    public function detail()
    {
        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];

            $product = $this->productModel->getProductById($id);

            if ($product) {
                $relatedProducts = $this->productModel->getRelatedProducts($product['ma_thuonghieu'], $id);
                $gallery = $this->productModel->getProductGallery($id);

                $isFavorite = false;
                if (isset($_SESSION['user'])) {
                    $userModel = new User();
                    if ($userModel->checkFavorite($_SESSION['user']['ma_nguoidung'], $id)) {
                        $isFavorite = true;
                    }
                }

                // Lấy danh sách Bình luận
                $comments = $this->commentModel->getCommentsByProduct($id);

                // *** QUAN TRỌNG: Mở khóa review cho tất cả user đã đăng nhập ***
                $canReview = isset($_SESSION['user']);

                include_once __DIR__ . '/../Views/product_detail.php';
            } else {
                echo "<div class='container py-5 text-center'><h3>Sản phẩm không tồn tại!</h3></div>";
            }
        } else {
            header("Location: index.php?ctrl=product&act=list");
        }
    }

    // 3. XỬ LÝ GỬI ĐÁNH GIÁ (Bỏ kiểm tra mua hàng)
    public function submitReview()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user'])) {
            $userId = $_SESSION['user']['ma_nguoidung'];

            $productId = $_POST['product_id'];
            $rating = $_POST['rating'] ?? 5;
            $content = trim($_POST['content']);

            // Lưu trực tiếp đánh giá vào DB
            $this->commentModel->addComment($userId, $productId, $rating, $content);
            $_SESSION['success'] = "Cảm ơn bạn đã đánh giá sản phẩm!";

            // Quay lại trang chi tiết sản phẩm
            header("Location: index.php?ctrl=product&act=detail&id=" . $productId);
            exit;
        } else {
            $_SESSION['error'] = "Vui lòng đăng nhập để đánh giá!";
            header("Location: index.php?ctrl=user&act=login");
            exit;
        }
    }

    // Tìm kiếm
    public function search()
    {
        $keyword = $_GET['keyword'] ?? '';
        $products = [];
        if (!empty($keyword)) {
            $products = $this->productModel->getProducts($keyword, [], '', 'newest', 20, 0);
        }
        include_once __DIR__ . '/../Views/page_search.php';
    }
}
?>