<?php

namespace kivweb\Controllers;

use kivweb\Models\MyDatabase;

class Kniha_controller implements IController
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
            return [
                "pageTitle" => $pageTitle,
                "notLoggedIn" => true
            ];
        }

        if (isset($_POST['save'])) {
            $bookId = $_GET['id'];

            // Validate input data
            $validation = $this->validateBookData($_POST);

            if(empty($validation['errors'])) {
                $updateData = $validation['data'];

                // Handle file upload for logo
                if (isset($_FILES['book_logo']) && $_FILES['book_logo']['error'] === UPLOAD_ERR_OK) {
                    $targetDir = "public/uploads/books/";
                    if (!file_exists($targetDir)) {
                        mkdir($targetDir, 0777, true);
                    }

                    $fileName = time() . '_' . basename($_FILES['book_logo']['name']);
                    $targetFile = $targetDir . $fileName;

                    if (move_uploaded_file($_FILES['book_logo']['tmp_name'], $targetFile)) {
                        $updateData['logo'] = $targetFile;
                    }
                } else {
                    $currentBook = $this->db->getBookWithDetails($bookId);
                    $updateData['logo'] = $currentBook['logo'];
                }

                // Update book
                if($this->db->updateBook($bookId, $updateData)) {
                    $_SESSION['success'] = "Book updated successfully";
                } else {
                    $_SESSION['error'] = "Failed to update book";
                }
            } else {
                $_SESSION['errors'] = $validation['errors'];
            }

            header("Location: index.php?page=kniha&id=" . $bookId);
            exit;
        }


        $bookId = $_GET['id'] ?? null;

        return [
            "pageTitle" => $pageTitle,
            "book" => $this->db->getBookWithDetails($bookId),
            "authors" => $this->db->getAllAuthors(), // Fetch all authors
            "genres" => $this->db->getAllGenres(),   // Fetch all genres
            "userRole" => $_SESSION['role'],
            "editMode" => isset($_GET['edit']) && $_GET['edit'] === 'true' // Detect edit mode
        ];
    }
    private function validateBookData($data) {
        $errors = [];

        // Validate title
        $data['nazev'] = trim(filter_var($data['nazev'], FILTER_SANITIZE_STRING));
        if(empty($data['nazev'])) {
            $errors[] = "Title is required";
        }

        // Validate ISBN format
        $isbn = str_replace(['-', ' '], '', $data['ISBN']);
        if(!preg_match('/^(?:ISBN(?:-13)?:?\s*)?(?=[0-9]{13}$|(?=(?:[0-9]+[-\s]){4})[-\s0-9]{17}$)97[89][-\s]?[0-9]{1,5}[-\s]?[0-9]+[-\s]?[0-9]+[-\s]?[0-9]$/', $isbn)) {
            $errors[] = "Invalid ISBN format";
        }

        // Validate year
        $year = filter_var($data['rok_vydani'], FILTER_VALIDATE_INT);
        if($year === false || $year < 1000 || $year > date('Y')) {
            $errors[] = "Invalid publication year";
        }

        // Validate page count
        $pages = filter_var($data['pocet_stran'], FILTER_VALIDATE_INT);
        if($pages === false || $pages <= 0) {
            $errors[] = "Invalid page count";
        }

        // Sanitize description
        $data['popis'] = trim(filter_var($data['popis'], FILTER_SANITIZE_STRING));

        // Validate file upload only if a new file is being uploaded
        if(isset($_FILES['book_logo']) && $_FILES['book_logo']['error'] !== UPLOAD_ERR_NO_FILE) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if(!in_array($_FILES['book_logo']['type'], $allowedTypes)) {
                $errors[] = "Invalid file type. Only JPG, PNG and GIF are allowed.";
            }
        }

        return [
            'data' => $data,
            'errors' => $errors
        ];
    }
}
