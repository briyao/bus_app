

<?php
/*
<!--
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Deletes student (and their stop if they’re the only one at the stop), deletes login info (username and password)
-->
*/
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $host = "localhost";
    $dbname ="busRouteDB";
    $username = "busapp";
    $password = "sql123";
  
    $db_server = mysql_connect($host, $username, $password);
    if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
    mysql_select_db("busRouteDB") or die("Unable to select database: " . mysql_error());
    
    // check if has a route
    $query_string = "SELECT stop_id FROM students WHERE student_id=".$_POST["student_id"].";";
    $query = mysql_query($query_string);
    
    if (gettype(mysql_num_rows($query)) == 'integer') {
        $number_of_requests = mysql_num_rows($query);
    } else { $number_of_requests = 0; }
    
    if ($number_of_requests != 0) {
        //extract id from results --> $current_stop_id
        for ($current_row = 0; $current_row < $number_of_requests; $current_row++) {
            $request = mysql_fetch_row($query);
            foreach ($request as $value) { $stop_id = $value; }
        }
        
        //check if only student at stop
        $query_string_2 = "SELECT * FROM students WHERE stop_id=".$stop_id.";";
        $query_2 = mysql_query($query_string_2);
        
        //delete stops row only if 1 student in stop
        if (mysql_num_rows($query_2) == 1) {
            $query_string_3 = "DELETE FROM stops WHERE stop_id=".$stop_id.";";
            if (mysql_query($query_string_3)) { echo "step 2: update routes successful"; } else { echo "Error: " . $query_string_3 . "<br>" . mysql_error($db_server); }
        }
    }
    
    // 1) delete from students table
    $query_string = "DELETE FROM students WHERE student_id = '".$_POST["student_id"]."';";
    
    if (mysql_query($query_string)) {
        echo "successful";
    } else {
        echo "Error: " . $query_string . "<br>" . mysql_error($db_server);
    }
    
    // 2) delete from pw table
    $query_string = "DELETE FROM studentpws WHERE student_id = '".$_POST["student_id"]."';";
    
    if (mysql_query($query_string)) {
        echo "successful";
    } else {
        echo "Error: " . $query_string . "<br>" . mysql_error($db_server);
    }
}
?>