<?php
session_start();
require_once '../vendor/autoload.php';
require_once '../includes/functions/helpers.php';

$loader = new Twig_Loader_Filesystem('../includes/templates');
$twig = new Twig_Environment($loader);
$template = $twig->load('edit_subject.twig.html');

$helpers = new helpers();

$vars = $helpers->subjectsAndPages();
$vars += $helpers->selectedSubjectAndPage();
$vars += ["message" => $_SESSION["message"], "errors" => $_SESSION["errors"]];

if (isset($vars["subject_id"]) && $vars["subject_id"] !== "")
{
    echo $template->render($vars);

    $_SESSION['message'] = null;
    $_SESSION['errors'] = null;
}
else
{
    $helpers->redirectTo("manage_content.php");
}