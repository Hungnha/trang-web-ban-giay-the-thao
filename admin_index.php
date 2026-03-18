<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
$ctrl = $_GET['ctrl'] ?? 'page';
$act = $_GET['act'] ?? 'home'; 
$logicActions = ['postLogin', 'postRegister', 'add', 'update', 'remove', 'logout'];

$isAdmin = (strtolower($ctrl) === 'admin');



if (isset($_GET['ctrl']) && isset($_GET['act'])) {
    $ctrlName = ucfirst($_GET['ctrl']) . "Controller";
    $actName = $_GET['act'];

    $path =  "./MVC/Controllers/" . $ctrlName . ".php";

    if (file_exists($path)) {
        include_once $path;
        
        if (class_exists($ctrlName)) {
            $controller = new $ctrlName();

            if (method_exists($controller, $actName)) {
                $controller->$actName();
            } else {
                echo "<div class='container py-5'>Action '$actName' không tồn tại!</div>";
            }
        } else {
            echo "<div class='container py-5'>Class '$ctrlName' không tìm thấy!</div>";
        }
    } else {
        echo "<div class='container py-5'>Controller '$ctrlName' không tồn tại!</div>";
    }
} else {
    // --- TRANG CHỦ MẶC ĐỊNH ---
    // Nếu không có ctrl/act, mặc định vào trang chủ bán hàng (PageController)
    // Bạn đang để AdminController ở đây là KHÔNG HỢP LÝ cho trang web bán hàng.
    // Tôi đã sửa lại về PageController.

    $path = ROOT_PATH . "/MVC/Controllers/PageController.php";
    if (file_exists($path)) {
        include_once $path;
        $pageCtrl = new PageController();
        $pageCtrl->home();
    } else {
        echo "Không tìm thấy PageController mặc định.";
    }
}

// --- 3. LOAD FOOTER (Tương tự Header) ---
if (!in_array($act, $logicActions) && !$isAdmin) {
    include_once ROOT_PATH . '/MVC/Views/layout_footer.php';
}

ob_end_flush();
?>