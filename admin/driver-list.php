
<?php
/*
<!--
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Displays all drivers and allows user to add and delete drivers
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

        <title>Driver List</title>

        <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>

        <!-- Custom fonts for this template-->
        <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="../css/sb-admin-2.css" rel="stylesheet">
        
    </head>
    <body id="page-top">
      <?php include "../php-help-functions.php"; ?>
      <?php include 'content-wrap-top.php';?>
            
      <!-- Begin Page Content -->
      <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800">Driver List</h1>
        </div>

        <!-- New Driver Card -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                  <!-- Card Header -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">New Driver</h6>
                  </div>
                  
                  <!-- Card Body -->
                  <div class="card-body">
                    <!-- New Driver Form -->
                    <form action="./process-php/add-driver-process.php" method="post" class="ajax-form">
                      <div class="form-group">
                        <label for="name">Driver name:</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter name">
                      </div>
                      <button type="submit" class="btn btn-primary" id='add-button'>Add</button>
                    </form>
                  </div>
                </div>
            </div>
        </div>
        
        <!-- All Drivers Card -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                  <!-- Card Header -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Driver List</h6>
                  </div>
                  
                  <!-- Card Body -->
                  <div class="card-body">
                    <?php include './process-php/show-drivers.php';?>
                  </div>
                  
                  <!-- Add student modal -->
                  <div class="modal" id="selectNewDriverModal">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Select New Driver</h5>
                          <button type="button" id="delete-modal-close-btn" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p>The bus driver you selected is assigned to a route. Which driver would you like to reassign the route to?</p>
                          <?php include "./process-php/unassigned-driver-select.php"; ?>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-primary" id='change-driver-btn'>Change Driver</button>
                          <button type="button" id="delete-modal-cancel-btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--end modal-->
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
    <script src="../sb-admin-2.min.js"></script>
    
    <script src="./scripts/add-driver-script.js"></script>
    
    <script>
      //get admin id session var and set username in top right
      var admin_id = "<?php echo $admin_id;?>";
      document.getElementById("admin-un").innerHTML = "<?php echo $admin_un;?>";
    </script>

  </body>
</html>
