<?php
namespace kivweb\Controllers;

class Logout_controller implements IController {
    public function show($pageTitle): array {
        session_start();
        session_unset();
        session_destroy();
        header("Location: index.php?page=main");
        exit;

        return ["pageTitle" => $pageTitle];
    }
}