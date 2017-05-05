<?php
session_start();
require_once '../vendor/autoload.php';
require_once '../includes/functions/helpers.php';
require_once '../includes/functions/validation.php';

$loader = new Twig_Loader_Filesystem('../includes/templates');
$twig = new Twig_Environment($loader);
$template = $twig->load('edit_subject.twig.html');

$helpers = new helpers();
$validation = new validation();

$vars = $helpers->subjectsAndPages();
$vars += $helpers->selectedSubjectAndPage();
$vars += ["message" => $_SESSION["message"], "errors" => $_SESSION["errors"]];

if (isset($_POST["submit"]))
{
    $menu_name = $_POST["menu_name"];
    $position = (int) $_POST["position"];
    $visible = (int) $_POST["visible"];

    $required_fields = ["menu_name", "position", "visible"];
    $validation->validate_presences($required_fields);

    if (!empty($validation->errors))
    {
        $_SESSION["errors"] = $validation->errors;
        $helpers->redirectTo("edit_subject.php?subject={$vars["subject_id"]}");
    }

    $result = $helpers->updateSubject($vars["subject_id"], $menu_name, $position, $visible);  

    if ($result->num_rows != 0)
    {
        $_SESSION['message'] = "Subject edited!";
        $helpers->redirectTo("manage_content.php");
    }
    else
    {
        $_SESSION['message'] = "Subject edit failed!";
        $helpers->redirectTo("edit_subject.php");
    }
}
else
{
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
}
