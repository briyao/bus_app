<?php
/*
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Adds feedback to “feedback” table
*/
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $host = "localhost";
    $dbname ="busRouteDB";
    $username = "busapp";
    $password = "sql123";
  
    $db_server = mysql_connect($host, $username, $password);
    if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
    mysql_select_db("busRouteDB") or die("Unable to select database: " . mysql_error());

    // Add fname, lname, email and comment to feedback table
    $query_string = "INSERT INTO feedback (fname, lname, email, comment) VALUES ('".$_POST['fname']."', '".$_POST['lname']."', '".$_POST['email']."', '".$_POST['comment']."')";
    $query = mysql_query($query_string);
    
    if ($query) {
        echo "successful";
    } else {
        echo "Error: " . $query_string . "<br>" . mysql_error($db_server);
    }
}
?>