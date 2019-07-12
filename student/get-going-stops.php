<?php
/*
<!--
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Returns array of addresses for students that are going on the bus that day
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
    
    // select address from stops where student is going
    $query_string = "SELECT address FROM stops WHERE stop_id in (SELECT stop_id FROM students WHERE route_num = (SELECT route_num FROM students WHERE student_id = ".$_GET['student_id'].") AND going = 1);";
    $query = mysql_query($query_string);
    
    //display table of search results to user
    $number_of_requests = mysql_num_rows($query);
      
    //array to store addresses in
    $address_arr = array();
  
    for ($current_row = 0; $current_row < $number_of_requests; $current_row++)
    {
    	// walker variable (through rows in the table)
      $request = mysql_fetch_row($query);
      foreach ($request as $value) {
      	array_push($address_arr, $value);
      }
    }
    echo json_encode($address_arr);
}
?>