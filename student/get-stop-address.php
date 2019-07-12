<?php
/*
<!--
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Returns student’s stop address from “students” table to display in stop info card
-->
*/
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

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
    
    //get stop address that corresponds to student id
    $query_string = "SELECT address FROM stops WHERE stop_id IN (SELECT stop_id FROM students WHERE student_id=".$_GET["student_id"].");";
    $query = mysql_query($query_string);
    
    if (gettype(mysql_num_rows($query)) == 'integer') { $number_of_requests = mysql_num_rows($query); } else { $number_of_requests = 0; }
    
    //extract id from results
    for ($current_row = 0; $current_row < $number_of_requests; $current_row++)
    {
        $request = mysql_fetch_row($query);
        foreach ($request as $value) {
          $address = $value;
        }
    }
    
    //return stop address
    echo $address;
}
?>