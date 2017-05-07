<?php

require_once '../vendor/autoload.php';
require_once '../includes/functions/helpers.php';

$helpers = new helpers();

$loader = new Twig_Loader_Filesystem('../includes/templates');
$twig = new Twig_Environment($loader);
$template = $twig->load('manage_admins.twig.html');

$vars = $helpers->subjectsAndPages();

echo $template->render($vars);