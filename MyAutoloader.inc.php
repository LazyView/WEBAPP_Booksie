<?php

const BASE_NAMESPACE_NAME = "kivweb";
const BASE_APP_DIR_NAME = "app";

const FILE_EXTENSION = array(".class.php", ".interface.php");

spl_autoload_register(function($className) {
    // Replace namespace separators with directory separators
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);

    // Replace base namespace with app directory
    $className = str_replace(BASE_NAMESPACE_NAME, BASE_APP_DIR_NAME, $className);

    // Base file path without extension
    $baseFileName = dirname(__FILE__) . DIRECTORY_SEPARATOR . $className;

    // Try each possible extension
    foreach (FILE_EXTENSION as $ext) {
        $fileName = $baseFileName . $ext;
        if (file_exists($fileName)) {
            require_once($fileName);
            return; // Exit after finding and requiring the file
        }
    }

    // Log if no file was found with any extension
    error_log("File not found: " . $baseFileName . " with any known extension");
});