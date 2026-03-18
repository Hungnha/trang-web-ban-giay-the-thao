<?php
include_once __DIR__ . '/Database.php';

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // 1. Đăng nhập (Kiểm tra cả email, mật khẩu và trạng thái tài khoản)
    public function login($email, $password)
    {
        $sql = "SELECT * FROM nguoidung WHERE email = ? AND matkhau = ?";
        return $this->db->queryOne($sql, $email, md5($password));
    }

    // 2. Đăng ký tài khoản mới
    public function register($ho_ten, $email, $password, $dien_thoai, $dia_chi = '')
    {
        $sql = "INSERT INTO nguoidung (ho_ten, email, matkhau, dien_thoai, dia_chi, vaitro, trang_thai) VALUES (?, ?, ?, ?, ?, 'nguoi_dung', 1)";
        return $this->db->insert($sql, $ho_ten, $email, md5($password), $dien_thoai, $dia_chi);
    }

    // 3. Kiểm tra Email tồn tại
    public function checkEmail($email)
    {
        $sql = "SELECT ma_nguoidung FROM nguoidung WHERE email = ?";
        $result = $this->db->queryOne($sql, $email) ?? null;
        return $result ? true : false;
    }

    // 4. Người dùng tự cập nhật thông tin cá nhân
    public function updateProfile($id, $ho_ten, $dien_thoai, $dia_chi)
    {
        $sql = "UPDATE nguoidung SET ho_ten = ?, dien_thoai = ?, dia_chi = ? WHERE ma_nguoidung = ?";
        return $this->db->update($sql, $ho_ten, $dien_thoai, $dia_chi, $id);
    }

    // --- PHẦN YÊU THÍCH ---
    public function checkFavorite($userId, $productId)
    {
        $sql = "SELECT * FROM yeuthich WHERE ma_nguoidung = ? AND ma_sanpham = ?";
        return $this->db->queryOne($sql, $userId, $productId);
    }

    public function toggleFavorite($userId, $productId)
    {
        if ($this->checkFavorite($userId, $productId)) {
            $sql = "DELETE FROM yeuthich WHERE ma_nguoidung = ? AND ma_sanpham = ?";
            $this->db->delete($sql, $userId, $productId);
        } else {
            $sql = "INSERT INTO yeuthich (ma_nguoidung, ma_sanpham) VALUES (?, ?)";
            $this->db->insert($sql, $userId, $productId);
        }
    }

    public function getWishlist($userId)
    {
        $sql = "SELECT yt.*, sp.ten_sanpham, sp.gia, sp.giam_gia, sp.hinh_anh_chinh 
                FROM yeuthich yt
                JOIN sanpham sp ON yt.ma_sanpham = sp.ma_sanpham
                WHERE yt.ma_nguoidung = ? ORDER BY yt.ma_yeuthich DESC";
        return $this->db->query($sql, $userId);
    }

    // --- PHẦN QUÊN MẬT KHẨU ---
    public function saveResetToken($email, $token)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $expiry = date("Y-m-d H:i:s", strtotime('+15 minutes'));
        $sql = "UPDATE nguoidung SET reset_token = ?, reset_expiry = ? WHERE email = ?";
        return $this->db->update($sql, $token, $expiry, $email);
    }

    public function checkToken($email, $token)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $now = date("Y-m-d H:i:s");
        $sql = "SELECT ma_nguoidung FROM nguoidung WHERE email = ? AND reset_token = ? AND reset_expiry > ?";
        return $this->db->queryOne($sql, $email, $token, $now);
    }

    public function updatePassword($email, $newPass)
    {
        $hashed_pass = md5($newPass);
        $sql = "UPDATE nguoidung SET matkhau = ?, reset_token = NULL, reset_expiry = NULL WHERE email = ?";
        return $this->db->update($sql, $hashed_pass, $email);
    }

    // --- PHẦN ADMIN QUẢN LÝ (CHỈ XEM VÀ KHÓA) --- 

    // Lấy danh sách tất cả người dùng
    public function getAllUsers() {
        $sql = "SELECT * FROM nguoidung ORDER BY ma_nguoidung DESC";
        return $this->db->query($sql);
    }
    
    // Lấy chi tiết thông tin 1 người dùng
    public function getUserById($id) {
        $sql = "SELECT * FROM nguoidung WHERE ma_nguoidung = ?";
        return $this->db->queryOne($sql, $id);
    }
    
    // Admin cập nhật trạng thái: Khóa (0) hoặc Mở khóa (1)
    public function updateStatus($userId, $status) {
        $sql = "UPDATE nguoidung SET trang_thai = ? WHERE ma_nguoidung = ?";
        return $this->db->update($sql, $status, $userId);
    }
}
?>