<?php

require_once '../vendor/autoload.php';
require_once '../includes/functions/helpers.php';

$loader = new Twig_Loader_Filesystem('../includes/templates');
$twig = new Twig_Environment($loader);

$subjects = getSubjects();

foreach ($subjects as $subject)
{
  $pages[$subject['id']] = getPages($subject['id']);
}


if (isset($_GET['subject'])) {
  $selected_subject_id = $_GET['subject'];
  $selected_page_id = null;
} elseif (isset($_GET['page'])) {
  $selected_subject_id = null;
  $selected_page_id = $_GET['page'];
} else {
  $selected_subject_id = null;
  $selected_page_id = null;
}

$template = $twig->load('manage_content.twig.html');
echo $template->render([
  "subjects" => $subjects, 
  "pages" => $pages,
  "page_id" => $selected_page_id,
  "subject_id" => $selected_subject_id
]);