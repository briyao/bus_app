<?php
/*
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Fetches driver’s route number from “routes” table given driver_id
*/

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    //login and connect to mysql
    //require_once '.../login.php';
    $host = "localhost";
    $dbname ="busRouteDB";
    $username = "busapp";
    $password = "sql123";

    $db_server = mysql_connect($host, $username, $password);
    if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
        mysql_select_db("busRouteDB") or die("Unable to select database: " . mysql_error());
    
    // 1) select route_num from routes where driver_id = 
    $query_string = "SELECT route_num FROM routes WHERE driver_id =".$_GET["driver_id"].";";
    $query = mysql_query($query_string);
    
    if (gettype(mysql_num_rows($query)) == 'integer') { $number_of_requests = mysql_num_rows($query); } else { $number_of_requests = 0; }
    
    //extract id from results
    for ($current_row = 0; $current_row < $number_of_requests; $current_row++)
    {
        $request = mysql_fetch_row($query);
        foreach ($request as $value) {
          $route_num = $value;
        }
    }
    
    echo $route_num;
}
?>