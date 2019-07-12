

<?php
/*
<!--
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Provides help documentation for admin
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
        
        <title>Admin</title>
        
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
          <h1 class="h3 mb-0 text-gray-800">Help</h1>
        </div>

        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                  <!-- Card Header -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Instructions</h6>
                  </div>

                  <!-- Card Body -->
                  <div class="card-body">
                      <!-- start tabs -->
                      
                      <ul class="nav nav-tabs">
                        <li><a class="nav-link active" data-toggle="tab" href="#view-routes">View Routes</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#add-route">Add Route</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#student-list">Student List</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#driver-list">Driver List</a></li>
                      </ul>
                      
                      <div class="tab-content" style="background:white;">
                        <div id="view-routes" class="tab-pane fade active show" align="center">
                            <img src="./img/view-routes-help-1.png" style="width:70%;padding:10px;">
                            <img src="./img/view-routes-help-2.png" style="width:70%;padding:10px;">
                            <img src="./img/view-routes-help-3.png" style="width:70%;padding:10px;">
                            <img src="./img/view-routes-help-4.png" style="width:70%;padding:10px;">
                            <img src="./img/view-routes-help-5.png" style="width:70%;padding:10px;">
                        </div>
                        
                        <div id="add-route" class="tab-pane fade" align="center">
                          <img src="./img/add-route-help-1.png" style="width:70%;padding:10px;">
                          <img src="./img/add-route-help-2.png" style="width:70%;padding:10px;">
                        </div>
                        <div id="student-list" class="tab-pane fade" align="center">
                          <img src="./img/student-list-help-1.png" style="width:70%;padding:10px;">
                          <img src="./img/student-list-help-2.png" style="width:70%;padding:10px;">
                        </div>
                        <div id="driver-list" class="tab-pane fade" align="center">
                          <img src="./img/driver-list-help.png" style="width:70%;padding:10px;">
                        </div>
                      </div>
                      <!-- end tabs -->
                  </div>
                </div>
            </div>
        </div>
        
    </div>

    <!-- End of Main Content -->
    
    <!-- Footer -->
    <footer class="sticky-footer bg-white">
      <div class="container my-auto">
        <div class="copyright text-center my-auto">
          <span>Copyright &copy; Bus App 2019</span>
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
              <a class="btn btn-primary" href="index.html">Logout</a>
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
    
    <script>
      //get admin id session var and set username in top right
      var admin_id = "<?php echo $admin_id;?>";
      document.getElementById("admin-un").innerHTML = "<?php echo $admin_un;?>";
    </script>
    
  </body>
</html>