<?php
session_start();
require_once '../vendor/autoload.php';
require_once '../includes/functions/helpers.php';
require_once '../includes/functions/validation.php';

$loader = new Twig_Loader_Filesystem('../includes/templates');
$twig = new Twig_Environment($loader);
$template = $twig->load('edit_page.twig.html');

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
    $content = $_POST["content"];

    $required_fields = ["menu_name", "position", "visible", "content"];
    $validation->validate_presences($required_fields);

    if (!empty($validation->errors))
    {
        $_SESSION["errors"] = $validation->errors;
        $helpers->redirectTo("edit_page.php?subject={$vars["subject_id"]}&page={$vars["page_id"]}");
    }

    $result = $helpers->updatePage($vars["page_id"], $menu_name, $position, $visible, $content);  

    if ($helpers->db->affected_rows != 0)
    {
        $_SESSION['message'] = "Page edited!";
        $helpers->redirectTo("manage_content.php");
    }
    else
    {
        $_SESSION['message'] = "Page edit failed!";
        $helpers->redirectTo("edit_page.php");
    }
}
else
{
    if (isset($vars["page_id"]) && isset($vars["subject_id"]) && $vars["page_id"] !== "" && $vars["subject_id"] !== "")
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
