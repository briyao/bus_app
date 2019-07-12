

<?php
/*
<!--
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Includes shared PHP functions for displaying dropdown options
-->
*/
/* get dropdown options from sql select statement results 
   input: sql
   return: dropdown in html, echo results
*/
function getDropdownOptions($sql, $col_name, $id, $default_select_word) {
    $host = "localhost";
    $dbname ="busRouteDB";
    $username = "busapp";
    $password = "sql123";

    $db_server = mysql_connect($host, $username, $password);
    if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
    mysql_select_db("busRouteDB") or die("Unable to select database: " . mysql_error());
    
    $result = mysql_query($sql);

    $output = "";
    $output .= "<select class='form-control' name='".$col_name."' id='".$id."'>";
    $output .= '<option disabled selected value> -- Select a '.$default_select_word.' -- </option>';
    while ($row = mysql_fetch_array($result)) {
        $output .= "<option value='" . $row[$col_name] . "'>" . $row[$col_name] . "</option>";
    }
    $output .= "</select>";
    
    return $output;
}

?>