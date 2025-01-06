<?php

namespace kivweb\Controllers;

use kivweb\Models\MyDatabase;

class Knihy_controller implements IController
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

        // Get filters
        $selectedAuthors = $_GET['authors'] ?? [];
        $selectedGenres = $_GET['genres'] ?? [];
        $selectedYears = $_GET['years'] ?? [];

        // Fetch books based on filters
        $books = $this->db->getFilteredBooks($selectedAuthors, $selectedGenres, $selectedYears);

        return [
            "pageTitle" => $pageTitle,
            "books" => $books,
            "authors" => $this->db->getAllAuthors(),
            "genres" => $this->db->getAllGenres(),
            "years" => $this->db->getYears(),
            "selectedAuthors" => $selectedAuthors,
            "selectedGenres" => $selectedGenres,
            "selectedYears" => $selectedYears
        ];
    }

}
