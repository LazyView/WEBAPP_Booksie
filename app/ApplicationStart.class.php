<?php

namespace kivweb;
use kivweb\Controllers\IController;
use kivweb\Views\IView;

/**
 * Vstupni bod webove aplikace.
 */
class ApplicationStart {

    /**
     * Inicializace webove aplikace.
     */
    public function __construct() {}
    /**
     * Spusteni webove aplikace.
     */
    public function appStart()
    {
        session_start();
        if (isset($_GET["page"]) && array_key_exists($_GET["page"], WEB_PAGES)) {
            $pageKey = $_GET["page"];
        } else {
            $pageKey = DEFAULT_WEB_KEY;
        }

        $pageInfo = WEB_PAGES[$pageKey];

        /** @var IController $controller */
        $controller = new $pageInfo["controller_class_name"];
        $tplData = $controller->show($pageInfo['title']);

        /** @var IView $viewClass */
        $viewClass = $pageInfo['view_class_name'];
        $view = new $viewClass(); // Instantiate the view
        $view->printOutput($tplData, $pageInfo['template_type']);
    }
}
