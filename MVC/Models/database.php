<?php
class Database
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "urbanstepp"; // Tên database của bạn
    public $conn;

    function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname;charset=utf8", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // 1. Hàm lấy danh sách (SELECT nhiều dòng)
    function query($sql, ...$args)
    {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($args);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "SQL Error: " . $e->getMessage();
        }
    }

    // 2. Hàm lấy 1 dòng (SELECT 1 dòng)
    function queryOne($sql, ...$args)
    {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($args);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "SQL Error: " . $e->getMessage();
        }
    }

    // 3. Hàm Thêm mới (INSERT)
    function insert($sql, ...$args)
    {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($args);
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            echo "SQL Error: " . $e->getMessage();
        }
    }

    // 4. Hàm Cập nhật (UPDATE)
    function update($sql, ...$args)
    {
        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($args);
        } catch (PDOException $e) {
            echo "SQL Error: " . $e->getMessage();
        }
    }

    // 5. Hàm Xóa (DELETE)
    function delete($sql, ...$args)
    {
        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($args);
        } catch (PDOException $e) {
            echo "SQL Error: " . $e->getMessage();
        }
    }
}
?>