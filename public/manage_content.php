<?php
session_start();
require_once '../vendor/autoload.php';
require_once '../includes/functions/helpers.php';

$helpers = new helpers();

$helpers->checkLogin($_COOKIE['admin_id']);

$loader = new Twig_Loader_Filesystem('../includes/templates');
$twig = new Twig_Environment($loader);

$template = $twig->load('manage_content.twig.html');

$vars = $helpers->subjectsAndPages();
$vars += $helpers->selectedSubjectAndPage();
if (isset($_SESSION['message']))
{
  $vars += ["message" => $_SESSION['message']];
}


echo $template->render($vars);

$_SESSION['message'] = null;