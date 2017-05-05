<?php

require_once dirname(__FILE__) . '/../database/database.php';

class helpers {
    function __construct ()
    {
        $this->db = new database('test');
    }

    function getSubjects ()
    {
        $query  = "SELECT * ";
        $query .= "FROM subjects ";
        $query .= "WHERE visible = 1 ";
        $query .= "ORDER BY position ASC";
        return $this->db->returnResultsIndexed($query, 'id');
    }

    function getPages ($id)
    {
        $query  = "SELECT * ";
        $query .= "FROM pages ";
        $query .= "WHERE visible = 1 ";
        $query .= "AND subject_id = {$id} ";
        $query .= "ORDER BY position ASC";
        return $this->db->returnResultsIndexed($query, 'id');
    }

    function insertSubject ($menu_name, $position, $visible)
    {
        $query  = "INSERT INTO subjects (";
        $query .= "menu_name, position, visible";
        $query .= ") VALUES (";
        $query .= "'{$menu_name}', {$position}, {$visible}";
        $query .= ")";
        return $this->db->query($query, $menu_name, $position, $visible);
    }

    function subjectsAndPages ()
    {
        $subjects = $this->getSubjects();

        foreach ($subjects as $subject)
        {
            $pages[$subject['id']] = $this->getPages($subject['id']);
        }

        return [ "subjects" => $subjects, "pages" => $pages];
    }

    function selectedSubjectAndPage ()
    {
        return [ "subject_id" => $_GET['subject'], "page_id" => $_GET['page']];
    }

    function prettyPrint ($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

    function redirectTo ($location)
    {
        header("Location:" . $location);
        exit;
    }
}