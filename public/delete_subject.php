<?php
session_start();
require_once '../includes/functions/helpers.php';
require_once '../includes/functions/validation.php';

$helpers = new helpers();

$helpers->checkLogin($_COOKIE['admin_id']);

$vars = $helpers->selectedSubjectAndPage();

if (isset($vars["subject_id"]) && $vars["subject_id"] !== "")
{
    if ($helpers->subjectPagesExist($vars["subject_id"])->num_rows > 0)
    {
        $_SESSION['message'] = "Cannot delete a subject with existing pages";
    }
    else
    {
        $result = $helpers->deleteSubject($vars["subject_id"]);

        $_SESSION['message'] =  $helpers->db->affected_rows == 0 
            ? "Subject deletion failed!"
            : "Subject deletion successful!";
    }
}

$helpers->redirectTo("manage_content.php");

