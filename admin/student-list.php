

<?php
/*
<!--
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Displays all students and allows user to add new students (name and address) and delete students
-->
*/
session_start();
$admin_id = $_SESSION["id"];
$admin_un = $_SESSION["username"];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Student List</title>

        <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>

        <!-- Custom fonts for this template-->
        <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="../css/sb-admin-2.css" rel="stylesheet">
        
        <!--Put address selection in front-->
        <style>
          .pac-container{
             z-index: 9999999 !important;
          }
          .new-stop-input {
            width: 100%;
          }
        </style>
        
    </head>
    <body id="page-top">
      
      <?php include 'content-wrap-top.php';?>
            
      <!-- Begin Page Content -->
      <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800">Student List</h1>
        </div>

        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                  <!-- Card Body -->
                  <div class="card-body">
                    
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addLocationModal">
                      Add Student
                    </button>
                    
                    <!-- Add student modal -->
                    <div class="modal" id="addLocationModal">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Add Student</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          
                          <!-- New Stop Form -->
                          <form class="ajax-form">
                            <div class="modal-body">

                                <div class="form-group">
                                  <label for="name">Student name:</label>
                                  <input type="text" name="name" class="form-control" id="name" placeholder="Enter name">
                                </div>
                                <div class="form-group">
                                  <label for="address">Address:</label>
                                  <input id="autocomplete"  class="form-control" name="address"
                                     placeholder="Enter address"
                                     onFocus="geolocate()"
                                     type="text"/>
                                </div>

                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-primary" id='add-button'>Add</button>
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                          </form>

                        </div>
                      </div>
                    </div>
                    <!-- end modal -->
                    <br><br>
                    <?php include './process-php/show-students.php';?>
                  </div>
                </div>
            </div>
        </div>

        <!-- End of Main Content -->

    <?php include 'content-wrap-bottom.php';?>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="./scripts/add-student-script.js"></script>
    <script src="../sb-admin-2.min.js"></script>
    
    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB96-fS4ULerQSsGHUGTgWokSKLZbkKAk8&libraries=places&callback=initAutocomplete">
    </script>
    
    <script>
      //get admin id session var and set username in top right
      var admin_id = "<?php echo $admin_id;?>";
      document.getElementById("admin-un").innerHTML = "<?php echo $admin_un;?>";
    </script>
    
  </body>
</html>
