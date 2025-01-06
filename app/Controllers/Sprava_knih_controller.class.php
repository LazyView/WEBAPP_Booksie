<?php
namespace kivweb\Controllers;

use kivweb\Models\MyDatabase;

class Sprava_knih_controller implements IController {
    private $db;

    public function __construct() {
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

        if (isset($_POST['save_book'])) {
            $bookId = filter_var($_POST['book_id'], FILTER_VALIDATE_INT);
            if($bookId === false) {
                $_SESSION['error'] = "Neplatné ID knihy";
                header("Location: index.php?page=Sprava_knih");
                exit;
            }

            $currentBook = $this->db->getBookById($bookId);

            // Validate and sanitize input data
            $validation = $this->validateBookData($_POST);

            if(empty($validation['errors'])) {
                $data = $currentBook; // Start with all current book data

                // Update only the fields from the form with sanitized data
                $data['nazev'] = $validation['data']['nazev'];
                $data['fk_zanr'] = $validation['data']['fk_zanr'];
                $data['rok_vydani'] = $validation['data']['rok_vydani'];

                if ($_SESSION['role'] === 'SuperAdmin' || $_SESSION['role'] === 'Admin' ||
                    ($_SESSION['role'] === 'Autor' && $this->db->isAuthorOfBook($bookId, $_SESSION['user_id']))) {
                    if($this->db->updateBook($bookId, $data)) {
                        $_SESSION['success'] = "Kniha byla úspěšně aktualizována";
                    } else {
                        $_SESSION['error'] = "Nepodařilo se aktualizovat knihu";
                    }
                } else {
                    $_SESSION['error'] = "Nemáte oprávnění upravit tuto knihu";
                }
            } else {
                $_SESSION['errors'] = $validation['errors'];
            }

            header("Location: index.php?page=Sprava_knih");
            exit;
        }

        if (isset($_POST['delete_book'])) {
            $bookId = filter_var($_POST['book_id'], FILTER_VALIDATE_INT);
            if($bookId === false) {
                $_SESSION['error'] = "Neplatné ID knihy";
            } else if ($_SESSION['role'] === 'SuperAdmin' || $_SESSION['role'] === 'Admin') {
                if($this->db->deleteBook($bookId)) {
                    $_SESSION['success'] = "Kniha byla úspěšně odstraněna";
                } else {
                    $_SESSION['error'] = "Nepodařilo se odstranit knihu";
                }
            } else {
                $_SESSION['error'] = "Nemáte oprávnění odstranit tuto knihu";
            }

            header("Location: index.php?page=Sprava_knih");
            exit;
        }

        $books = [];
        $selectedAuthors = array_map('intval', $_GET['authors'] ?? []);
        $selectedGenres = array_map('intval', $_GET['genres'] ?? []);
        $selectedYears = array_map('intval', $_GET['years'] ?? []);

        if ($_SESSION['role'] === 'Autor') {
            $books = $this->db->getBooksByAuthorName(htmlspecialchars($_SESSION['user']));
        } else {
            $books = $this->db->getFilteredBooks($selectedAuthors, $selectedGenres, $selectedYears);
        }

        return [
            "pageTitle" => htmlspecialchars($pageTitle),
            "books" => $books,
            "authors" => $this->db->getAllAuthors(),
            "genres" => $this->db->getAllGenres(),
            "years" => $this->db->getYears(),
            "userRole" => htmlspecialchars($_SESSION['role'])
        ];
    }

    private function validateBookData($data) {
        $errors = [];

        // Validate title
        $data['nazev'] = trim(filter_var($data['nazev'], FILTER_SANITIZE_STRING));
        if(empty($data['nazev'])) {
            $errors[] = "Název knihy je povinný";
        }

        // Validate year
        $year = filter_var($data['rok_vydani'], FILTER_VALIDATE_INT);
        if($year === false || $year < 1000 || $year > date('Y')) {
            $errors[] = "Neplatný rok vydání";
        }

        // Validate genre
        if(empty($data['fk_zanr'])) {
            $errors[] = "Žánr je povinný";
        }

        return [
            'data' => $data,
            'errors' => $errors
        ];
    }

}