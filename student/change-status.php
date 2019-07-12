<?php
/*
<!--
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Updates status in “students” table, sets to “going” if currently “not going” and “not going” if currently “going”
-->
*/
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //login and connect to mysql
    //require_once '.../login.php';
    $host = "localhost";
    $dbname ="busRouteDB";
    $username = "busapp";
    $password = "sql123";

    //if cannot connect to mysql, display error message
    $db_server = mysql_connect($host, $username, $password);
    if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
        mysql_select_db("busRouteDB") or die("Unable to select database: " . mysql_error());
    
    //change status in mysql table
    if ($_POST['status'] == "going") {
        $query_string = "UPDATE students SET going=0 WHERE student_id=".$_POST['student_id'].";";
    } else {
        $query_string = "UPDATE students SET going=1 WHERE student_id=".$_POST['student_id'].";";
    }
    
    //echo result back to javascript
    if (mysql_query($query_string)) { echo "changed status successful"; } else { echo "Error: " . $query_string . "<br>" . mysql_error($db_server); }

}
?>