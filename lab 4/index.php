<?php

require_once("src/RenderHTML.php");
require_once("src/controller/AccountController.php");

session_start();
date_default_timezone_set("Europe/Stockholm");
setlocale(LC_ALL, "sv_SE");

$controller = new AccountController();
$body = $controller->HandleAccounts();

$view = new HTMLRenderer();
$view->RenderHTML($body);