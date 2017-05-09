<?php

require_once '../includes/functions/helpers.php';

$helpers = new helpers();

setcookie("admin_id", "true", time() - 7200);

$helpers->redirectTo('admin_login.php');


