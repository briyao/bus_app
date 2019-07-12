<?php
/*
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Starts login session for admin, includes elements for entering username and password, handles incorrect login info
*/

// Initialize the session
session_start();
 
// Include config file
require_once "../login.php";

$link = mysql_connect($host, $username, $password);
if (!$link) die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db("busRouteDB") or die("Unable to select database: " . mysql_error());
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $error = "Please enter username and password.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $error = "Please enter username and password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty($error)){
        $query = "SELECT admin_id, password FROM admins WHERE username = '$username';";
        $result = mysql_query($query, $link);
        
        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        $password_table = $row['password'];
        $id = $row['admin_id'];
        echo $id;
        if($password == $password_table){
            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $id;
            $_SESSION["username"] = $username;   
             header("location: ../admin/admin.php");
          } else{
             $error = "Invalid username or password";
          }
        }
   }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Admin - Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

  <!-- Custom styles for this template-->
  <link href="../startbootstrap-sb-admin-2-gh-pages/startbootstrap-sb-admin-2-gh-pages/css/sb-admin-2.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <i class="material-icons icon-button">person</i>
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back, Admin!</h1>
            
                    <form class="user" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                      <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                        <input type="text" name = "username" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Username" value="<?php echo $username; ?>">
                      </div>
                      <div class="form-group">
                        <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" name="password" class="form-control" value="<?php echo $password; ?>">
                      </div>
                      <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Login">
                      </div>
                      <span class="help-block" style="color:red;"><?php echo $error; ?></span>
                    </form>
                    <hr>
                    <a href="../index.html">Go back to homepage</a>
                    <!--<div class="text-center">
                      <a class="small" href="forgot-password.html">Forgot password?</a>
                    </div>-->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
