<?php
session_start();
require_once '../includes/functions/helpers.php';

$helpers = new helpers();

$helpers->checkLogin($_COOKIE['admin_id']);

$vars = $helpers->selectedSubjectAndPage();

if (isset($vars["page_id"]) && $vars["page_id"] !== "")
{
    $result = $helpers->deletePage($vars["page_id"]);

    $_SESSION['message'] =  $helpers->db->affected_rows == 0 
        ? "Page deletion failed!"
        : "Page deletion successful!";
}

$helpers->redirectTo("manage_content.php");