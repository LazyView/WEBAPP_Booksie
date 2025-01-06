<?php
namespace kivweb\Controllers;

use kivweb\Models\MyDatabase;
class Pridat_knihu_controller implements IController
{
    private $db;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->db = new MyDatabase();
    }

    public function show($pageTitle): array {
        if (!isset($_SESSION['logged_in'])) {
            return [
                "pageTitle" => $pageTitle,
                "notLoggedIn" => true
            ];
        }

        // Check if user is Admin, SuperAdmin or Autor
        if (!in_array($_SESSION['role'], ['Admin', 'SuperAdmin', 'Autor'])) {
            return [
                "pageTitle" => $pageTitle,
                "accessDenied" => true
            ];
        }

        // If user is Autor, check if they exist in autor table
        if ($_SESSION['role'] === 'Autor') {
            $authorName = explode(' ', $_SESSION['user']);
            $firstName = $authorName[0];
            $lastName = $authorName[1] ?? '';

            $authors = $this->db->getAllAuthors();
            $isAuthorInTable = false;
            $authorId = null;

            foreach ($authors as $author) {
                if ($author['jmeno'] === $firstName && $author['prijmeni'] === $lastName) {
                    $isAuthorInTable = true;
                    $authorId = $author['id_autor'];
                    break;
                }
            }

            if (!$isAuthorInTable) {
                return [
                    "pageTitle" => $pageTitle,
                    "authorNotFound" => true
                ];
            }
        }

        if (isset($_POST['add_book'])) {
            // Handle file upload for image
            if (isset($_FILES['book_image']) && $_FILES['book_image']['error'] === UPLOAD_ERR_OK) {
                $targetDir = "public/uploads/books/";
                $fileName = time() . '_' . basename($_FILES['book_image']['name']);
                $targetFile = $targetDir . $fileName;

                $fileType = pathinfo($targetFile, PATHINFO_EXTENSION);
                if (in_array(strtolower($fileType), ['jpg', 'jpeg', 'png', 'gif'])) {
                    if (move_uploaded_file($_FILES['book_image']['tmp_name'], $targetFile)) {
                        $_POST['logo'] = $targetFile;
                    }
                }
            }

            $result = $this->db->addBook($_POST);
            if ($result) {
                header("Location: index.php?page=sprava_knih");
                exit;
            }
        }

        return [
            "pageTitle" => $pageTitle,
            "genres" => $this->db->getAllGenres(),
            "authors" => $this->db->getAllAuthors(),
            "userRole" => $_SESSION['role'],
            "preselectedAuthorId" => $authorId ?? null
        ];
    }
}