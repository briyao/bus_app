

<?php
/*
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Deletes students’ old stops and inserts new stop in “stops” table, changes students’ stop_id in “stops” table
*/
echo $_POST['new_address'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo $_POST['selected_addresses'];
    echo $_POST['route_name'];
    
    $host = "localhost";
    $dbname ="busRouteDB";
    $username = "busapp";
    $password = "sql123";
    
    $db_server = mysql_connect($host, $username, $password);
    if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
    mysql_select_db("busRouteDB") or die("Unable to select database: " . mysql_error());
    
    // 1) get route num based on route name
      
    $query_string = "SELECT route_num FROM routes WHERE route_name ='".$_POST["route_name"]."';";
    
    $query = mysql_query($query_string);
      
    if (gettype(mysql_num_rows($query)) == 'integer') { $number_of_requests = mysql_num_rows($query); } else { $number_of_requests = 0; }
    
    //extract num from results --> $route_num
    for ($current_row = 0; $current_row < $number_of_requests; $current_row++) {
        $request = mysql_fetch_row($query);
        foreach ($request as $value) { $route_num = $value; }
    }
    
    // 2) get address_arr (list) and old_stop_ids (list)
    
    $sql = "SELECT address, stop_id FROM stops WHERE route_num=".$route_num.";";
    $result = mysql_query($sql);
    $count = 1;
    
    $address_arr = array();
    $old_stop_ids = array();
    
    echo "step 2!!!!!!";
    while ($row = mysql_fetch_array($result)) {
        array_push($address_arr, $row['address']);
        array_push($old_stop_ids, $row['stop_id']);
        $count = $count + 1;
    }
    
    // 3) get delete_stop_arr (list) --> list of stop ids of addresses to combine
    echo "step 3!!!!!!";
    //get () array for WHERE condition
    $condition_array = "(";
    $count = 0;
    
    while ($count < count($_POST['selected_addresses'])) {
        $condition_array .= "'".$_POST['selected_addresses'][$count]."'";
        if ($count != count($_POST['selected_addresses']) - 1) {
            $condition_array .= ", ";
        }
        $count = $count + 1;
    }
    $condition_array .= ")";
    
    //get sql results and store in array
    $sql = "SELECT stop_id FROM stops WHERE address IN ".$condition_array.";";
    echo $sql;
    
    $result = mysql_query($sql);
    $count = 1;
    
    $delete_stop_arr = array();
    
    while ($row = mysql_fetch_array($result)) {
        array_push($delete_stop_arr, $row['stop_id']);
        $count = $count + 1;
    }
    
    // 4) delete from stops table where stop_id in delete_stop_arr
    //get () array for WHERE condition
    $condition_array = "(";
    $count = 0;
    
    while ($count < count($delete_stop_arr)) {
        $condition_array .= $delete_stop_arr[$count];
        if ($count != count($delete_stop_arr) - 1) {
            $condition_array .= ", ";
        }
        $count = $count + 1;
    }
    $condition_array .= ")";
    
    $query_string_4 = "DELETE FROM stops WHERE stop_id IN ".$condition_array.";";
    
    if (mysql_query($query_string_4)) { echo "step 4: deleted from stops successful"; } else { echo "Error: " . $query_string_4 . "<br>" . mysql_error($db_server); }
    
    // 5) insert new address
    $query_string_5 = "INSERT INTO stops (address, route_num) VALUES ('".$_POST['new_address']."', '".$route_num."');";
    
    if (mysql_query($query_string_5)) { echo "step 5: insert new stop successful"; } else { echo "Error: " . $query_string_5 . "<br>" . mysql_error($db_server); }
    
    
    // 6) get stop id of new combine stop
    $query_string_6 = "SELECT stop_id FROM stops WHERE address ='".$_POST['new_address']."' AND route_num=".$route_num.";";
    
    $query_6 = mysql_query($query_string_6);
      
    if (gettype(mysql_num_rows($query_6)) == 'integer') { $number_of_requests = mysql_num_rows($query_6); } else { $number_of_requests = 0; }
    
    //extract stop_id from results --> $combined_stop_id
    for ($current_row = 0; $current_row < $number_of_requests; $current_row++) {
        $request = mysql_fetch_row($query_6);
        foreach ($request as $value) { $combined_stop_id = $value; }
    }
    
    // 7) update stop_id in students table
    $query_string_7 = "UPDATE students SET stop_id=".$combined_stop_id." WHERE stop_id IN ".$condition_array.";";
    if (mysql_query($query_string_7)) { echo "step 7: updated students successful"; } else { echo "Error: " . $query_string_7 . "<br>" . mysql_error($db_server); }

}

?>