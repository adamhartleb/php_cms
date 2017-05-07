<?php

require_once dirname(__FILE__) . '/../database/database.php';

class helpers {
    function __construct ()
    {
        $this->db = new database('widget_corp');
    }

    function getSubjects ($admin = true)
    {
        $query  = "SELECT * ";
        $query .= "FROM subjects ";
        if (!$admin)
        {
            $query .= "WHERE visible = 1 ";
        }
        $query .= "ORDER BY position ASC";
        return $this->db->returnResultsIndexed($query, 'id');
    }

    function getPages ($id, $admin = true)
    {
        $query  = "SELECT * ";
        $query .= "FROM pages ";
        if (!$admin)
        {
            $query .= "WHERE visible = 1 ";
            $query .= "AND subject_id = {$id} ";
        }
        else
        {
            $query .= "WHERE subject_id = {$id} ";
        }
        $query .= "ORDER BY position ASC";
        return $this->db->returnResultsIndexed($query, 'id');
    }

    function getAdmins ()
    {
        $query = "SELECT * FROM ADMINS";
        return $this->db->returnResultsIndexed($query, 'username');
    }

    function getAdmin ($id)
    {
        $query = "SELECT username FROM ADMINS WHERE id = {$id}";
        return $this->db->query($query)->fetch_assoc();
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

    function insertPage ($menu_name, $position, $visible, $content, $subjectID)
    {
        $query  = "INSERT INTO pages (";
        $query .= "menu_name, subject_id, position, visible, content";
        $query .= ") VALUES (";
        $query .= "'{$menu_name}', {$subjectID}, {$position}, {$visible}, '{$content}'";
        $query .= ")";
        return $this->db->query($query, $menu_name, $subjectID, $position, $visible, $content);
    }

    function insertAdmin ($username, $password)
    {
        $hashed_password = password_hash($password, 1);

        $query  = "INSERT INTO admins (";
        $query .= "username, hashed_password";
        $query .= ") VALUES (";
        $query .= "'{$username}', '{$hashed_password}'";
        $query .= ");";
        return $this->db->query($query, $username, $hashed_password);
    }

    function updateSubject ($id, $menu_name, $position, $visible)
    {
		$query  = "UPDATE subjects SET ";
		$query .= "menu_name = '{$menu_name}', ";
		$query .= "position = {$position}, ";
		$query .= "visible = {$visible} ";
		$query .= "WHERE id = {$id} ";
		$query .= "LIMIT 1";
        return $this->db->query($query, $id, $menu_name, $position, $visible);
    }

    function updatePage ($id, $menu_name, $position, $visible, $content)
    {
		$query  = "UPDATE pages SET ";
		$query .= "menu_name = '{$menu_name}', ";
        $query .= "content = '{$content}', ";
		$query .= "position = {$position}, ";
		$query .= "visible = {$visible} ";
		$query .= "WHERE id = {$id} ";
		$query .= "LIMIT 1";
        return $this->db->query($query, $id, $content, $menu_name, $position, $visible);
    }

    function updateAdmin ($id, $username, $password)
    {
        $hashed_password = password_hash($password, 1);

        $query = "UPDATE admins SET ";
        $query .= "username = '{$username}', ";
        $query .= "hashed_password = '{$hashed_password}' ";
        $query .= "WHERE id = {$id} ";
        $query .= "LIMIT 1";
        return $this->db->query($query, $id, $username, $hashed_password);
    }

    function deleteSubject ($id)
    {
        $query = "DELETE FROM subjects WHERE id = {$id} LIMIT 1";
        return $this->db->query($query);
    }

    function deletePage ($id)
    {
        $query = "DELETE FROM pages WHERE id = {$id} LIMIT 1";
        return $this->db->query($query);
    }

    function deleteAdmin ($id)
    {
        $query = "DELETE FROM admins WHERE id = {$id} LIMIT 1";
        return $this->db->query($query);
    }

    function subjectPagesExist ($id)
    {
        $query  = "SELECT * ";
        $query .= "FROM pages ";
        $query .= "WHERE subject_id = {$id} ";
        return $this->db->query($query);
    }

    function subjectsAndPages ($admin = true)
    {
        $subjects = $this->getSubjects($admin);

        foreach ($subjects as $subject)
        {
            $pages[$subject['id']] = $this->getPages($subject['id'], $admin);
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