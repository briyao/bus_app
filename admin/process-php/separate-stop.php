

<?php
/*
<!--
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Separates a combined stop, deletes combined stop and adds student addresses as new stops to “stops” table
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
    
    // 1) get route num based on route name
      
    $query_string = "SELECT route_num FROM routes WHERE route_name ='".$_POST["route_name"]."';";
    
    $query = mysql_query($query_string);
      
    if (gettype(mysql_num_rows($query)) == 'integer') { $number_of_requests = mysql_num_rows($query); } else { $number_of_requests = 0; }
    
    //extract num from results --> $route_num
    for ($current_row = 0; $current_row < $number_of_requests; $current_row++) {
        $request = mysql_fetch_row($query);
        foreach ($request as $value) { $route_num = $value; }
    }
    echo $route_num;
    
    // 2) get stop_id of deleted stop
    
    echo $_POST["selected_radio"];
    $query_string_2 = "SELECT stop_id FROM stops WHERE address ='".$_POST["selected_radio"]."';";
    echo $query_string_2;
    
    $query_2 = mysql_query($query_string_2);
    echo mysql_num_rows($query_2);
      
    if (gettype(mysql_num_rows($query_2)) == 'integer') { $number_of_requests = mysql_num_rows($query_2); } else { $number_of_requests = 0; }
    
    //extract stop_id from results --> $del_stop_id
    for ($current_row = 0; $current_row < $number_of_requests; $current_row++) {
        $request = mysql_fetch_row($query_2);
        foreach ($request as $value) { $del_stop_id = $value; }
    }
    echo $del_stop_id;
    
    // 3) get address_arr (list) and old_stop_ids (list)
    
    $sql = "SELECT address FROM students WHERE stop_id=".$del_stop_id.";";
    $result = mysql_query($sql);
    $count = 1;
    
    $sep_stud_arr = array();
    
    while ($row = mysql_fetch_array($result)) {
        array_push($sep_stud_arr, $row['address']);
        echo $row['address'];
        $count = $count + 1;
    }
    
    echo "sep_stud_arr populated";
    
    // 4) delete from stops table where stop_id in delete_stop_arr
    
    $query_string_4 = "DELETE FROM stops WHERE stop_id = ".$del_stop_id.";";
    echo $query_string_4;
    
    
    if (mysql_query($query_string_4)) { echo "step 4: deleted from stops successful"; } else { echo "Error: " . $query_string_4 . "<br>" . mysql_error($db_server); }
    
    
    // 5) for each sep_stud_arr
    foreach ($sep_stud_arr as $address) {
        // 5A) insert new stop
        $query_string = "INSERT INTO stops (address, route_num) VALUES ('".$address."', ".$route_num.")";
        
        if (mysql_query($query_string)) { echo "inserted stop"; } else { echo "Error: " . $query_string . "<br>" . mysql_error($db_server); }
        
        echo $query_string;
        
        // 5B) get stop_id of new stop
        $query_string_2 = "SELECT stop_id FROM stops WHERE address ='".$address."';";
        echo $query_string_2;
        
        
        $query_2 = mysql_query($query_string_2);
          
        if (gettype(mysql_num_rows($query_2)) == 'integer') { $number_of_requests = mysql_num_rows($query_2); } else { $number_of_requests = 0; }
        
        //extract stop_id from results --> $new_stop_id
        for ($current_row = 0; $current_row < $number_of_requests; $current_row++) {
            $request = mysql_fetch_row($query_2);
            foreach ($request as $value) { $new_stop_id = $value; }
        }
        
        
        // 5C) set stop_id in students table
        $query_string = "UPDATE students SET stop_id=".$new_stop_id." WHERE address='".$address."';";
        
        if (mysql_query($query_string)) { echo "updated with new stop_id"; } else { echo "Error: " . $query_string . "<br>" . mysql_error($db_server); }
        
        echo $query_string;
        
    }
}
?>