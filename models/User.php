<?php
require_once 'Database.php';

class User {
    private $conn;
    private $table = 'user';

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    // Find user by username
    public function findByUsername($username) {
        $query = "SELECT Id, username, password, fullname, role FROM " . $this->table . " WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Find user by email
    public function findByEmail($email) {
        $query = "SELECT Id FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }

     // Find user by ID
    public function findById($id) {
        $query = "SELECT Id, username, password, fullname, email, role FROM " . $this->table . " WHERE Id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Check if username exists
    public function isUsernameTaken($username) {
        return $this->findByUsername($username) !== false;
    }

     // Check if email exists
    public function isEmailTaken($email) {
        return $this->findByEmail($email) !== false;
    }


    // Verify password (using password_verify)
    public function verifyPassword($plainPassword, $hashedPassword) {
        return password_verify($plainPassword, $hashedPassword);
    }

    // Add a new user (for registration, defaults role to 'user')
    public function register($data) {
        $query = "INSERT INTO " . $this->table . " (username, password, fullname, email, role)
                  VALUES (:username, :password, :fullname, :email, :role)";
        $stmt = $this->conn->prepare($query);

        // Sanitize and hash password
        $username = htmlspecialchars(strip_tags($data['username']));
        $password = password_hash($data['password'], PASSWORD_DEFAULT); // HASHING!
        $fullname = htmlspecialchars(strip_tags($data['fullname']));
        $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $role = 'user'; // Default role for registration

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            // Log error (e.g., duplicate username/email)
            error_log("Register user error: " . $e->getMessage());
            return false;
        }
    }

     // Get all users (for admin management)
    public function getAll() {
        $query = "SELECT Id, username, fullname, email, role FROM " . $this->table . " ORDER BY username";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll();
    }

     // Update user's role (by Admin)
    public function updateRole($id, $role) {
        // Validate role
        $allowed_roles = ['admin', 'user'];
        if (!in_array($role, $allowed_roles)) {
            error_log("Invalid role specified: " . $role);
            return false; // Invalid role
        }

        $query = "UPDATE " . $this->table . " SET role = :role WHERE Id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        try {
            // Optional: Add logic to prevent removing the last admin role
            // if ($this->isLastAdmin($id) && $role !== 'admin') {
            //     error_log("Cannot remove the last admin role.");
            //     return false;
            // }
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Update user role error: " . $e->getMessage());
            return false;
        }
    }

    // --- Helper for advanced logic (Optional) ---
    // private function countAdmins() {
    //     $query = "SELECT COUNT(*) as admin_count FROM " . $this->table . " WHERE role = 'admin'";
    //     $stmt = $this->conn->query($query);
    //     return $stmt->fetchColumn();
    // }
    // private function isLastAdmin($id) {
    //     $user = $this->findById($id);
    //     return ($user && $user['role'] === 'admin' && $this->countAdmins() <= 1);
    // }

}
?>