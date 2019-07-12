

<?php
/*
<!--
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Returns list of combined stops in a route, formatted as HTML radio buttons
-->
*/
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $host = "localhost";
    $dbname ="busRouteDB";
    $username = "busapp";
    $password = "sql123";
    
    $db_server = mysql_connect($host, $username, $password);
    if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
    mysql_select_db("busRouteDB") or die("Unable to select database: " . mysql_error());
    
    // 1) get route num based on route name
      
    $query_string = "SELECT route_num FROM routes WHERE route_name ='".$_GET["route_name"]."';";
    
    $query = mysql_query($query_string);
      
    if (gettype(mysql_num_rows($query)) == 'integer') { $number_of_requests = mysql_num_rows($query); } else { $number_of_requests = 0; }
    
    //extract num from results --> $route_num
    for ($current_row = 0; $current_row < $number_of_requests; $current_row++) {
        $request = mysql_fetch_row($query);
        foreach ($request as $value) { $route_num = $value; }
    }
    
    // 2) get list of all stop ids
    $sql_get_id = "SELECT stop_id FROM students;";
    $result_get_id = mysql_query($sql_get_id);
    $count = 1;
    
    $stop_id_list = array();
    
    while ($row = mysql_fetch_array($result_get_id)) {
        array_push($stop_id_list, $row['stop_id']);
        $count = $count + 1;
    }
    
    //$stop_id_count = array_count_values($stop_id_list);
    
    // 2) generate checkbox html
    
    $sql = "SELECT address, stop_id FROM stops WHERE route_num=".$route_num.";";
    $result = mysql_query($sql);
    $count = 1;
    
    while ($row = mysql_fetch_array($result)) {
        //check if combined
        if (count_array_values($stop_id_list, $row['stop_id']) > 1) {
            echo '<div class="radio" id="stop-list-radio-btns">
          <input type="radio" value="'.$row['address'].'" name="stop-list-radio" id="radio'.$count.'">
          <label for="defaultCheck1">';
            echo $row['address'];
            echo '</label></div>';
        }
        $count = $count + 1;
    }
}

function count_array_values($my_array, $match) 
{ 
    $count = 0; 
    
    foreach ($my_array as $key => $value) 
    { 
        if ($value == $match) 
        { 
            $count++; 
        } 
    } 
    
    return $count; 
} 
?>