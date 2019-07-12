

<?php
/*
<!--
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Returns array of students at stop to be used in displaying route info
-->
*/
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  //login and connect to mysql
  $host = "localhost";
  $dbname ="busRouteDB";
  $username = "busapp";
  $password = "sql123";
  
  //if cannot connect to mysql, display error message
  $db_server = mysql_connect($host, $username, $password);
  if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
  mysql_select_db("busRouteDB") or die("Unable to select database: " . mysql_error());
  
  //select all names of students using route_name
  $query_string = "SELECT name FROM students WHERE stop_id IN (SELECT stop_id FROM stops WHERE address='".$_GET["address"]."' AND route_num IN (SELECT route_num FROM routes WHERE route_name='".$_GET['route_name']."'));";
  $query = mysql_query($query_string);
  
  //display table of search results to user
  $number_of_requests = mysql_num_rows($query);
  
  //array to store addresses in
  $student_arr = array();

  for ($current_row = 0; $current_row < $number_of_requests; $current_row++)
  {
  	// walker variable (through rows in the table)
    $request = mysql_fetch_row($query);
    foreach ($request as $value) {
    	array_push($student_arr, $value);
    }
  }
  
  //send back array of students at stop
  echo json_encode($student_arr);
}
?>