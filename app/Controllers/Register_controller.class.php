<?php

namespace kivweb\Controllers;

use kivweb\Models\MyDatabase;

class Register_controller implements IController {
    private $db;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->db = new MyDatabase();
    }

    public function show($pageTitle): array {
        $templateData = [
            "pageTitle" => htmlspecialchars($pageTitle)
        ];

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register'])) {
            // Validate all input data
            $validation = $this->validateRegistrationData($_POST);

            if(empty($validation['errors'])) {
                $data = $validation['data'];

                if ($this->db->checkUserExists($data['username'], $data['email'])) {
                    $templateData["error"] = "Uživatel s tímto jménem nebo emailem již existuje.";
                } else {
                    $success = $this->db->insertUser(
                        $data['username'],
                        $data['email'],
                        $data['password'],
                        4, // Default role ID
                        $data['city'] ?? null,
                        $data['number'] ?? null,
                        $data['psc'] ?? null
                    );

                    if ($success) {
                        if ($this->db->getUserByCredentials($data['username'], $data['password'])) {
                            header("Location: index.php?page=main");
                            exit;
                        }
                    } else {
                        $templateData["error"] = "Registrace se nezdařila. Zkuste to prosím později.";
                    }
                }
            } else {
                $templateData["errors"] = $validation['errors'];
            }
        }

        return $templateData;
    }

    private function validateRegistrationData($data) {
        $errors = [];

        // Validate username
        $data['username'] = htmlspecialchars(trim($data['username']));
        if(empty($data['username'])) {
            $errors[] = "Uživatelské jméno je povinné";
        } elseif(strlen($data['username']) < 3) {
            $errors[] = "Uživatelské jméno musí mít alespoň 3 znaky";
        }

        // Validate email
        $data['email'] = filter_var(trim($data['email']), FILTER_VALIDATE_EMAIL);
        if(!$data['email']) {
            $errors[] = "Neplatná emailová adresa";
        }

        // Validate password
        if(empty($data['password'])) {
            $errors[] = "Heslo je povinné";
        } elseif(strlen($data['password']) < 5) {
            $errors[] = "Heslo musí mít alespoň 5 znaků";
        } elseif($data['password'] !== $data['confirm_password']) {
            $errors[] = "Hesla se neshodují";
        }

        // Validate optional fields
        if(!empty($data['city'])) {
            $data['city'] = htmlspecialchars(trim($data['city']));
        }

        if(!empty($data['number'])) {
            $data['number'] = filter_var($data['number'], FILTER_VALIDATE_INT);
            if($data['number'] === false) {
                $errors[] = "Neplatné číslo popisné";
            }
        }

        if(!empty($data['psc'])) {
            $data['psc'] = preg_replace('/\s+/', '', $data['psc']);
            if(!preg_match('/^[0-9]{5}$/', $data['psc'])) {
                $errors[] = "Neplatné PSČ (musí obsahovat 5 číslic)";
            }
        }

        return [
            'data' => $data,
            'errors' => $errors
        ];
    }
}