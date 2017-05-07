<?php
session_start();
require_once '../includes/functions/helpers.php';
require_once '../includes/functions/validation.php';

$helpers = new helpers();
$validation = new validation();

$helpers->checkLogin($_COOKIE['admin_id']);

if (isset($_POST["submit"]))
{
    $menu_name = $_POST["menu_name"];
    $content = $_POST["content"];
    $subjectID = $_POST["subject_id"];
    $position = (int) $_POST["position"];
    $visible = (int) $_POST["visible"];

    $required_fields = ["menu_name", "position", "visible", "content", "subject_id"];
    $validation->validate_presences($required_fields);

    if (!empty($validation->errors))
    {
        $_SESSION["errors"] = $validation->errors;
        $helpers->redirectTo("new_page.php");
    }

    $result = $helpers->insertPage($menu_name, $position, $visible, $content, $subjectID);  

    if ($result)
    {
        $_SESSION['message'] = "Page created!";
        $helpers->redirectTo("manage_content.php");
    }
    else
    {
        $_SESSION['message'] = "Page creation failed!";
        $helpers->redirectTo("new_page.php");
    }
}
else
{
    $helpers->redirectTo("new_page.php");
}