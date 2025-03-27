<?php
require_once 'Database.php';

class NhanVien {
    private $conn;
    private $table = 'NHANVIEN';

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    // Get all employees with pagination and department name
    public function getAll($limit, $offset) {
        $query = "SELECT nv.Ma_NV, nv.Ten_NV, nv.Phai, nv.Noi_Sinh, nv.Luong, pb.Ten_Phong
                  FROM " . $this->table . " nv
                  LEFT JOIN PHONGBAN pb ON nv.Ma_Phong = pb.Ma_Phong
                  ORDER BY nv.Ma_NV ASC
                  LIMIT :limit OFFSET :offset";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Count total number of employees
    public function countAll() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table;
        $stmt = $this->conn->query($query);
        $row = $stmt->fetch();
        return $row['total'];
    }

    // Get employee by ID
    public function getById($ma_nv) {
         $query = "SELECT nv.Ma_NV, nv.Ten_NV, nv.Phai, nv.Noi_Sinh, nv.Luong, nv.Ma_Phong
                  FROM " . $this->table . " nv
                  WHERE nv.Ma_NV = :ma_nv";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':ma_nv', $ma_nv);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Add a new employee
    public function add($data) {
        $query = "INSERT INTO " . $this->table . " (Ma_NV, Ten_NV, Phai, Noi_Sinh, Ma_Phong, Luong)
                  VALUES (:ma_nv, :ten_nv, :phai, :noi_sinh, :ma_phong, :luong)";
        $stmt = $this->conn->prepare($query);

        // Sanitize data (basic example)
        $ma_nv = htmlspecialchars(strip_tags($data['Ma_NV']));
        $ten_nv = htmlspecialchars(strip_tags($data['Ten_NV']));
        $phai = htmlspecialchars(strip_tags($data['Phai']));
        $noi_sinh = htmlspecialchars(strip_tags($data['Noi_Sinh']));
        $ma_phong = htmlspecialchars(strip_tags($data['Ma_Phong']));
        $luong = filter_var($data['Luong'], FILTER_SANITIZE_NUMBER_INT);


        $stmt->bindParam(':ma_nv', $ma_nv);
        $stmt->bindParam(':ten_nv', $ten_nv);
        $stmt->bindParam(':phai', $phai);
        $stmt->bindParam(':noi_sinh', $noi_sinh);
        $stmt->bindParam(':ma_phong', $ma_phong);
        $stmt->bindParam(':luong', $luong, PDO::PARAM_INT);


        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            // Handle potential errors like duplicate Ma_NV
             error_log("Add employee error: " . $e->getMessage()); // Log error
            return false;
        }
    }

    // Update an existing employee
    public function update($ma_nv, $data) {
        $query = "UPDATE " . $this->table . "
                  SET Ten_NV = :ten_nv, Phai = :phai, Noi_Sinh = :noi_sinh, Ma_Phong = :ma_phong, Luong = :luong
                  WHERE Ma_NV = :ma_nv";
        $stmt = $this->conn->prepare($query);

        // Sanitize data
        $ten_nv = htmlspecialchars(strip_tags($data['Ten_NV']));
        $phai = htmlspecialchars(strip_tags($data['Phai']));
        $noi_sinh = htmlspecialchars(strip_tags($data['Noi_Sinh']));
        $ma_phong = htmlspecialchars(strip_tags($data['Ma_Phong']));
        $luong = filter_var($data['Luong'], FILTER_SANITIZE_NUMBER_INT);
        $ma_nv_clean = htmlspecialchars(strip_tags($ma_nv));

        $stmt->bindParam(':ten_nv', $ten_nv);
        $stmt->bindParam(':phai', $phai);
        $stmt->bindParam(':noi_sinh', $noi_sinh);
        $stmt->bindParam(':ma_phong', $ma_phong);
        $stmt->bindParam(':luong', $luong, PDO::PARAM_INT);
        $stmt->bindParam(':ma_nv', $ma_nv_clean);


        try {
            return $stmt->execute();
        } catch (PDOException $e) {
             error_log("Update employee error: " . $e->getMessage()); // Log error
            return false;
        }
    }

    // Delete an employee
    public function delete($ma_nv) {
        $query = "DELETE FROM " . $this->table . " WHERE Ma_NV = :ma_nv";
        $stmt = $this->conn->prepare($query);

        $ma_nv_clean = htmlspecialchars(strip_tags($ma_nv));
        $stmt->bindParam(':ma_nv', $ma_nv_clean);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Delete employee error: " . $e->getMessage()); // Log error
            return false;
        }
    }
}
?>