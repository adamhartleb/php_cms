<?php
session_start();
require_once '../vendor/autoload.php';
require_once '../includes/functions/helpers.php';
require_once '../includes/functions/validation.php';

$helpers = new helpers();
$validation = new validation();

$helpers->checkLogin($_COOKIE['admin_id']);

$loader = new Twig_Loader_Filesystem('../includes/templates');
$twig = new Twig_Environment($loader);
$template = $twig->load('edit_admin.twig.html');

if (isset($_POST['submit']))
{
  $id = $_GET["admin"];
  $username = $_POST["username"];
  $password = $_POST["password"];
  $verify_password = $_POST["verify_password"];

  $required_fields = ["username", "password", "verify_password"];
  $validation->validate_presences($required_fields);

  if (!empty($validation->errors))
  {
    $_SESSION["errors"] = $validation->errors;
    $helpers->redirectTo("edit_admin.php?admin={$_GET['admin']}");
  }

  if ($password !== $verify_password)
  {
    $_SESSION["errors"] = ["Passwords" => "Passwords must match"];
    $helpers->redirectTo("edit_admin.php?admin={$_GET['admin']}");
  }

  $helpers->updateAdmin($id, $username, $password);
    
  $_SESSION['message'] = $helpers->db->affected_rows > 0 
    ? "Admin successfully edited"
    : "Admin edit failed";

  $helpers->redirectTo('manage_admins.php');
  
}
else
{
  
  $vars = $helpers->subjectsAndPages();
  $vars += $helpers->getAdmin($_GET['admin']);
  $vars += [ "id" => $_GET['admin'] ];
  $vars += [ "errors" => $_SESSION['errors']];

  echo $template->render($vars);

  $_SESSION['errors'] = null;
}

