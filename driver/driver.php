<?php
/* 
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Main driver page, includes HTML elements for viewing route info and map showing route

sets up session with id and un
*/
session_start();
$driver_id = $_SESSION["id"];
$driver_un = $_SESSION["username"];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Driver</title>

        <!-- fonts -->
        <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- styles -->
        <link href="../css/sb-admin-2.css" rel="stylesheet">
    </head>
    <body id="page-top">

          <?php include 'content-wrap-top.php';?>
        
          <!-- Begin Page Content -->
          <div class="container-fluid">
  
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
              <h1 class="h3 mb-0 text-gray-800">View Your Route</h1>
            </div>
            
            <div class="row">
                
                <div class="col-xl-6 col-lg-6">
                    <div class="card shadow mb-4">
                      <!-- Card Header -->
                      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                          <h6 class="m-0 font-weight-bold text-primary">Your Assigned Route</h6>
                      </div>
    
                      <!-- Card Body -->
                      <div class="card-body">
                          <div style="width:100%;height:400px;overflow:scroll;" id="routeinfo"></div>
                      </div>
                      
                    </div>
                </div>
                
                <div class="col-xl-6 col-lg-6">
                    <div class="card shadow mb-4">
                      <!-- Card Header -->
                      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                          <h6 class="m-0 font-weight-bold text-primary">Route Overview</h6>
                      </div>
    
                      <!-- Card Body -->
                      <div class="card-body">
                          <div id="map" style="width:100%;height:400px;"></div>
                      </div>
                      
                    </div>
                </div>
            </div>
            
            <!-- End of Main Content -->
          
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
              <div class="container my-auto">
                <div class="copyright text-center my-auto">
                  <span>Copyright &copy; BusApp 2019</span>
                </div>
              </div>
            </footer>
            <!-- End of Footer -->
          
            </div>
            <!-- End of Content Wrapper -->
          
            </div>
            <!-- End of Page Wrapper -->
              
            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
              <i class="fas fa-angle-up"></i>
            </a>
          
            <!-- Logout Modal-->
            <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                  <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../index.html">Logout</a>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Bootstrap core JavaScript-->
            <script src="../vendor/jquery/jquery.min.js"></script>
            <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
          
            <!-- Core plugin JavaScript-->
            <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
          
            <!-- Custom scripts for all pages-->
            <script src="../sb-admin-2.min.js"></script>
            
            <script src="driver-script.js"></script>
            
            <script async defer
              src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB96-fS4ULerQSsGHUGTgWokSKLZbkKAk8&libraries=places&callback=initMap">
            </script>
            
            <script>
            var driver_id = "<?php echo $driver_id;?>";
            var driver_nme = "<?php echo $driver_un;?>";
            document.getElementById("driver-un").innerHTML = "<?php echo $driver_un;?>";
            </script>
          
    </body>
</html>