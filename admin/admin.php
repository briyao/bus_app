
<?php
/*
<!--
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Main admin page, includes HTML elements for viewing route and editing route
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
        
      <?php include '../php-help-functions.php'; ?>
      <?php include 'content-wrap-top.php'; ?>
      
      <!-- Begin Page Content -->
      <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800">View Routes</h1>
        </div>

        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                  <!-- Card Header -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Select Route</h6>
                  </div>

                  <!-- Card Body -->
                  <div class="card-body">
                      <p>Select a route to view from the dropdown.</p>
                      <?php include './process-php/get-route-list.php'; ?>
                  </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- MAP CARD -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                  <!-- Card Header -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Map</h6>
                  </div>

                  <!-- Card Body -->
                  <div class="card-body">
                      <div id="map" style="width:100%;height:400px;"></div>
                  </div>
                </div>
            </div>
            <!-- INFO CARD -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                  <!-- Card Header -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Route Info</h6>
                  </div>

                  <!-- Card Body -->
                  <div class="card-body">
                    <div style="width:100%;height:400px;">
                      <div style="height:85%;overflow:scroll;" id="routeinfo"></div>
                      
                      <!-- Button trigger modal -->
                      <br>
                      <button type="button" id="edit-route-btn" class="btn btn-primary">Edit Route</button>
                      <button type="button" class="btn btn-secondary" id="delete-route-btn-confirm">Delete Route</button>
                      
                      <!-- Add student modal -->
                      <div class="modal" id="deleteConfirmModal">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Delete Route Confirmation</h5>
                              <button type="button" id="delete-modal-close-btn" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p>Are you sure you want to delete this route?</p>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-primary" id='delete-route-btn'>Delete</button>
                              <button type="button" id="delete-modal-cancel-btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!--end modal-->
                    </div>
                  </div>
                </div>
            </div>
            <!-- EDIT ROUTE CARD -->
            <div id="editRouteCard" class="collapse col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                  <!-- Card Header -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">Edit Route</h6>
                  </div>

                  <!-- Card Body -->
                  <div class="card-body">
                      
                      <!-- start tabs -->
                      
                      <ul class="nav nav-tabs">
                        <li><a class="nav-link active" data-toggle="tab" href="#edit-stops">Edit Stops</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#edit-students">Edit Students</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#change-driver">Change Driver</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#change-route-name">Change Route Name</a></li>
                      </ul>
                      
                      <div class="tab-content">
                        <div id="edit-stops" class="tab-pane fade active show">
                          <div class="row">
                            <!-- left side: checkboxes -->
                            <div class="col-xl-6 col-lg-6">
                              <br>
                              
                              <h4>Combine Stops</h4>
                              <p>Select the stops below to combine. Preview selected stops on map.</p>
                              <div id="edit-stops-combine"></div>
                              <br>
                              <input id="autocomplete"  class="form-control" name="address"
                                     placeholder="Enter new combined address"
                                     onFocus="geolocate()"
                                     type="text"/>
                              <br>
                              <button type="button" class="btn btn-primary" id='preview-combine-stops-btn'>Preview</button>
                              <button type="button" class="btn btn-primary" id='combine-stops-btn'>Combine Stops</button>
                              
                              <br><br>
                              
                              <h4>Separate Stops</h4>
                              <p>Select from the combined stops below to separate.</p>
                              <div id="edit-stops-separate"></div>
                              <br>
                              <button type="button" class="btn btn-primary" id='separate-stops-btn'>Separate Stop</button>
                              
                            </div>
                            <!-- right side: preview map -->
                            <div class="col-xl-6 col-lg-6" style="padding: 10px">
                              <div id="preview-map" style="width:100%;height:400px;"></div>
                            </div>
                          </div>
                        </div>
                        
                        <div id="edit-students" class="tab-pane fade">
                          <div class="row">
                          <div class="col-xl-6 col-lg-6">
                            <br>
                            <h4>Add Student</h4>
                            <p>Select the student(s) you would like to add to this route.</p>
                            <div id="edit-student-add"></div>
                            <br>
                            <button type="button" class="btn btn-primary" id='add-student-btn'>Add</button>
                          </div>
                          
                          <div class="col-xl-6 col-lg-6">
                            <br>
                            <h4>Remove Student</h4>
                            <p>Select the student(s) below to remove.</p>
                            <div id="edit-student-remove"></div>
                            <br>
                            <button type="button" class="btn btn-primary" id='remove-student-btn'>Remove</button>
                          </div>
                          <br><br>
                          </div>
                        </div>
                        <div id="change-driver" class="tab-pane fade">
                          <br>
                          <p>Select a new driver from the list of available drivers below.</p>
                          <?php include './process-php/unassigned-driver-select.php'; ?>
                          <br>
                          <!--<select class='form-control' name='name' id='driver-select'><option disabled selected value> -- Select a Driver -- </option><option value='sam'>sam</option><option value='rick'>rick</option><option value='james'>james</option><option value='matt'>matt</option><option value='sal'>sal</option></select>                          <br>-->
                          <button type="button" class="btn btn-primary" id='driver-change-btn'>Set New Driver</button>
                        </div>
                        <div id="change-route-name" class="tab-pane fade">
                          <br>
                          <!-- start change name form -->
                          <form action="./process-php/change-route-name.php" method="post" class="ajax-form">
                            <div class="form-group">
                              <label for="name">New name:</label>
                              <input type="text" name="new-name" class="form-control" id="new-name" placeholder="Enter new route name">
                            </div>
                            <button type="submit" class="btn btn-primary" id='name-change-button'>Set New Name</button>
                          </form>
                          <!-- end change name form -->
                        </div>
                      </div>
                      <!-- end tabs -->
                      
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

    <script src="./scripts/view-routes.js"></script>
    <script src="./scripts/recalculate.js"></script>
    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB96-fS4ULerQSsGHUGTgWokSKLZbkKAk8&libraries=places&callback=initMapAndAutocomplete">
    </script>
    
    <script>
      //get admin id session var and set username in top right
      var admin_id = "1";
      document.getElementById("admin-un").innerHTML = "admin123";
    </script>
    
  </body>
</html>