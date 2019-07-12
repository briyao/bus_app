

<?php
/*
<!--
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Assigns a specified route to a new driver to be used in change driver edit tab
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


    // 1) get driver_id for new driver
    $query_string = "SELECT driver_id FROM drivers WHERE name = '".$_POST["selected_driver"]."';";
    $query = mysql_query($query_string);
    
    if (gettype(mysql_num_rows($query)) == 'integer') {
        $number_of_requests = mysql_num_rows($query);
    } else { $number_of_requests = 0; }
    
    //extract id from results --> $new_driver_id
    for ($current_row = 0; $current_row < $number_of_requests; $current_row++) {
        $request = mysql_fetch_row($query);
        foreach ($request as $value) { $new_driver_id = $value; }
    }
    
    // 2) update routes table
    $query_string = "UPDATE routes SET driver_id=".$new_driver_id." WHERE driver_id=".$_POST["delete_driver_id"];
    if (mysql_query($query_string)) { echo "step 2: update routes successful"; } else { echo "Error: " . $query_string . "<br>" . mysql_error($db_server); }
    
    // 3) delete driver
    $query_string = "DELETE FROM drivers WHERE driver_id = '".$_POST["delete_driver_id"]."';";
    if (mysql_query($query_string)) { echo "step 3: delete driver successful"; } else { echo "Error: " . $query_string . "<br>" . mysql_error($db_server); }
}
?>