<?php

namespace kivweb\Controllers;

interface IController{
    /**
     * @param $pageTitle
     * @return array
     */
    public function show($pageTitle): array;
}
