<?php
session_start();
require_once '../vendor/autoload.php';
require_once '../includes/functions/helpers.php';
require_once '../includes/functions/validation.php';

$helpers = new helpers();
$validation = new validation();

$helpers->checkLogin($_COOKIE['admin_id']);

if (isset($_POST['username']) && isset($_POST['password']))
{
  $username = $_POST["username"];
  $password = $_POST["password"];
  $verify_password = $_POST["verify_password"];

  $required_fields = ["username", "password", "verify_password"];
  $validation->validate_presences($required_fields);

  if (!empty($validation->errors))
  {
    $_SESSION["errors"] = $validation->errors;
    $helpers->redirectTo("create_admin.php");
  }

  if ($password !== $verify_password)
  {
    $_SESSION["errors"] = ["Passwords" => "Passwords must match"];
    $helpers->redirectTo("create_admin.php");
  }

  $helpers->insertAdmin($username, $password);
    
  $_SESSION['message'] = $helpers->db->affected_rows > 0 
    ? "Admin successfully created"
    : "Admin creation failed";

  $helpers->redirectTo('manage_admins.php');
}