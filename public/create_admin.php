<?php
session_start();
require_once '../vendor/autoload.php';
require_once '../includes/functions/helpers.php';

$helpers = new helpers();

$loader = new Twig_Loader_Filesystem('../includes/templates');
$twig = new Twig_Environment($loader);
$template = $twig->load('new_admin.twig.html');

$vars = $helpers->subjectsAndPages();
$vars += [ "errors" => $_SESSION["errors"] ];

echo $template->render($vars);

$_SESSION["errors"] = null;

