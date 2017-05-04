<?php

require_once '../vendor/autoload.php';
require_once '../includes/functions/helpers.php';

$loader = new Twig_Loader_Filesystem('../includes/templates');
$twig = new Twig_Environment($loader);
$template = $twig->load('manage_content.twig.html');

$subjectAndPages = indexSubjectsAndPages();
$selectedSubjectAndPage = selectedSubjectAndPage();

echo $template->render([
  "subjects" => $subjectAndPages[0], 
  "pages" => $subjectAndPages[1],
  "subject_id" => $selectedSubjectAndPage[0],
  "page_id" => $selectedSubjectAndPage[1]
]);