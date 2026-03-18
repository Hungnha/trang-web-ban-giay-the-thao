<?php
include_once __DIR__ . '/../Models/User.php';

class UserController
{
    public function login()
    {
        include_once __DIR__ . '/../Views/user_login.php';
    }

    public function postLogin()
    {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userModel = new User();
            $user = $userModel->login($email, $password);

            if ($user) {
                // --- LOGIC KIỂM TRA TÀI KHOẢN BỊ KHÓA ---
                // Nếu trang_thai = 0 (Bị khóa), thông báo lỗi và không cho đăng nhập
                if (isset($user['trang_thai']) && $user['trang_thai'] == 0) {
                    $_SESSION['error'] = "Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên!";
                    header("Location: index.php?ctrl=user&act=login");
                    exit;
                }
                // --- HẾT LOGIC KIỂM TRA ---

                // 1. Đăng nhập thành công -> Lưu session
                $_SESSION['info'] = "Đăng nhập thành công!";
                $_SESSION['user'] = $user;

                // 2. Kiểm tra quyền (Role) để chuyển hướng
                if ($user['vaitro'] == 'quan_tri') {
                    header("Location: index.php?ctrl=admin&act=dashboard");
                } else {
                    header("Location: index.php");
                }
                exit;

            } else {
                // 3. Đăng nhập thất bại
                $_SESSION['error'] = "Email hoặc mật khẩu không đúng!";
                header("Location: index.php?ctrl=user&act=login");
                exit;
            }
        }
    }

    public function updateProfile()
    {
        if (isset($_SESSION['user']) && isset($_POST['ho_ten'])) {
            $id = $_SESSION['user']['ma_nguoidung'];
            $ho_ten = trim($_POST['ho_ten']);
            $dien_thoai = trim($_POST['dien_thoai']);
            $dia_chi = trim($_POST['dia_chi']);

            $userModel = new User();
            $userModel->updateProfile($id, $ho_ten, $dien_thoai, $dia_chi);

            $_SESSION['user']['ho_ten'] = $ho_ten;
            $_SESSION['user']['dien_thoai'] = $dien_thoai;
            $_SESSION['user']['dia_chi'] = $dia_chi;

            $_SESSION['success'] = "Cập nhật thông tin thành công!";
            header("Location: ?ctrl=user&act=profile");
            exit;
        } else {
            header("Location: index.php");
            exit;
        }
    }

    public function register()
    {
        include_once __DIR__ . '/../Views/user_register.php';
    }

    public function postRegister()
    {
        if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'] ?? '';
            $password = $_POST['password'];

            if (strlen($password) < 6) {
                $_SESSION['error'] = "Mật khẩu phải có ít nhất 6 ký tự!";
                header("Location: index.php?ctrl=user&act=register"); exit;
            }
            $userModel = new User();
            if ($userModel->checkEmail($email)) {
                $_SESSION['error'] = "Email đã tồn tại!";
                header("Location: index.php?ctrl=user&act=register"); exit;
            }

            $result = $userModel->register($name, $email, $password, $phone, $address);

            if ($result) {
                $_SESSION['info'] = "Đăng ký thành công! Vui lòng đăng nhập.";
                header("Location: index.php?ctrl=user&act=login"); exit;
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra!";
                header("Location: index.php?ctrl=user&act=register"); exit;
            }
        }
    }

    public function logout()
    {
        unset($_SESSION['user']);
        unset($_SESSION['cart']);
        $_SESSION['info'] = "Đã đăng xuất.";
        header("Location: index.php");
        exit;
    }

    public function toggleFavorite()
    {
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Vui lòng đăng nhập!";
            header("Location: index.php?ctrl=user&act=login"); exit;
        }
        if (isset($_GET['id'])) {
            $userModel = new User();
            $userModel->toggleFavorite($_SESSION['user']['ma_nguoidung'], $_GET['id']);
            header("Location: " . ($_SERVER['HTTP_REFERER'] ?? "index.php")); exit;
        }
    }

    public function profile()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?ctrl=user&act=login"); exit;
        }
        $user = $_SESSION['user'];
        $currentTab = $_GET['tab'] ?? 'info';
        $userModel = new User();
        $wishlist = $userModel->getWishlist($user['ma_nguoidung']);
        include_once __DIR__ . '/../Views/user_profile.php';
    }

    public function forgot()
    {
        include_once __DIR__ . '/../Models/MailService.php';
        $error = ""; $message = "";
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            $userModel = new User();
            if ($userModel->checkEmail($email)) {
                $pin = rand(100000, 999999);
                if ($userModel->saveResetToken($email, $pin)) {
                    $subject = "Mã xác nhận đổi mật khẩu - Giày Hiện Đại";
                    $content = "<h3>Chào bạn,</h3><p>Mã xác nhận của bạn là: <b style='color:red;'>$pin</b></p>";
                    if (MailService::send($email, $subject, $content)) {
                        $_SESSION['reset_email'] = $email;
                        header("Location: index.php?ctrl=user&act=resetPassword"); exit;
                    } else { $error = "Không thể gửi email!"; }
                }
            } else { $error = "Email không tồn tại!"; }
        }
        include_once './MVC/Views/user_forgot.php';
    }

    public function resetPassword()
    {
        if (!isset($_SESSION['reset_email'])) { header("Location: index.php?ctrl=user&act=forgot"); exit; }
        $email = $_SESSION['reset_email'];
        $error = ""; $success = "";
        if (isset($_POST['btn_xac_nhan'])) {
            $userModel = new User();
            if (!$userModel->checkToken($email, $_POST['pin'])) {
                $error = "Mã PIN không chính xác hoặc hết hạn!";
            } elseif (strlen($_POST['new_password']) < 6) {
                $error = "Mật khẩu phải từ 6 ký tự!";
            } elseif ($_POST['new_password'] !== $_POST['re_password']) {
                $error = "Mật khẩu xác nhận không khớp!";
            } else {
                $userModel->updatePassword($email, $_POST['new_password']);
                unset($_SESSION['reset_email']);
                $success = "Đổi mật khẩu thành công!";
            }
        }
        include_once './MVC/Views/user_resetpassword.php';
    }
}