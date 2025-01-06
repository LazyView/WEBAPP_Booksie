<?php
namespace kivweb\Controllers;

class O_nas_controller implements IController {

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function show($pageTitle): array {
        return [
            "pageTitle" => $pageTitle,
            "navbarLinks" => ['main', 'knihy', 'Nasi_autori', 'Spoluprace', 'O_nas']
        ];
    }
}