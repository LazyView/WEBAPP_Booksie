<?php

namespace kivweb\Controllers;

use kivweb\Models\MyDatabase;

class Sprava_uzivatel_controller implements IController
{
    private $db;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->db = new MyDatabase();
    }

    public function show($pageTitle): array
    {
        if (!isset($_SESSION['logged_in'])) {
            header("Location: index.php?page=login");
            exit;
        }

        // Handle user deletion
        if (isset($_POST['delete_user_id'])) {
            $userId = filter_var($_POST['delete_user_id'], FILTER_VALIDATE_INT);
            if($userId === false) {
                $_SESSION['error'] = "Neplatné ID uživatele";
            } else if ($_SESSION['role'] === 'SuperAdmin' && $userId > 0) {
                if($this->db->deleteUser($userId)) {
                    $_SESSION['success'] = "Uživatel byl úspěšně smazán";
                } else {
                    $_SESSION['error'] = "Nepodařilo se smazat uživatele";
                }
            }
            header("Location: index.php?page=Sprava_uzivatel");
            exit;
        }

        // Handle user updates
        if (isset($_POST['save_user'])) {
            $userId = filter_var($_POST['user_id'], FILTER_VALIDATE_INT);
            if($userId === false) {
                $_SESSION['error'] = "Neplatné ID uživatele";
                header("Location: index.php?page=Sprava_uzivatel");
                exit;
            }

            // Validate input data
            $validation = $this->validateUserData($_POST);

            if(empty($validation['errors'])) {
                $data = $validation['data'];

                // Handle password
                if(empty($data['heslo'])) {
                    $data['heslo'] = $this->db->getUserPassword($userId);
                }

                // Handle role
                if ($_SESSION['role'] === 'SuperAdmin' && isset($_POST['role'])) {
                    $data['role'] = filter_var($_POST['role'], FILTER_SANITIZE_STRING);
                } else {
                    $data['role'] = $this->db->getUserRole($userId);
                }

                // Update user
                if($this->db->updateUser($userId, $data)) {
                    $_SESSION['success'] = "Uživatel byl úspěšně aktualizován";
                } else {
                    $_SESSION['error'] = "Nepodařilo se aktualizovat uživatele";
                }
            } else {
                $_SESSION['errors'] = $validation['errors'];
            }

            header("Location: index.php?page=Sprava_uzivatel");
            exit;
        }

        // Fetch users based on role
        $users = [];
        if ($_SESSION['role'] === 'SuperAdmin' || $_SESSION['role'] === 'Admin') {
            $users = $this->db->getAllUsers();
        } else {
            $users[] = $this->db->getUserById($_SESSION['user_id']);
        }

        return [
            "pageTitle" => htmlspecialchars($pageTitle),
            "users" => $users,
            "userRole" => htmlspecialchars($_SESSION['role'])
        ];
    }

    private function validateUserData($data) {
        $errors = [];

        // Validate username
        $data['jmeno'] = htmlspecialchars(trim($data['username']));
        if(empty($data['jmeno'])) {
            $errors[] = "Uživatelské jméno je povinné";
        }
        if(strlen($data['jmeno']) < 3) {
            $errors[] = "Uživatelské jméno musí mít alespoň 3 znaky";
        }

        // Validate email
        $data['email'] = filter_var(trim($data['email']), FILTER_VALIDATE_EMAIL);
        if(!$data['email']) {
            $errors[] = "Neplatná emailová adresa";
        }

        // Validate password if provided
        if(!empty($data['password'])) {
            if(strlen($data['password']) < 6) {
                $errors[] = "Heslo musí mít alespoň 6 znaků";
            }
            $data['heslo'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        // Validate role if provided
        if(isset($data['role'])) {
            $validRoles = ['SuperAdmin', 'Admin', 'Autor', 'Ctenar'];
            if(!in_array($data['role'], $validRoles)) {
                $errors[] = "Neplatná role";
            }
        }

        return [
            'data' => $data,
            'errors' => $errors
        ];
    }
}
