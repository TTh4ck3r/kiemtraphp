<?php
class BaseController {
    protected function loadView($view, $data = []) {
        // Extract data array to variables
        extract($data);

        // Construct the view path
        $viewPath = '../views/' . $view . '.php';

        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("View not found: " . $viewPath);
        }
    }

    protected function redirect($url) {
        header("Location: " . $url);
        exit();
    }

     protected function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    protected function isAdmin() {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }

     protected function requireLogin() {
        if (!$this->isLoggedIn()) {
            $this->redirect('index.php?controller=auth&action=login');
        }
    }

     protected function requireAdmin() {
        $this->requireLogin(); // Must be logged in first
        if (!$this->isAdmin()) {
             // Optional: Show an access denied message or redirect
             // echo "Access Denied. Admins only.";
             $this->redirect('index.php?controller=nhanvien&action=index'); // Redirect non-admins
        }
    }
}
?>