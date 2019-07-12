

<?php
/*
<!--
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Handles creation of new route (adds new route to “routes” table, assigns a driver, 
adds stops to “stops” table, sets stop_id’s in “students” table)
-->
*/
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //login and connect to mysql
    $host = "localhost";
    $dbname ="busRouteDB";
    $username = "busapp";
    $password = "sql123";

    //if cannot connect to mysql, display error message
    $db_server = mysql_connect($host, $username, $password);
    if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
    mysql_select_db("busRouteDB") or die("Unable to select database: " . mysql_error());
    
    // 1) get driver id
    $query_string = "SELECT driver_id FROM drivers WHERE name = '".$_POST["driver_name"]."';";
  
    $query = mysql_query($query_string);
  
    if (gettype(mysql_num_rows($query)) == 'integer') {
        $number_of_requests = mysql_num_rows($query);
    } else { $number_of_requests = 0; }

    //extract id from results
    for ($current_row = 0; $current_row < $number_of_requests; $current_row++) {
        $request = mysql_fetch_row($query);
        foreach ($request as $value) { $driver_id = $value; }
    }
    
    // 2) generate new route (create route id, add driver)
    $query_string_2 = "INSERT INTO routes (driver_id) VALUES ('".$driver_id."');";
    
    if (mysql_query($query_string_2)) {
        echo "step 2: new entry in routes successful";
    } else {
        echo "Error: " . $query_string . "<br>" . mysql_error($db_server);
    }
    
    // 3) get route num
    $query_string_3 = "SELECT route_num FROM routes WHERE driver_id = '".$driver_id."';";
  
    $query = mysql_query($query_string_3);
  
    if (gettype(mysql_num_rows($query)) == 'integer') {
        $number_of_requests = mysql_num_rows($query);
    } else { $number_of_requests = 0; }

    //extract id from results
    for ($current_row = 0; $current_row < $number_of_requests; $current_row++) {
        $request = mysql_fetch_row($query);
        foreach ($request as $value) { $route_num = $value; }
    }
    
    // 4) set route name to default
    $route_name = "Route ".$route_num;
    $query_string_name = "UPDATE routes SET route_name='".$route_name."' WHERE route_num=".$route_num.";";
    if (mysql_query($query_string_name)) { echo "step 2.75: added name successful"; } else { echo "Error: " . $query_string_name . "<br>" . mysql_error($db_server); }
    
    foreach ($_POST["stud_add_list"] as $temp_list) {
        // 5) add stops to stops table with new route num
        $query_string_4 = "INSERT INTO stops (address, route_num, stop_time) VALUES ('".$temp_list['address']."', '".$route_num."', '".$temp_list['stop_time']."');";
        if (mysql_query($query_string_4)) { echo "step 3: added stop successful"; } else { echo "Error: " . $query_string_4 . "<br>" . mysql_error($db_server); }
        - 
        // 6) get stop_id for current entry
        $query_string_5 = "SELECT stop_id FROM stops WHERE address = '".$temp_list['address']."' AND route_num = ".$route_num.";";
        $query_5 = mysql_query($query_string_5);
        echo $query_string_5;

        if (gettype(mysql_num_rows($query_5)) == 'integer') {
            $number_of_requests = mysql_num_rows($query_5);
        } else { $number_of_requests = 0; }
    
        //extract id from results --> $current_stop_id
        for ($current_row = 0; $current_row < $number_of_requests; $current_row++) {
            $request = mysql_fetch_row($query_5);
            foreach ($request as $value) { $current_stop_id = $value; }
        }
        
        // 7) update route num and stop id in students table
        $query_string_6 = "UPDATE students SET stop_id=".$current_stop_id.", route_num=".$route_num. ", going = 1 WHERE name='".$temp_list['name']."' AND address='".$temp_list['address']."';";
        if (mysql_query($query_string_6)) { echo "step 5: updated students table successful"; } else { echo "Error: " . $query_string_6 . "<br>" . mysql_error($db_server); }
    }
    
}
?>