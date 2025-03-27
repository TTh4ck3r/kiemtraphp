<?php

require_once '../models/User.php';
require_once 'BaseController.php';

class UserController extends BaseController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    // List all users (Admin only)
    public function index() {
        $this->requireAdmin(); // Ensure only admin can access

        $users = $this->userModel->getAll();

        $this->loadView('user/index', ['users' => $users]);
    }

    // Show form to edit user role (Admin only)
    // Handle role update submission (Admin only)
    public function edit() {
        $this->requireAdmin();
        $id = $_GET['id'] ?? null;

        if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
             // Optionally redirect with an error
             $this->redirect('index.php?controller=user&action=index&error=invalidid');
             return;
        }

         $user = $this->userModel->findById($id);

        if (!$user) {
             // Optionally redirect with an error
             $this->redirect('index.php?controller=user&action=index&error=notfound');
             return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Process the role update
            $newRole = $_POST['role'] ?? null;

            // Basic validation
            if ($newRole !== 'admin' && $newRole !== 'user') {
                 // Redirect back to edit form with error
                 $this->redirect('index.php?controller=user&action=edit&id=' . $id . '&error=invalidrole');
                 return;
            }

             // Optional: Prevent changing the role of the currently logged-in admin (self)
             // if ($id == $_SESSION['user_id']) {
             //     $this->redirect('index.php?controller=user&action=edit&id='.$id.'&error=selfedit');
             //     return;
             // }

             // Optional: Prevent removing the last admin (requires logic in model or here)
             // if ($user['role'] === 'admin' && $newRole !== 'admin' && $this->userModel->countAdmins() <= 1) {
              //    $this->redirect('index.php?controller=user&action=edit&id='.$id.'&error=lastadmin');
             //    return;
            // }


            if ($this->userModel->updateRole($id, $newRole)) {
                // Success - redirect to user list
                $this->redirect('index.php?controller=user&action=index&success=editrole');
            } else {
                // Failure - redirect back to edit form with error
                $this->redirect('index.php?controller=user&action=edit&id=' . $id . '&error=updatefailed');
            }

        } else {
            // Display the edit form
            $this->loadView('user/edit', ['user' => $user]);
        }
    }

    // Add other user management actions here if needed (e.g., deleteUser)
}
?>