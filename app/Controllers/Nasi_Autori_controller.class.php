<?php
namespace kivweb\Controllers;

use kivweb\Models\MyDatabase;

class Nasi_autori_controller implements IController
{
    private $db;

    public function __construct(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->db = new MyDatabase();
    }

    private function validateAuthorData($data) {
        $errors = [];

        // Validate first name
        $data['jmeno'] = htmlspecialchars(trim($data['jmeno']));
        if(empty($data['jmeno'])) {
            $errors[] = "Jméno je povinné";
        } elseif(strlen($data['jmeno']) < 2) {
            $errors[] = "Jméno musí mít alespoň 2 znaky";
        }

        // Validate last name
        $data['prijmeni'] = htmlspecialchars(trim($data['prijmeni']));
        if(empty($data['prijmeni'])) {
            $errors[] = "Příjmení je povinné";
        } elseif(strlen($data['prijmeni']) < 2) {
            $errors[] = "Příjmení musí mít alespoň 2 znaky";
        }

        return [
            'data' => $data,
            'errors' => $errors
        ];
    }

    public function show($pageTitle): array {
        if (!isset($_SESSION['logged_in'])) {
            return [
                "pageTitle" => htmlspecialchars($pageTitle),
                "notLoggedIn" => true
            ];
        }

        $isAdmin = isset($_SESSION['role']) && in_array($_SESSION['role'], ['Admin', 'SuperAdmin']);
        $messages = [];

        if($isAdmin) {
            // Handle adding new author
            if(isset($_POST['add_author'])) {
                $validation = $this->validateAuthorData($_POST);

                if(empty($validation['errors'])) {
                    $data = $validation['data'];
                    if($this->db->addAuthor($data['jmeno'], $data['prijmeni'])) {
                        $_SESSION['success'] = "Autor byl úspěšně přidán";
                    } else {
                        $_SESSION['error'] = "Nepodařilo se přidat autora";
                    }
                    header("Location: index.php?page=Nasi_autori");
                    exit;
                } else {
                    $_SESSION['errors'] = $validation['errors'];
                }
            }

            // Handle updating author
            if(isset($_POST['save_author'])) {
                $authorId = filter_var($_POST['author_id'], FILTER_VALIDATE_INT);
                if($authorId === false) {
                    $_SESSION['error'] = "Neplatné ID autora";
                } else {
                    $validation = $this->validateAuthorData($_POST);

                    if(empty($validation['errors'])) {
                        $data = $validation['data'];
                        if($this->db->updateAuthor($authorId, $data['jmeno'], $data['prijmeni'])) {
                            $_SESSION['success'] = "Autor byl úspěšně aktualizován";
                        } else {
                            $_SESSION['error'] = "Nepodařilo se aktualizovat autora";
                        }
                    } else {
                        $_SESSION['errors'] = $validation['errors'];
                    }
                }
                header("Location: index.php?page=Nasi_autori");
                exit;
            }

            // Handle deleting author
            if(isset($_GET['delete'])) {
                $authorId = filter_var($_GET['delete'], FILTER_VALIDATE_INT);
                if($authorId === false) {
                    $_SESSION['error'] = "Neplatné ID autora";
                } else {
                    if($this->db->deleteAuthor($authorId)) {
                        $_SESSION['success'] = "Autor byl úspěšně smazán";
                    } else {
                        $_SESSION['error'] = "Nelze smazat autora, který má přiřazené knihy";
                    }
                }
                header("Location: index.php?page=Nasi_autori");
                exit;
            }
        }

        return [
            "pageTitle" => htmlspecialchars($pageTitle),
            "authors" => $this->db->getAllAuthorsWithBooks(),
            "isAdmin" => $isAdmin,
            "userRole" => htmlspecialchars($_SESSION['role'] ?? 'guest'),
            "errors" => $_SESSION['errors'] ?? null,
            "error" => $_SESSION['error'] ?? null,
            "success" => $_SESSION['success'] ?? null
        ];
    }
}