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