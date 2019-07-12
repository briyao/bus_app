

<?php
/*
<!--
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Removes student from a route, deletes stop if they are the only one at that stop
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
    
    // 1) get where condition
    $condition_array = "(";
    $count = 0;
    
    while ($count < count($_POST['selected_students'])) {
        $condition_array .= "'".$_POST['selected_students'][$count]."'";
        if ($count != count($_POST['selected_students']) - 1) {
            $condition_array .= ", ";
        }
        $count = $count + 1;
    }
    $condition_array .= ")";

    // 2) get stop_id of selected students
    $sql = "SELECT stop_id FROM students WHERE student_id IN ".$condition_array.";";
    $result = mysql_query($sql);
    $count = 1;
    
    $remove_stop_ids = array();
    
    while ($row = mysql_fetch_array($result)) {
        array_push($remove_stop_ids, $row['stop_id']);
        $count = $count + 1;
    }
    
    // 3) find # of students with stop_id
    foreach($remove_stop_ids as $stop_id) {
        $query_string = "SELECT * FROM students WHERE stop_id=".$stop_id.";";
        $query = mysql_query($query_string);
        
        //delete stops row only if 1 student in stop
        if (mysql_num_rows($query) == 1) {
            $query_string_2 = "DELETE FROM stops WHERE stop_id=".$stop_id.";";
            if (mysql_query($query_string_2)) { echo "step 2: update routes successful"; } else { echo "Error: " . $query_string_2 . "<br>" . mysql_error($db_server); }
        }
    } 
    
    // 4) update students table
    $query_string = "UPDATE students SET route_num=NULL, stop_id=NULL WHERE student_id IN ".$condition_array.";";
    if (mysql_query($query_string)) { echo "step 4: update students successful"; } else { echo "Error: " . $query_string . "<br>" . mysql_error($db_server); }

    
    }
?>