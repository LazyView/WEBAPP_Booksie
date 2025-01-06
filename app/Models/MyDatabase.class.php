<?php
namespace kivweb\Models;
use PDO;
use PDOException;

class MyDatabase
{
    public $host;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        try {
            $this->host = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $this->host->exec("set names utf8");
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    /**
     * Executes a general SQL query and returns results.
     */
    public function executeQuery($query, $params = []): array
    {
        try {
            $stmt = $this->host->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Query error: " . $e->getMessage());
            return [];
        }
    }



    // ------------------------------
    // User Management Functions
    // ------------------------------

    /**
     * Retrieves all users with their roles and details.
     */
    public function getAllUsers(): array
    {
        $query = "
        SELECT u.id_uzivatel, u.jmeno, u.email, p.nazev AS role, u.cislo_popisne, u.mesto, u.psc
        FROM uzivatel u
        JOIN uzivatel_pravo p ON u.id_pravo = p.id_pravo
    ";
        $stmt = $this->host->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves all users with their roles and details.
     */
    public function insertUser($username, $email, $password, $id_pravo = 1, $city = null, $number = null, $psc = null) {
        try {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $this->host->prepare("
            INSERT INTO " . TABLE_UZIVATEL . " 
            (jmeno, email, heslo, id_pravo, mesto, cislo_popisne, psc)
            VALUES (:username, :email, :password, :id_pravo, :city, :number, :psc)
        ");

            return $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => $hashedPassword,
                ':id_pravo' => $id_pravo,
                ':city' => $city,
                ':number' => $number,
                ':psc' => $psc
            ]);
        } catch (PDOException $e) {
            error_log("Error inserting user: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Retrieves user details by credentials for login.
     */
    public function getUserByCredentials($username, $password) {
        $stmt = $this->host->prepare(
            "SELECT u.*, up.nazev as role_name 
            FROM " . TABLE_UZIVATEL . " u 
            JOIN " . TABLE_PRAVA . " up 
            ON u.id_pravo = up.id_pravo 
            WHERE u.jmeno = :username"
        );

        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['heslo'])) {
            $_SESSION['user_id'] = $user['id_uzivatel'];
            $_SESSION['user'] = $user['jmeno'];
            $_SESSION['role'] = $user['role_name']; // Make sure this matches your database column
            $_SESSION['logged_in'] = true;
            return true;
        }
        return false;
    }

    /**
     * Updates user details in the database.
     */
    public function updateUser($id, array $data): bool
    {
        $query = "
        UPDATE uzivatel 
        SET jmeno = :jmeno, 
            email = :email, 
            heslo = :heslo, 
            id_pravo = (SELECT id_pravo FROM uzivatel_pravo WHERE nazev = :role)
        WHERE id_uzivatel = :id
    ";

        $stmt = $this->host->prepare($query);
        $stmt->bindParam(':jmeno', $data['jmeno']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':heslo', $data['heslo']);
        $stmt->bindParam(':role', $data['role']);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Retrieves a user by their ID.
     */
    public function getUserById($id): array
    {
        $query = "
        SELECT u.id_uzivatel, u.jmeno, u.email, p.nazev AS role, u.cislo_popisne, u.mesto, u.psc
        FROM uzivatel u
        JOIN uzivatel_pravo p ON u.id_pravo = p.id_pravo
        WHERE u.id_uzivatel = :id
    ";
        $stmt = $this->host->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves a user's password by their ID.
     */
    public function getUserPassword($id): string
    {
        $query = "SELECT heslo FROM uzivatel WHERE id_uzivatel = :id";
        $stmt = $this->host->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    /**
     * Deletes a user by their ID.
     */
    public function deleteUser($id) {
        $stmt = $this->host->prepare("DELETE FROM " . TABLE_UZIVATEL . " WHERE id_uzivatel = :id");
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Checks if a user with the given username or email exists.
     */
    public function checkUserExists($username, $email) {
        $stmt = $this->host->prepare("SELECT COUNT(*) FROM " . TABLE_UZIVATEL . " WHERE jmeno = :username OR email = :email");
        $stmt->execute(['username' => $username, 'email' => $email]);
        $count = $stmt->fetchColumn();
        error_log("Existing users found: " . $count);
        return $count > 0;
    }

    /**
     * Retrieves a user's role by their ID.
     */
    public function getUserRole($id): string
    {
        $query = "
        SELECT p.nazev 
        FROM uzivatel u
        JOIN uzivatel_pravo p ON u.id_pravo = p.id_pravo
        WHERE u.id_uzivatel = :id
    ";
        $stmt = $this->host->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }



    // ------------------------------
    // Book Management Functions
    // ------------------------------

    /**
     * Retrieves a specific book by its ID.
     */
    public function getBookById($id): array
    {
        $query = "
        SELECT id_kniha, nazev, fk_autor, fk_zanr, rok_vydani, ISBN, pocet_stran, popis, logo
        FROM kniha
        WHERE id_kniha = :id
    ";

        $stmt = $this->host->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Updates a book's details.
     */
    public function updateBook($id, $data): bool
    {
        $query = "
        UPDATE kniha SET 
            nazev = :nazev,
            fk_autor = :fk_autor,
            fk_zanr = :fk_zanr,
            rok_vydani = :rok_vydani,
            ISBN = :ISBN,
            pocet_stran = :pocet_stran,
            popis = :popis,
            logo = :logo
        WHERE id_kniha = :id
    ";

        $stmt = $this->host->prepare($query);
        $stmt->bindParam(':nazev', $data['nazev']);
        $stmt->bindParam(':fk_autor', $data['fk_autor']);
        $stmt->bindParam(':fk_zanr', $data['fk_zanr']);
        $stmt->bindParam(':rok_vydani', $data['rok_vydani']);
        $stmt->bindParam(':ISBN', $data['ISBN']);
        $stmt->bindParam(':pocet_stran', $data['pocet_stran']);
        $stmt->bindParam(':popis', $data['popis']);
        $stmt->bindParam(':logo', $data['logo']);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    /**
     * Adds a new book to the database.
     */
    public function addBook($data) {
        $this->host->beginTransaction();
        try {
            error_log("Data received: " . print_r($data, true));

            $stmt = $this->host->prepare("INSERT INTO " . TABLE_KNIHA . " 
            (nazev, fk_autor, rok_vydani, ISBN, pocet_stran, fk_zanr, popis, logo) 
            VALUES (:nazev, :fk_autor, :rok_vydani, :ISBN, :pocet_stran, :fk_zanr, :popis, :logo)");

            $result = $stmt->execute([
                'nazev' => $data['nazev'],
                'fk_autor' => $data['fk_autor'],  // Using the selected author ID directly
                'rok_vydani' => $data['rok_vydani'],
                'ISBN' => $data['ISBN'],
                'pocet_stran' => $data['pocet_stran'],
                'fk_zanr' => $data['fk_zanr'],
                'popis' => $data['popis'],
                'logo' => $data['logo'] ?? null  // Add logo field
            ]);
            $this->host->commit();
            return $result;
        } catch (PDOException $e) {
            $this->host->rollBack();
            error_log("Error adding book: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Deletes a book by its ID.
     */
    public function deleteBook($id) {
        $stmt = $this->host->prepare("DELETE FROM " . TABLE_KNIHA . " WHERE id_kniha = :id");
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Retrieves books authored by a specific author (by name).
     */
    public function getBooksByAuthorName($authorName): array
    {
        $nameParts = explode(' ', $authorName);
        $firstName = $nameParts[0];
        $lastName = $nameParts[1] ?? '';

        $query = "
        SELECT k.id_kniha, k.nazev, k.rok_vydani, k.logo,
            CONCAT(a.jmeno, ' ', a.prijmeni) AS autor_name,
            z.nazev AS genre_name
        FROM kniha k
        JOIN autor a ON k.fk_autor = a.id_autor
        JOIN zanr z ON k.fk_zanr = z.id_zanr
        WHERE a.jmeno = :firstName AND a.prijmeni = :lastName
        ";

        $stmt = $this->host->prepare($query);
        $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves detailed information about a book, including author and genre.
     */
    public function getBookWithDetails($bookId): array
    {
        $query = "
        SELECT k.*, 
               CONCAT(a.jmeno, ' ', a.prijmeni) AS autor_name, 
               z.nazev AS genre_name
        FROM kniha k
        JOIN autor a ON k.fk_autor = a.id_autor
        JOIN zanr z ON k.fk_zanr = z.id_zanr
        WHERE k.id_kniha = :id
        ";

        $stmt = $this->host->prepare($query);
        $stmt->bindParam(':id', $bookId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves the most recent book as the "featured book."
     */

    public function getFeaturedBook() {
        $query = "SELECT * FROM " . TABLE_KNIHA . " ORDER BY id_kniha DESC LIMIT 1";
        $result = $this->executeQuery($query);
        return $result ? $result[0] : null; // Return the first result or null if no books are found
    }

    /**
     * Retrieves books based on filters for authors, genres, and years.
     */
    public function getFilteredBooks(array $authors, array $genres, array $years): array
    {
        $query = "
        SELECT k.*, 
               CONCAT(a.jmeno, ' ', a.prijmeni) AS autor_name, 
               z.nazev AS genre_name
        FROM kniha k
        JOIN autor a ON k.fk_autor = a.id_autor
        JOIN zanr z ON k.fk_zanr = z.id_zanr
        WHERE 1=1
    ";
        $params = [];

        // Apply author filter
        if (!empty($authors)) {
            $placeholders = implode(',', array_fill(0, count($authors), '?'));
            $query .= " AND k.fk_autor IN ($placeholders)";
            $params = array_merge($params, $authors);
        }

        // Apply genre filter
        if (!empty($genres)) {
            $placeholders = implode(',', array_fill(0, count($genres), '?'));
            $query .= " AND k.fk_zanr IN ($placeholders)";
            $params = array_merge($params, $genres);
        }

        // Apply year filter
        if (!empty($years)) {
            $placeholders = implode(',', array_fill(0, count($years), '?'));
            $query .= " AND k.rok_vydani IN ($placeholders)";
            $params = array_merge($params, $years);
        }

        $stmt = $this->host->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Searches for a book by its title.
     */
    public function searchBookByTitle($title) {
        $query = "%" . $title . "%"; // Prepare query for partial match
        $stmt = $this->host->prepare("
        SELECT * FROM " . TABLE_KNIHA . "
        WHERE nazev LIKE :title
        LIMIT 1
    ");
        $stmt->bindParam(':title', $query, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Return the first matching book or null
    }

    /**
     * Checks if a user is the author of a specific book.
     */
    public function isAuthorOfBook($bookId, $userId): bool
    {
        $query = "
    SELECT COUNT(*) 
    FROM kniha k
    JOIN autor a ON k.fk_autor = a.id_autor
    JOIN uzivatel u ON u.jmeno = CONCAT(a.jmeno, ' ', a.prijmeni)
    WHERE k.id_kniha = :bookId AND u.id_uzivatel = :userId
    ";

        $stmt = $this->host->prepare($query);
        $stmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }



    // ------------------------------
    // Author Management Functions
    // ------------------------------

    /**
     * Retrieves all authors.
     */
    public function getAllAuthors()
    {
        $stmt = $this->host->prepare("SELECT * FROM " . TABLE_AUTOR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves all authors along with their book counts.
     */
    public function getAllAuthorsWithBooks() {
        $query = "SELECT a.*, COUNT(k.id_kniha) as book_count 
              FROM autor a 
              LEFT JOIN kniha k ON a.id_autor = k.fk_autor 
              GROUP BY a.id_autor 
              ORDER BY a.prijmeni, a.jmeno";

        $stmt = $this->host->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Adds a new author to the database.
     */
    public function addAuthor($firstName, $lastName) {
        $stmt = $this->host->prepare("INSERT INTO " . TABLE_AUTOR . " (jmeno, prijmeni) VALUES (:jmeno, :prijmeni)");
        $stmt->execute(['jmeno' => $firstName, 'prijmeni' => $lastName]);
        return $this->host->lastInsertId();
    }

    /**
     * Updates an author's details.
     */
    public function updateAuthor($id, $firstName, $lastName) {
        $stmt = $this->host->prepare("UPDATE " . TABLE_AUTOR . " 
                                 SET jmeno = :jmeno, prijmeni = :prijmeni 
                                 WHERE id_autor = :id");
        return $stmt->execute([
            'id' => $id,
            'jmeno' => $firstName,
            'prijmeni' => $lastName
        ]);
    }

    /**
     * Deletes an author if they have no books associated.
     */
    public function deleteAuthor($id): bool
    {
        // First check if author has any books
        $stmt = $this->host->prepare("SELECT COUNT(*) FROM " . TABLE_KNIHA . " WHERE fk_autor = :id");
        $stmt->execute(['id' => $id]);
        $bookCount = $stmt->fetchColumn();

        if ($bookCount > 0) {
            return false; // Can't delete author with books
        }

        try {
            $stmt = $this->host->prepare("DELETE FROM " . TABLE_AUTOR . " WHERE id_autor = :id");
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log("Error deleting author: " . $e->getMessage());
            return false;
        }
    }



    // ------------------------------
    // Genre Management Functions
    // ------------------------------

    /**
     * Retrieves all genres.
     */
    public function getAllGenres()
    {
        return $this->executeQuery("SELECT * FROM " . TABLE_ZANR);
    }


    // ------------------------------
    // Miscellaneous Functions
    // ------------------------------

    /**
     * Retrieves all distinct years from books.
     */
    public function getYears()
    {
        return $this->executeQuery("SELECT DISTINCT rok_vydani FROM " . TABLE_KNIHA . " ORDER BY rok_vydani DESC");
    }
}