

<?php
/*
<!--
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Includes HTML elements for creating a new route (preview map, dropdowns and checkboxes to select driver and student)
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

        <title>Add Route</title>

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
      <?php include '../php-help-functions.php'; ?>
      <?php include 'content-wrap-top.php';?>
            
      <!-- Begin Page Content -->
      <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800">New Route</h1>
        </div>

        <!-- STEP 1: SELECT DRIVER (card) -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4" id="select-driver-card">
                  <!-- Card Header -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Step 1: Select Driver</h6>
                  </div>
                  
                  <!-- Card Body -->
                  <div class="card-body">
                    <p>Select a driver from the list of unassigned drivers below.</p>
                    <?php include './process-php/unassigned-driver-select.php';?>

                  </div>
                </div>
            </div>
        </div>
        
        <!-- STEP 2: SELECT STUDENTS (card) -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4" id="select-students-card">
                  <!-- Card Header -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Step 2: Select Students</h6>
                  </div>
                  
                  <!-- Card Body -->
                  <div class="card-body">
                    <p>Select all students from the list of unassigned students below.</p>
                    <?php include './process-php/unassigned-student-select.php';?>

                  </div>
                </div>
            </div>
        </div>
        
        <!-- STEP 3: PREVIEW ROUTE (card) -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4" id="preview-route-card">
                  <!-- Card Header -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Step 3: Preview Route</h6>
                  </div>
                  
                  <!-- Card Body -->
                  <div class="card-body">
                    <p>Click "Refresh" to preview the route on the map below. Click "Create Route" to finalize.</p>
                    <p>See "Route Information" below to see more specific information regarding the stop.</p>
                    <button type="button" id="refresh" class="btn btn-secondary">Refresh</button>
                    <button type="button" id="create-route-btn" class="btn btn-primary">Create Route</button>
                    <br><br>
                    <div id="map" style="width:100%;height:400px;"></div>
                  </div>
                </div>
            </div>
        </div>
        
        <!-- STEP 4: CALCULATE ROUTE (card) -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4" id="calculate-route-card">
                  <!-- Card Header -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Route Information</h6>
                  </div>
                  
                  <!-- Card Body -->
                  <div class="card-body">
                    <div id="routeinfo" style="width:100%;height:400px;overflow:scroll;"></div>
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
    <script src="../sb-admin-2.min.js"></script>

    <script src="./scripts/add-route.js"></script>
    
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB96-fS4ULerQSsGHUGTgWokSKLZbkKAk8&callback=initMap">
    </script>
    
    <script>
      //get admin id session var and set username in top right
      var admin_id = "<?php echo $admin_id;?>";
      document.getElementById("admin-un").innerHTML = "<?php echo $admin_un;?>";
    </script>
    
  </body>
</html>
