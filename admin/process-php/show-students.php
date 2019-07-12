

<?php
/*
<!--
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Returns table of all students and login info (username and password) for student list page
-->
*/
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  //login and connect to mysql
  require_once '../login.php';
  
  $db_server = mysql_connect($host, $username, $password);
  if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
  mysql_select_db("busRouteDB") or die("Unable to select database: " . mysql_error());
  
  //store query
  $query_string = "SELECT a.student_id, a.name, a.address, a.username, b.real_password, a.route_num FROM students a, studentpws b WHERE a.student_id = b.student_id;";
  
  $query = mysql_query($query_string);
  
  //display table of search results to user
  $number_of_requests = mysql_num_rows($query);
	echo '<table id = "products" class="sortable table table-striped">';
  echo '<tr> <th>student_id</th> <th>name</th> <th>address</th> <th>username</th> <th>password</th> <th>route num</th> <th></th></tr>';

  for ($current_row = 0; $current_row < $number_of_requests; $current_row++)
  {
  	// walker variable (through rows in the table)
    $request = mysql_fetch_row($query);
    echo '<tr>';
    foreach ($request as $value) {
    	echo '<td>' . $value . '</td>';
    }
    echo '<td>'.'<button type="button" class="delete-student-btn btn btn-secondary">delete</button>'.'</td>';
  	echo'</tr>';
  }
  echo '</table>';
  
}
?>