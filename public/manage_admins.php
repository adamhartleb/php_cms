<?php
session_start();
require_once '../vendor/autoload.php';
require_once '../includes/functions/helpers.php';

$helpers = new helpers();

$helpers->checkLogin($_COOKIE['admin_id']);

$loader = new Twig_Loader_Filesystem('../includes/templates');
$twig = new Twig_Environment($loader);
$template = $twig->load('manage_admins.twig.html');

$vars = $helpers->subjectsAndPages();
$vars += ["admins" => $helpers->getAdmins()];
$vars += ["message" => $_SESSION["message"]];

echo $template->render($vars);

$_SESSION['message'] = null;

