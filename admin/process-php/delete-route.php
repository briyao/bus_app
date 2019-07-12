

<?php
/*
<!--
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Deletes route from “routes” table, removes all stops from “stops” table, updates “students” table with changes
-->
*/
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //login and connect to mysql
    $host = "localhost";
    $dbname ="busRouteDB";
    $username = "busapp";
    $password = "sql123";
      
    $db_server = mysql_connect($host, $username, $password);
    if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
    mysql_select_db("busRouteDB") or die("Unable to select database: " . mysql_error());
    
    //1) get route num based on route name
    $query_string = "SELECT route_num FROM routes WHERE route_name ='".$_POST["route_name"]."';";
    
    $query = mysql_query($query_string);
      
    if (gettype(mysql_num_rows($query)) == 'integer') { $number_of_requests = mysql_num_rows($query); } else { $number_of_requests = 0; }
    
    //extract num from results --> $route_num
    for ($current_row = 0; $current_row < $number_of_requests; $current_row++) {
        $request = mysql_fetch_row($query);
        foreach ($request as $value) { $route_num = $value; }
    }
      
    // 2) delete from routes table
    $query_string_2 = "DELETE FROM routes WHERE route_num =".$route_num.";";
    if (mysql_query($query_string_2)) { echo "step 2: delete from routes table successful"; } else { echo "Error: " . $query_string_2 . "<br>" . mysql_error($db_server); }
    
    // 3) delete from stops table
    $query_string_3 = "DELETE FROM stops WHERE route_num =".$route_num.";";
    if (mysql_query($query_string_3)) { echo "step 3: delete from stops table successful"; } else { echo "Error: " . $query_string_3 . "<br>" . mysql_error($db_server); }
    
    // 4) update students table to make stop_id and route_num null
    $query_string_4 = "UPDATE students SET stop_id=NULL, route_num=NULL WHERE route_num=".$route_num.";";
    if (mysql_query($query_string_4)) { echo "step 4: update students table successful"; } else { echo "Error: " . $query_string_4 . "<br>" . mysql_error($db_server); }
}
?>