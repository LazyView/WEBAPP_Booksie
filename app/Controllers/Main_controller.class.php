<?php

namespace kivweb\Controllers;

use kivweb\Models\MyDatabase;

class Main_controller implements IController
{
    private $db;

    public function __construct(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->db = new MyDatabase();
    }
    public function show($pageTitle): array {
        $data = [
            "pageTitle" => $pageTitle,
            "navbarLinks" => array_keys(WEB_PAGES)
        ];

        if (isset($_SESSION['user'])) {
            $searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

            // Always fetch the featured book
            $data['featuredBook'] = $this->db->getFeaturedBook();

            if (!empty($searchQuery)) {
                $book = $this->db->searchBookByTitle($searchQuery); // Fetch a single book
                if ($book) {
                    // Redirect to the book's detail page
                    header("Location: index.php?page=kniha&id=" . $book['id_kniha']);
                    exit;
                } else {
                    $data['searchError'] = "No book found matching your query.";
                }
            }
        }

        return $data;
    }


}