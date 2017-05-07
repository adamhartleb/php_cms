<?php

require_once '../includes/functions/helpers.php';

$helpers = new helpers();

$helpers->checkLogin($_COOKIE['admin_id']);

if (isset($_GET['admin']) && $_GET['admin'] !== "")
{
    $result = $helpers->deleteAdmin($_GET['admin']);
}

$helpers->redirectTo("manage_admins.php");