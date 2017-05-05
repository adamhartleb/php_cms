<?php
session_start();
require_once '../includes/functions/helpers.php';
require_once '../includes/functions/validation.php';

$helpers = new helpers();

$vars = $helpers->selectedSubjectAndPage();

if (isset($vars["subject_id"]) && $vars["subject_id"] !== "")
{
    if ($helpers->subjectPagesExist($vars["subject_id"])->num_rows > 0)
    {
        $_SESSION['message'] = "Cannot delete a subject with existing pages";
        $helpers->redirectTo("manage_content.php");
    }
    else
    {
        $result = $helpers->deleteSubject($vars["subject_id"]);
        if ($result->num_rows != 0)
        {
            $_SESSION['message'] = "Subject deleted!";
            $helpers->redirectTo("manage_content.php");
        }
        else
        {
            $_SESSION['message'] = "Subject deletion failed!";
            $helpers->redirectTo("manage_content.php");
        }
    }
}
else
{
    $helpers->redirectTo("manage_content.php");
}
