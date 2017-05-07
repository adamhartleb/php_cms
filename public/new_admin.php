<?php

require_once '../vendor/autoload.php';
require_once '../includes/functions/helpers.php';

$helpers = new helpers();

if (isset($_POST['username']) && isset($_POST['password']))
{
  $username = $_POST['username'];
  $password = $_POST['password'];

  $helpers->insertAdmin($username, $password);
}