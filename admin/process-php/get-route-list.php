

<?php
/*
<!--
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Returns list of all routes, formatted as a dropdown menu
-->
*/
//get route_name column from routes
$sql = "SELECT route_name FROM routes;";

//create dropdown menu to display all created route names
echo getDropdownOptions($sql, 'route_name', 'route-select', 'Route');

?>