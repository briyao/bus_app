

<?php
/*
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Changes driver_id in “routes” table to new driver
*/
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $host = "localhost";
    $dbname ="busRouteDB";
    $username = "busapp";
    $password = "sql123";
  
    $db_server = mysql_connect($host, $username, $password);
    if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
    mysql_select_db("busRouteDB") or die("Unable to select database: " . mysql_error());
    
    // 1) get driver_id for name
      
    $query_string = "SELECT driver_id FROM drivers WHERE name ='".$_POST["driver_name"]."';";
    
    $query = mysql_query($query_string);
      
    if (gettype(mysql_num_rows($query)) == 'integer') { $number_of_requests = mysql_num_rows($query); } else { $number_of_requests = 0; }
    
    //extract driver_id from results --> $driver_id
    for ($current_row = 0; $current_row < $number_of_requests; $current_row++) {
        $request = mysql_fetch_row($query);
        foreach ($request as $value) { $driver_id= $value; }
    }
    
    // 2) get route num based on route name
      
    $query_string_2 = "SELECT route_num FROM routes WHERE route_name ='".$_POST["route_name"]."';";
    
    $query_2 = mysql_query($query_string_2);
      
    if (gettype(mysql_num_rows($query_2)) == 'integer') { $number_of_requests = mysql_num_rows($query_2); } else { $number_of_requests = 0; }
    
    //extract num from results --> $route_num
    for ($current_row = 0; $current_row < $number_of_requests; $current_row++) {
        $request = mysql_fetch_row($query_2);
        foreach ($request as $value) { $route_num = $value; }
    }
    
    // 3) update routes table with new id
    $query_string_3 = "UPDATE routes SET driver_id = '".$driver_id."' WHERE route_num=".$route_num.";";
    if (mysql_query($query_string_3)) { echo "successfully changed driver"; } else { echo "Error: " . $query_string_3 . "<br>" . mysql_error($db_server); }
    
}
?>