<?php
require_once ("connectvars.php");
$connection = mysqli_connect(HOST,USER,PASS,DBNAME);
if (!$connection){
    die("Database Connection Failed" . mysqli_error($connection));
}
$select_db = mysqli_select_db($connection, 'test');
if (!$select_db){
    die("Database Selection Failed" . mysqli_error($connection));
}
?>