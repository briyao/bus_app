

<?php
/*
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Adds the student’s stop to “stops” table, updates their stop_id in “students” table
*/
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $host = "localhost";
    $dbname ="busRouteDB";
    $username = "busapp";
    $password = "sql123";
  
    $db_server = mysql_connect($host, $username, $password);
    if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
    mysql_select_db("busRouteDB") or die("Unable to select database: " . mysql_error());


    // 1) get route_num for selected route
    $query_string2 = "SELECT route_num FROM routes WHERE route_name ='".$_POST["route_name"]."';";
    
    $query2 = mysql_query($query_string2);
      
    if (gettype(mysql_num_rows($query2)) == 'integer') { $number_of_requests = mysql_num_rows($query2); } else { $number_of_requests = 0; }
    
    //extract route num from results --> $route_num
    for ($current_row = 0; $current_row < $number_of_requests; $current_row++) {
        $request = mysql_fetch_row($query2);
        foreach ($request as $value) { $route_num = $value; }
    }
    echo "test";
    echo $route_num;
    
    foreach ($_POST[selected_addresses] as $address) {
        // 2) add new stop
        $query_string = "INSERT INTO stops (address, route_num) VALUES ('".$address."', ".$route_num.");";
        if (mysql_query($query_string)) { echo "step 2: add new stop successful"; } else { echo "Error: " . $query_string . "<br>" . mysql_error($db_server); }
        echo $query_string;
        
        // 3) get stop_id --> $new_stop_id
        $query_string2 = "SELECT stop_id FROM stops WHERE address='".$address."';";
        echo $query_string2;
        $query2 = mysql_query($query_string2);
      
        if (gettype(mysql_num_rows($query2)) == 'integer') { $number_of_requests = mysql_num_rows($query2); } else { $number_of_requests = 0; }
        
        //extract stop id from results --> $new_stop_id
        for ($current_row = 0; $current_row < $number_of_requests; $current_row++) {
            $request = mysql_fetch_row($query2);
            foreach ($request as $value) { $new_stop_id = $value; }
        }
        
        // 4) update students with stop_id
        $query_string = "UPDATE students SET stop_id=".$new_stop_id.", route_num=".$route_num." WHERE address='".$address."';";
        if (mysql_query($query_string)) { echo "step 4: update students successful"; } else { echo "Error: " . $query_string . "<br>" . mysql_error($db_server); }
        echo $query_string;
    }
    
    }
?>