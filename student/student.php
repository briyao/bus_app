
<?php
/* 
<!--
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Main student page, includes HTML elements for viewing stop info, map showing stop location, and changing status
-->

<!-- Sets up session to access student id and un; store in variables -->
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

        <!-- Get necessary fonts -->
        <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- Get stylesheet -->
        <link href="../css/sb-admin-2.css" rel="stylesheet">
        
        <!-- Get jquery library for scripts -->
        <script src="../vendor/jquery/jquery.min.js"></script>
        
    </head>
    <body id="page-top">
      
          <!-- Call php file 'content-wrap-top' for sidebar, topbar, and user dropdown -->
          <?php include 'content-wrap-top.php';?>
          
          <!-- Begin Page Content -->
          <div class="container-fluid">
  
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
              <h1 class="h3 mb-0 text-gray-800">View Your Stop</h1>
            </div>
            
            <div class="row">
                
                <!-- Route Information and Change Status Card --> 
                <div class="col-xl-6 col-lg-6">
                    <div class="card shadow mb-4">
                      
                      <!-- Card Header -->
                      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                          <h6 class="m-0 font-weight-bold text-primary">Your Stop</h6>
                      </div>
    
                      <!-- Card Body with route information -->
                      <div class="card-body">
                          <div id="route-info"></div>
                          <div id="estimated-time-line">
                            <p class="inline">Estimated Stop Time: </p>
                            <p class="inline" id="estimated-time"></p>
                          </div>
                          
                          <div id="address-line">
                            <p class="inline">Stop Address: </p>
                            <p class="inline" id="address-text"></p>
                          </div>
                          
                          <div id="status-line">
                            <p class="inline">Status: </p>
                            <p class="inline" id="status-text"></p>
                          </div>
                          
                          <!-- Change Status Button; triggers modal -->
                          <button id="cancel-stop-btn-confirm" class="btn btn-primary">Change Status</button>
                          
                          <!-- Add Change Status Modal -->
                          <div class="modal" id="changeStatusModal">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title">Change Status Confirmation</h5>
                                  <button type="button" id="cancel-modal-close-btn" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p id="change-status-modal-text"></p>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-primary" id='change-status-btn'>Change Status</button>
                                  <button type="button" id="cancel-modal-cancel-btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- End Modal-->
                      </div>
                      
                    </div>
                </div>
                
                <!-- View Route Map Card --> 
                <div class="col-xl-6 col-lg-6">
                    <div class="card shadow mb-4">
                      
                      <!-- Card Header -->
                      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                          <h6 class="m-0 font-weight-bold text-primary">Stop Location</h6>
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

            </div>
            
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
            
            <!-- JavaScript for Modal Displays -->
            <script>
            //get student id session var and set username in top right
            var student_id = "<?php echo $student_id;?>";
            document.getElementById("student-un").innerHTML = "<?php echo $student_un;?>";
            
            //get and display status
            $.ajax({
                url: 'get-status.php',
                type: 'GET',
                data: {'student_id': student_id},
                success: function(response) {
                  console.log(response);
                  if (response == 1) {
                    document.getElementById("status-text").innerHTML = "going";
                    document.getElementById("change-status-modal-text").innerHTML = "Are you sure you want to change your status to 'not going'?";
                  } else {
                    document.getElementById("status-text").innerHTML = "not going";
                    document.getElementById("change-status-modal-text").innerHTML = "Are you sure you want to change your status to 'going'?";
                  }
                },
                error: function(request, error) {
                  console.log("Error", error);
                }
            });
            
            //when change status button is clicked, display changeStatusModal modal
            document.getElementById('cancel-stop-btn-confirm').addEventListener('click', function() {
                var modal = document.getElementById("changeStatusModal");
                modal.style.display = "inline";
            });
            
            //when user confirms modal, call change status php file to change SQL table
            document.getElementById('change-status-btn').addEventListener('click', function() {
                var status = document.getElementById("status-text").innerHTML;
                
                $.ajax({
                  url: './change-status.php',
                  type: 'POST',
                  data: {'student_id': "<?php echo $student_id; ?>", 'status': status},
                  success: function(response) {
                    console.log(response);
                    alert('Successfully changed status.');
                    window.location.reload(true); 
                  },
                  error: function(request, error) {
                    console.log("Error", error);
                  }
                });
            });
            
            //when 'close' button on modal is clicked, hide modal
            document.getElementById('cancel-modal-close-btn').addEventListener('click', function() {
              var modal = document.getElementById("changeStatusModal");
              modal.style.display = "none";
            });
            
            //when 'cancel' button on modal is clicked, hide modal
            document.getElementById('cancel-modal-cancel-btn').addEventListener('click', function() {
              var modal = document.getElementById("changeStatusModal");
              modal.style.display = "none";
            });
            
            </script>
    </body>
</html>