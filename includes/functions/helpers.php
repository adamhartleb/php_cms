<?php

require( dirname(__FILE__) . '/../database/database.php');

function getSubjects ()
{
  $db = new database('widget_corp');
  $query  = "SELECT * ";
  $query .= "FROM subjects ";
  $query .= "WHERE visible = 1 ";
  $query .= "ORDER BY position ASC";
  return $db->returnResults($query);
}

function getPages ($id)
{
  $db = new database('widget_corp');
  $query  = "SELECT * ";
  $query .= "FROM pages ";
  $query .= "WHERE visible = 1 ";
  $query .= "AND subject_id = {$id} ";
  $query .= "ORDER BY position ASC";
  return $db->returnResults($query);
}

function indexSubjectsAndPages ()
{
  $subjects = getSubjects();

  foreach ($subjects as $subject)
  {
    $pages[$subject['id']] = getPages($subject['id']);
  }

  return [$subjects, $pages];
}

function selectedSubjectAndPage ()
{
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

  return [$selected_subject_id, $selected_page_id];
}