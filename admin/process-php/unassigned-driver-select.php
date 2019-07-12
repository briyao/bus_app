

<?php
/*
<!--
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Returns list of drivers without a route, formatted as HTML dropdown menu
-->
*/
//select unassigned drivers from the drivers sql table
$sql = "SELECT name FROM drivers WHERE driver_id NOT IN (SELECT driver_id FROM routes);";

//create a dropdown menu with all of the driver names
echo getDropdownOptions($sql, 'name', 'driver-select', 'Driver');

?>