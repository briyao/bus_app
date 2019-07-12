

<?php
/*
<!--
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Returns list of students without a route, formatted as HTML checkboxes
-->
*/
//login and connect to mysql
$host = "localhost";
$dbname ="busRouteDB";
$username = "busapp";
$password = "sql123";

//if cannot connect to mysql, display error message
$db_server = mysql_connect($host, $username, $password);
if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db("busRouteDB") or die("Unable to select database: " . mysql_error());

//select unassigned student names and addresses from students sql table
$sql = "SELECT name, address FROM students WHERE route_num IS NULL;";
$result = mysql_query($sql);
$count = 1;

//create checkbox list of all unassigned students
while ($row = mysql_fetch_array($result)) {
    echo '<div class="form-check">
  <input class="form-check-input" type="checkbox" value="" name="student-checkbox" id="checkbox'.$count.'">
  <label class="form-check-label" for="defaultCheck1">';
    echo $row['name']." | ".$row['address'];
    echo '</label></div>';
    $count = $count + 1;
}

?>