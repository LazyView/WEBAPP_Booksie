<?php
//////////////////////////////////////////////////////////////////
/////////////////  Globalni nastaveni aplikace ///////////////////
//////////////////////////////////////////////////////////////////

//// Pripojeni k databazi ////
/** Adresa serveru. */
const DB_SERVER = "localhost:3306";
const DB_NAME = "knihovna";
const DB_USER = "root";
const DB_PASS = "";

// definice konkretnich nazvu tabulek
const TABLE_UZIVATEL = "uzivatel";
const TABLE_PRAVA = "uzivatel_pravo";
const TABLE_AUTOR = "autor";
const TABLE_KNIHA = "kniha";
const TABLE_VYPUJCKA = "vypujcka";
const TABLE_ZANR = "zanr";

const DIRECTORY_CONTROLLERS = __DIR__ . '/app/controllers';
const DIRECTORY_VIEWS = __DIR__ . '/app/views';
const DIRECTORY_MODELS = __DIR__ . '/app/models';

const DEFAULT_WEB_KEY = "main";

const WEB_PAGES = array(
    "main" => array(
        "title" => "main",
        "controller_class_name" => \kivweb\Controllers\Main_controller::class,
        "view_class_name" => \kivweb\Views\TemplateBasics::class,
        "template_type" => \kivweb\Views\TemplateBasics::PAGE_INTRODUCTION,
    ),
    "kniha" => array(
        "title" => "Kniha",
        "controller_class_name" => \kivweb\Controllers\Kniha_controller::class,
        "view_class_name" => \kivweb\Views\TemplateBasics::class,
        "template_type" => \kivweb\Views\TemplateBasics::PAGE_KNIHA,
    ),
    "knihy" => array(
        "title" => "Knihy",
        "controller_class_name" => \kivweb\Controllers\Knihy_controller::class,
        "view_class_name" => \kivweb\Views\TemplateBasics::class,
        "template_type" => \kivweb\Views\TemplateBasics::PAGE_KNIHY,
    ),
    "login" => array(
        "title" => "Login",
        "controller_class_name" => \kivweb\Controllers\Login_controller::class,
        "view_class_name" => \kivweb\Views\TemplateBasics::class,
        "template_type" => \kivweb\Views\TemplateBasics::PAGE_LOGIN,
    ),
    "Nasi_autori" => array(
        "title" => "Nasi_autori",
        "controller_class_name" => \kivweb\Controllers\Nasi_autori_controller::class,
        "view_class_name" => \kivweb\Views\TemplateBasics::class,
        "template_type" => \kivweb\Views\TemplateBasics::PAGE_NASI_AUTORI,
    ),
    "O_nas" => array(
        "title" => "O_nas",
        "controller_class_name" => \kivweb\Controllers\O_nas_controller::class,
        "view_class_name" => \kivweb\Views\TemplateBasics::class,
        "template_type" => \kivweb\Views\TemplateBasics::PAGE_O_NAS,
    ),
    "Pridat_knihu" => array(
        "title" => "Pridat_knihu",
        "controller_class_name" => \kivweb\Controllers\Pridat_knihu_controller::class,
        "view_class_name" => \kivweb\Views\TemplateBasics::class,
        "template_type" => \kivweb\Views\TemplateBasics::PAGE_PRIDAT_KNIHU,
    ),
    "Register" => array(
        "title" => "Register",
        "controller_class_name" => \kivweb\Controllers\Register_controller::class,
        "view_class_name" => \kivweb\Views\TemplateBasics::class,
        "template_type" => \kivweb\Views\TemplateBasics::PAGE_REGISTER,
    ),
    "Spoluprace" => array(
        "title" => "Spoluprace",
        "controller_class_name" => \kivweb\Controllers\Spoluprace_controller::class,
        "view_class_name" => \kivweb\Views\TemplateBasics::class,
        "template_type" => \kivweb\Views\TemplateBasics::PAGE_SPOLUPRACE,
    ),
    "Sprava_knih" => array(
        "title" => "Sprava_knih",
        "controller_class_name" => \kivweb\Controllers\Sprava_knih_controller::class,
        "view_class_name" => \kivweb\Views\TemplateBasics::class,
        "template_type" => \kivweb\Views\TemplateBasics::PAGE_SPRAVA_KNIH,
    ),
    "Sprava_uzivatel" => array(
        "title" => "Sprava_uzivatel",
        "controller_class_name" => \kivweb\Controllers\Sprava_uzivatel_controller::class,
        "view_class_name" => \kivweb\Views\TemplateBasics::class,
        "template_type" => \kivweb\Views\TemplateBasics::PAGE_SPRAVA_UZIVATEL,
    ),
    "logout" => array(
        "title" => "Logout",
        "controller_class_name" => \kivweb\Controllers\Logout_controller::class,
        "view_class_name" => \kivweb\Views\TemplateBasics::class,
        "template_type" => \kivweb\Views\TemplateBasics::PAGE_INTRODUCTION,
    ),
);
