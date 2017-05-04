<?php

require_once '../vendor/autoload.php';
require_once '../includes/functions/helpers.php';

$loader = new Twig_Loader_Filesystem('../includes/templates');
$twig = new Twig_Environment($loader);

$template = $twig->load('index.twig.html');
echo $template->render();