<?php
session_start();
require_once '../vendor/autoload.php';
require_once '../includes/functions/helpers.php';

$helpers = new helpers();

if (isset($_POST['username']) && isset($_POST['password']))
{
  $username = $_POST['username'];
  $password = $_POST['password'];

  $helpers->insertAdmin($username, $password);
  
  $_SESSION['message'] = $helpers->db->affected_rows > 0 
    ? "Admin successfully created"
    : "Admin creation failed";

  $helpers->redirectTo('admin.php');
}