<?php

require 'database.php';

$db = new database('widget_corp');

$sql = "CREATE TABLE admins (";
$sql .= "id INT(11) NOT NULL AUTO_INCREMENT, ";
$sql .= "username VARCHAR(50) NOT NULL, ";
$sql .= "hashed_password VARCHAR(60) NOT NULL, ";
$sql .= "PRIMARY KEY (id))";

$db->query($sql);

echo $sql;