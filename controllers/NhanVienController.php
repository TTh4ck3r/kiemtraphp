<?php

require_once '../models/NhanVien.php';
require_once '../models/PhongBan.php';
require_once 'BaseController.php'; // Include BaseController

class NhanVienController extends BaseController { // Extend BaseController
    private $nhanVienModel;
    private $phongBanModel;

    public function __construct() {
        $this->nhanVienModel = new NhanVien();
        $this->phongBanModel = new PhongBan();
    }

    public function index() {
        $this->requireLogin(); // Make sure user is logged in to view

        // Pagination settings
        $limit = 5; // Employees per page
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, $page); // Ensure page is at least 1
        $offset = ($page - 1) * $limit;

        // Get data from model
        $nhanviens = $this->nhanVienModel->getAll($limit, $offset);
        $totalNhanViens = $this->nhanVienModel->countAll();
        $totalPages = ceil($totalNhanViens / $limit);

        // Prepare data for the view
        $data = [
            'nhanviens' => $nhanviens,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'isAdmin' => $this->isAdmin() // Pass admin status to view
        ];

        // Load the view
        $this->loadView('nhanvien/index', $data);
    }

    public function add() {
        $this->requireAdmin(); // Only admins can add

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Process form submission
            $data = [
                'Ma_NV' => $_POST['Ma_NV'] ?? '',
                'Ten_NV' => $_POST['Ten_NV'] ?? '',
                'Phai' => $_POST['Phai'] ?? '',
                'Noi_Sinh' => $_POST['Noi_Sinh'] ?? '',
                'Ma_Phong' => $_POST['Ma_Phong'] ?? '',
                'Luong' => $_POST['Luong'] ?? 0,
            ];

            // Basic Validation (Add more robust validation in real app)
            if (empty($data['Ma_NV']) || empty($data['Ten_NV']) || empty($data['Ma_Phong'])) {
                 // Handle validation errors - maybe redirect back with error message
                 echo "Error: Ma_NV, Ten_NV, and Ma_Phong are required."; // Simple error
                 // In a real app, redirect back to the form with errors
                 // $this->redirect('index.php?controller=nhanvien&action=add&error=validation');
                 return;
            }


            if ($this->nhanVienModel->add($data)) {
                // Redirect to index page on success
                $this->redirect('index.php?controller=nhanvien&action=index&success=add');
            } else {
                // Handle error (e.g., display error message)
                 echo "Error adding employee. Ma_NV might already exist.";
                 // In a real app, redirect back to the form with errors
                 // $this->redirect('index.php?controller=nhanvien&action=add&error=addfailed');
            }
        } else {
            // Display the add form
            $phongbans = $this->phongBanModel->getAll();
            $this->loadView('nhanvien/add', ['phongbans' => $phongbans]);
        }
    }

    public function edit() {
         $this->requireAdmin(); // Only admins can edit
         $ma_nv = $_GET['id'] ?? null;

        if (!$ma_nv) {
            echo "Error: Employee ID not specified.";
             // $this->redirect('index.php?controller=nhanvien&action=index&error=noid');
            return;
        }

         $nhanvien = $this->nhanVienModel->getById($ma_nv);

        if (!$nhanvien) {
             echo "Error: Employee not found.";
            // $this->redirect('index.php?controller=nhanvien&action=index&error=notfound');
             return;
         }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Process form submission
            $data = [
                // Ma_NV is not usually updated, it's the identifier
                'Ten_NV' => $_POST['Ten_NV'] ?? '',
                'Phai' => $_POST['Phai'] ?? '',
                'Noi_Sinh' => $_POST['Noi_Sinh'] ?? '',
                'Ma_Phong' => $_POST['Ma_Phong'] ?? '',
                'Luong' => $_POST['Luong'] ?? 0,
            ];

             // Basic Validation
            if (empty($data['Ten_NV']) || empty($data['Ma_Phong'])) {
                 echo "Error: Ten_NV and Ma_Phong are required.";
                 // $this->redirect('index.php?controller=nhanvien&action=edit&id='.$ma_nv.'&error=validation');
                 return;
            }


            if ($this->nhanVienModel->update($ma_nv, $data)) {
                // Redirect to index page on success
                $this->redirect('index.php?controller=nhanvien&action=index&success=edit');
            } else {
                // Handle error
                 echo "Error updating employee.";
                 // $this->redirect('index.php?controller=nhanvien&action=edit&id='.$ma_nv.'&error=updatefailed');
            }
        } else {
            // Display the edit form
            $phongbans = $this->phongBanModel->getAll();
            $this->loadView('nhanvien/edit', ['nhanvien' => $nhanvien, 'phongbans' => $phongbans]);
        }
    }

     public function delete() {
        $this->requireAdmin(); // Only admins can delete
        $ma_nv = $_GET['id'] ?? null;

        if (!$ma_nv) {
             echo "Error: Employee ID not specified for deletion.";
            // $this->redirect('index.php?controller=nhanvien&action=index&error=noiddelete');
            return;
        }

         // Optional: Add a confirmation step here in a real application

        if ($this->nhanVienModel->delete($ma_nv)) {
            // Redirect to index page on success
             $this->redirect('index.php?controller=nhanvien&action=index&success=delete');
        } else {
            // Handle error
            echo "Error deleting employee.";
            // $this->redirect('index.php?controller=nhanvien&action=index&error=deletefailed');
        }
    }
}
?>