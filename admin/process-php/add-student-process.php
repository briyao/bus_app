

<?php
/*
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Generates username and password for new student, adds new student to “students” table
*/
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  //login and connect to mysql
  //require_once '.../login.php';
  $host = "localhost";
  $dbname ="busRouteDB";
  $username = "busapp";
  $password = "sql123";

  $db_server = mysql_connect($host, $username, $password);
  if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
    mysql_select_db("busRouteDB") or die("Unable to select database: " . mysql_error());
  
  //generate username
  $name_wo_whitespace = preg_replace('/\s+/', ' ', $_POST["name"]);
  $name_first_3_chars = strtolower(substr($name_wo_whitespace, 0, 3));
  $digits = 5;
  $username = $name_first_3_chars.rand(pow(10, $digits-1), pow(10, $digits)-1);
  
  //generate password
  $real_password = random_password(5);
  $hashed_password = password_hash($real_password, PASSWORD_DEFAULT);
  
  // 1) add new student and generate id
  $query_string = "INSERT INTO students (name, address, username, password) VALUES ('".$_POST["name"]."','".$_POST["address"]."','".$username."','".$hashed_password."');";
    
  if (mysql_query($query_string)) {
    echo "successful";
  } else {
    echo "Error: " . $query_string . "<br>" . mysql_error($db_server);
  }
  
  // 2) get student_id of latest student by username
  $query_string_2 = "SELECT student_id FROM students WHERE username = '".$username."' AND password = '".$hashed_password."';";
  
  $query = mysql_query($query_string_2);
  
  if (gettype(mysql_num_rows($query)) == 'integer')
  {
    $number_of_requests = mysql_num_rows($query);
  } else {
    $number_of_requests = 0;
  }

  //extract id from results
  for ($current_row = 0; $current_row < $number_of_requests; $current_row++)
  {
    $request = mysql_fetch_row($query);
    foreach ($request as $value) {
      $student_id = $value;
    }
  }
  
  // 3) add unhashed password to pw table
  $query_string_3 = "INSERT INTO studentpws (student_id, real_password) VALUES ('".$student_id."','".$real_password."');";
  
  if (mysql_query($query_string_3)) {
    echo "successful";
  } else {
    echo "Error: " . $query_string . "<br>" . mysql_error($db_server);
  }
  
}

// returns a password of a random length
function random_password($length) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}
?>