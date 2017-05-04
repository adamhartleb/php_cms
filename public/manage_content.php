<?php

require_once '../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('../includes/templates');
$twig = new Twig_Environment($loader);

$template = $twig->load('manage_content.twig.html');
echo $template->render();