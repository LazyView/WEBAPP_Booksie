<?php
namespace kivweb\Controllers;

use kivweb\Models\MyDatabase;

class Login_controller implements IController {
    private $db;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->db = new MyDatabase();
    }

    private function validateLoginData($data) {
        $errors = [];

        // Validate username
        $data['username'] = htmlspecialchars(trim($data['username']));
        if(empty($data['username'])) {
            $errors[] = "Uživatelské jméno je povinné";
        }

        // Validate password
        if(empty($data['password'])) {
            $errors[] = "Heslo je povinné";
        }

        // Add basic rate limiting
        if(isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] >= 5 &&
            time() - $_SESSION['last_attempt'] < 300) {
            $errors[] = "Příliš mnoho pokusů o přihlášení. Zkuste to prosím později.";
        }

        return [
            'data' => $data,
            'errors' => $errors
        ];
    }

    public function show($pageTitle): array {
        // Clear login attempts after 5 minutes
        if(isset($_SESSION['last_attempt']) && time() - $_SESSION['last_attempt'] >= 300) {
            unset($_SESSION['login_attempts']);
            unset($_SESSION['last_attempt']);
        }

        if(isset($_POST['login'])) {
            $validation = $this->validateLoginData($_POST);

            if(empty($validation['errors'])) {
                $data = $validation['data'];

                // Increment login attempts
                $_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;
                $_SESSION['last_attempt'] = time();

                if($this->db->getUserByCredentials($data['username'], $_POST['password'])) {
                    // Reset login attempts on successful login
                    unset($_SESSION['login_attempts']);
                    unset($_SESSION['last_attempt']);

                    header("Location: index.php?page=main");
                    exit;
                } else {
                    $validation['errors'][] = "Nesprávné uživatelské jméno nebo heslo";
                }
            }

            return [
                "pageTitle" => htmlspecialchars($pageTitle),
                "errors" => $validation['errors']
            ];
        }

        return [
            "pageTitle" => htmlspecialchars($pageTitle)
        ];
    }
}