<?php
session_start();
require_once '../includes/functions/helpers.php';
require_once '../includes/functions/validation.php';

$helpers = new helpers();
$validation = new validation();

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
        $helpers->redirectTo("new_subject.php");
    }

    $result = $helpers->insertSubject($menu_name, $position, $visible);  

    if ($result)
    {
        $_SESSION['message'] = "Subject created!";
        $helpers->redirectTo("manage_content.php");
    }
    else
    {
        $_SESSION['message'] = "Subject creation failed!";
        $helpers->redirectTo("new_subject.php");
    }
}
else
{
    $helpers->redirectTo("new_subject.php");
}