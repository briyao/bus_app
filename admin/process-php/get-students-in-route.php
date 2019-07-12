

<?php
/*
<!--
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Returns list of students in route, formatted as HTML checkboxes to be used in remove student edit tab
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
    
    // 1) get route num based on route name
      
    $query_string = "SELECT route_num FROM routes WHERE route_name ='".$_GET["route_name"]."';";
    
    $query = mysql_query($query_string);
      
    if (gettype(mysql_num_rows($query)) == 'integer') { $number_of_requests = mysql_num_rows($query); } else { $number_of_requests = 0; }
    
    //extract num from results --> $route_num
    for ($current_row = 0; $current_row < $number_of_requests; $current_row++) {
        $request = mysql_fetch_row($query);
        foreach ($request as $value) { $route_num = $value; }
    }
    
    // 2) get student id, name, and address based on route num and generate checkbox html
    
    $sql = "SELECT student_id, name, address FROM students WHERE route_num=".$route_num.";";
    $result = mysql_query($sql);
    $count = 1;
    
    while ($row = mysql_fetch_array($result)) {
        echo '<div class="form-check" id="edit-student-remove">
      <input class="form-check-input" type="checkbox" value="" name="student-list-checkbox" id="checkbox'.$count.'">
      <label class="form-check-label" for="defaultCheck1">';
        echo $row['name']." | ".$row['address']." | ".$row['student_id'];
        echo '</label></div>';
        $count = $count + 1;
    }
}
?>