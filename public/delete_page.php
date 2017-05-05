<?php
session_start();
require_once '../includes/functions/helpers.php';

$helpers = new helpers();

$vars = $helpers->selectedSubjectAndPage();

if (isset($vars["page_id"]) && $vars["page_id"] !== "")
{
    $result = $helpers->deletePage($vars["page_id"]);

    if (mysqli_affected_rows($helpers->db) == 0)
    {
        $_SESSION['message'] = "Page deletion failed!";
        $helpers->redirectTo("manage_content.php");
    }
    else
    {
        $_SESSION['message'] = "Page deleted!";
        $helpers->redirectTo("manage_content.php");
    }
}
else
{
    $helpers->redirectTo("manage_content.php");
}