

<?php
/*
<!--
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Returns list of all stops in a route, formatted as HTML checkboxes
-->
*/
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
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
    $query_string = "SELECT route_num FROM routes WHERE route_name ='".$_GET["route_name"]."';";
    
    $query = mysql_query($query_string);
      
    if (gettype(mysql_num_rows($query)) == 'integer') { $number_of_requests = mysql_num_rows($query); } else { $number_of_requests = 0; }
    
    //extract num from results --> $route_num
    for ($current_row = 0; $current_row < $number_of_requests; $current_row++) {
        $request = mysql_fetch_row($query);
        foreach ($request as $value) { $route_num = $value; }
    }
    
    // 2) get list of addresses based on route number
    
    $sql = "SELECT address FROM stops WHERE route_num=".$route_num.";";
    $result = mysql_query($sql);
    $count = 1;
    
    // 3) loop through results and generate checkbox html
    while ($row = mysql_fetch_array($result)) {
        echo '<div class="form-check" id="combine-stop-select">
      <input class="form-check-input" type="checkbox" value="" name="stop-list-checkbox" id="'.$row['address'].'">
      <label class="form-check-label" for="defaultCheck1">';
        echo $row['address'];
        echo '</label></div>';
        $count = $count + 1;
    }
}
?>