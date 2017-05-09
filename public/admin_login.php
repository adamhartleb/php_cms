<?php
session_start();
require_once '../vendor/autoload.php';
require_once '../includes/functions/helpers.php';
require_once '../includes/functions/validation.php';

$loader = new Twig_Loader_Filesystem('../includes/templates');
$twig = new Twig_Environment($loader);
$template = $twig->load('admin_login.twig.html');

$helpers = new helpers();
$validation = new validation();

if (isset($_POST['submit']))
{
  $username = $_POST["username"];
  $password = $_POST["password"];

  $required_fields = ["username", "password"];
  $validation->validate_presences($required_fields);

  if (!empty($validation->errors))
  {
      $_SESSION["errors"] = $validation->errors;
      $helpers->redirectTo("admin_login.php");
  }

  $result = $helpers->attemptLogin($username, $password);

  if ($result)
  {
    setcookie("admin_id", "true");
    $helpers->redirectTo("admin.php");
  }
  else
  {
    $_SESSION["errors"] = ["Login Failed" => "Login Failed"];
    $helpers->redirectTo("admin_login.php");
  }

}

$vars = $helpers->subjectsAndPages(false);
$vars += [ "errors" => $_SESSION['errors'] ];

echo $template->render($vars);

$_SESSION["errors"] = null;