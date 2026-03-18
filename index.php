<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');

$ctrl = $_GET['ctrl'] ?? 'page'; 
$act = $_GET['act'] ?? 'home';


$logicActions = ['postLogin', 'postRegister', 'add', 'update', 'remove', 'logout', 'storeProduct', 'updateProduct', 'addCoupon', 'deleteCoupon'];

$isAdmin = (strtolower($ctrl) === 'admin');

if (!$isAdmin && !in_array($act, $logicActions)) {
    include_once './MVC/Views/layout_header.php';
}

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
        }
    } else {
        echo "<div class='container py-5'>Controller '$ctrlName' không tồn tại!</div>";
    }
} else {
    include_once "./MVC/Controllers/PageController.php";
    $pageCtrl = new PageController();
    $pageCtrl->home();
}

if (!$isAdmin && !in_array($act, $logicActions)) {
    include_once './MVC/Views/layout_footer.php';
}

ob_end_flush();
?>