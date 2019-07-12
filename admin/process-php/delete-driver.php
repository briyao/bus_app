

<?php
/*
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Deletes specified driver, determines if driver has route and needs to be replaced
*/
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $host = "localhost";
    $dbname ="busRouteDB";
    $username = "busapp";
    $password = "sql123";
  
    $db_server = mysql_connect($host, $username, $password);
    if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
    mysql_select_db("busRouteDB") or die("Unable to select database: " . mysql_error());
    
    // 1) check if driver doesn't have route --> then just delete
    $query_string = "SELECT * FROM routes WHERE driver_id = '".$_POST["driver_id"]."';";
    
    $query = mysql_query($query_string);
    
    if (gettype(mysql_num_rows($query)) == 'integer')
    {
      $number_of_requests = mysql_num_rows($query);
    } else {
      $number_of_requests = 0;
    }
    
    if ($number_of_requests == 0) {
        $query_string_2 = "DELETE FROM drivers WHERE driver_id = '".$_POST["driver_id"]."';";
        
        if (mysql_query($query_string_2)) {
            echo "successful";
        } else {
            echo "Error: " . $query_string . "<br>" . mysql_error($db_server);
        }
    } else {
        echo 'change driver';
    }
    
    mysql_close($db_server);
}
?>