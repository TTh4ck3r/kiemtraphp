<?php
session_start(); // Start session at the beginning
require_once '../models/User.php';
require_once 'BaseController.php';

class AuthController extends BaseController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login() {
        if ($this->isLoggedIn()) {
             $this->redirect('index.php?controller=nhanvien&action=index');
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($username) || empty($password)) {
                $error = 'Tên đăng nhập và mật khẩu là bắt buộc.';
            } else {
                $user = $this->userModel->findByUsername($username);

                if ($user && $this->userModel->verifyPassword($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['Id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['user_fullname'] = $user['fullname'];
                    $_SESSION['user_role'] = $user['role'];
                     $this->redirect('index.php?controller=nhanvien&action=index');
                } else {
                    $error = 'Tên đăng nhập hoặc mật khẩu không hợp lệ.';
                }
            }
        }
        $this->loadView('auth/login', ['error' => $error]);
    }

    public function register() {
         if ($this->isLoggedIn()) {
             $this->redirect('index.php?controller=nhanvien&action=index');
         }

        $errors = [];
        $input = []; // To repopulate form

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve and sanitize input
            $input['username'] = trim($_POST['username'] ?? '');
            $input['password'] = trim($_POST['password'] ?? '');
            $input['confirm_password'] = trim($_POST['confirm_password'] ?? '');
            $input['fullname'] = trim($_POST['fullname'] ?? '');
            $input['email'] = trim($_POST['email'] ?? '');

            // --- Validation ---
            if (empty($input['username'])) {
                $errors['username'] = 'Tên đăng nhập là bắt buộc.';
            } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $input['username'])) {
                 $errors['username'] = 'Tên đăng nhập chỉ chứa chữ cái, số và dấu gạch dưới.';
            } elseif ($this->userModel->isUsernameTaken($input['username'])) {
                 $errors['username'] = 'Tên đăng nhập này đã được sử dụng.';
            }

            if (empty($input['password'])) {
                $errors['password'] = 'Mật khẩu là bắt buộc.';
            } elseif (strlen($input['password']) < 6) { // Example: minimum length
                 $errors['password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
            }

            if ($input['password'] !== $input['confirm_password']) {
                $errors['confirm_password'] = 'Xác nhận mật khẩu không khớp.';
            }

            if (empty($input['fullname'])) {
                $errors['fullname'] = 'Họ và tên là bắt buộc.';
            }

            if (empty($input['email'])) {
                $errors['email'] = 'Email là bắt buộc.';
            } elseif (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Địa chỉ email không hợp lệ.';
            } elseif ($this->userModel->isEmailTaken($input['email'])) {
                 $errors['email'] = 'Địa chỉ email này đã được sử dụng.';
            }
            // --- End Validation ---


            if (empty($errors)) {
                // Attempt registration
                $dataToRegister = [
                    'username' => $input['username'],
                    'password' => $input['password'], // Hashing happens in the model
                    'fullname' => $input['fullname'],
                    'email' => $input['email']
                ];

                if ($this->userModel->register($dataToRegister)) {
                    // Registration successful - Redirect to login page with success message
                    $this->redirect('index.php?controller=auth&action=login®istered=1');
                } else {
                    // Database or other error during registration
                    $errors['general'] = 'Đã xảy ra lỗi trong quá trình đăng ký. Vui lòng thử lại.';
                }
            }
            // If validation fails or registration fails, the view will be loaded below
        }

        // Load the registration view, passing errors and input data (for repopulation)
        $this->loadView('auth/register', ['errors' => $errors, 'input' => $input]);
    }


    public function logout() {
        $_SESSION = array();
        session_destroy();
        $this->redirect('index.php?controller=auth&action=login&loggedout=1');
    }
}
?>