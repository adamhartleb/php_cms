<?php
session_start();
require_once '../includes/functions/helpers.php';

$helpers = new helpers();

if (isset($_POST["submit"]))
{
    $menu_name = $_POST["menu_name"];
    $position = (int) $_POST["position"];
    $visible = (int) $_POST["visible"];

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