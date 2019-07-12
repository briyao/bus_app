

<?php
/*
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Changes route name in “routes” table to new name
*/
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $host = "localhost";
    $dbname ="busRouteDB";
    $username = "busapp";
    $password = "sql123";
  
    $db_server = mysql_connect($host, $username, $password);
    if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
    mysql_select_db("busRouteDB") or die("Unable to select database: " . mysql_error());
    
    // 2) get route num based on route name
      
    $query_string_2 = "SELECT route_num FROM routes WHERE route_name ='".$_POST["route_name"]."';";
    
    $query_2 = mysql_query($query_string_2);
      
    if (gettype(mysql_num_rows($query_2)) == 'integer') { $number_of_requests = mysql_num_rows($query_2); } else { $number_of_requests = 0; }
    
    //extract num from results --> $route_num
    for ($current_row = 0; $current_row < $number_of_requests; $current_row++) {
        $request = mysql_fetch_row($query_2);
        foreach ($request as $value) { $route_num = $value; }
    }
    
    // 3) check if name already taken
    $query_string = "SELECT route_name FROM routes;";
  
    $query = mysql_query($query_string);
    $number_of_requests = mysql_num_rows($query);
  
    //array to store names in
    $name_arr = array();
    

    for ($current_row = 0; $current_row < $number_of_requests; $current_row++)
    {
  	  // walker variable (through rows in the table)
      $request = mysql_fetch_row($query);
      foreach ($request as $value) {
    	  array_push($name_arr, $value);
      }
    }
    
    //if in array, alert user
    if ( in_array($_POST['new_name'],$name_arr) ) {
        echo 'Error: That name has already been taken. Please enter a new name.';
    } else {
        
        // update routes table with new id
        $query_string_3 = "UPDATE routes SET route_name = '".$_POST['new_name']."' WHERE route_name='".$_POST['route_name']."';";
        if (mysql_query($query_string_3)) { echo "Name has successfully been changed."; } else { echo "Error: " . $query_string_3 . "<br>" . mysql_error($db_server); }
        
    }
    
}
?>