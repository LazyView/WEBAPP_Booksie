<?php

namespace kivweb\Controllers;

use kivweb\Models\MyDatabase;

class Spoluprace_controller implements IController
{
    private $db;

    public function __construct(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->db = new MyDatabase();
    }
    public function show($pageTitle): array
    {
        global $templateData;
        $templateData = ["pageTitle" => $pageTitle];
        $templateData["stories"] = $this ->db->getAllUsers();

        return $templateData;
    }
}