<?php
/*
<!--
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Provides help documentation for student
-->
*/
session_start();
$student_id = $_SESSION["id"];
$student_un = $_SESSION["username"];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>Student</title>

        <!-- Get fonts -->
        <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- Get stylesheet -->
        <link href="../css/sb-admin-2.css" rel="stylesheet">
        
        <!-- Get JQuery library -->
        <script src="../vendor/jquery/jquery.min.js"></script>
        
    </head>
    <body id="page-top">

          <!-- Call php file 'content-wrap-top' for sidebar, topbar, and user dropdown -->
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
    
                      <!-- Card Body Displaying Tutorial PNG File -->
                      <div class="card-body">
                          <img src="./student-help.png" style="width: 100%">
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
          
            <!-- Logout Confirm Modal-->
            <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
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
          
            <!-- Student JavaScript file -->
            <script src="student-script.js"></script>
            
            <!-- API Map Key JavaScript -->
            <script async defer
              src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB96-fS4ULerQSsGHUGTgWokSKLZbkKAk8&libraries=places&callback=initMap">
            </script>
            
            <!-- JavaScript that displays student username in top right -->
            <script>
              var student_id = "<?php echo $student_id;?>";
              document.getElementById("student-un").innerHTML = "<?php echo $student_un;?>";
            </script>
    </body>
</html>