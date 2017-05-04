<?php

require_once '../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('../includes/templates');
$twig = new Twig_Environment($loader);

$template = $twig->load('admin.twig.html');
echo $template->render();

