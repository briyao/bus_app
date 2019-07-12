

<?php
/*
<!--
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Includes side navbar and top navbar elements
-->
*/
echo '<!-- Page Wrapper -->
      <div id="wrapper">
      
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    
          <!-- Sidebar - Brand -->
          <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../index.html">
            <div class="sidebar-brand-icon sidebar-icon">
              <i class="fas fa-bus"></i>
            </div>
            <div class="sidebar-brand-text mx-3">BusApp</div>
          </a>

          <!-- Divider -->
          <hr class="sidebar-divider my-0">

          <!-- Divider -->
          <hr class="sidebar-divider">

          <!-- Nav Item - View Routes Link -->
          <li class="nav-item">
            <a class="nav-link collapsed" href="admin.php">
              <i class="fas fa-fw fa-map sidebar-icon"></i>
              <span>View Routes</span>
            </a>
          </li>

          <!-- Nav Item - Add Route Link -->
          <li class="nav-item">
            <a class="nav-link collapsed" href="add-route.php">
              <i class="fas fa-fw fa-map-pin sidebar-icon"></i>
              <span>Add Route</span>
            </a>
          </li>

          <!-- Nav Item - Student List Link -->
          <li class="nav-item">
            <a class="nav-link collapsed" href="student-list.php">
              <i class="fas fa-fw fa-address-book sidebar-icon"></i>
              <span>Students</span>
            </a>
          </li>
          
          <!-- Nav Item - Driver List Link -->
          <li class="nav-item">
            <a class="nav-link collapsed" href="driver-list.php">
              <i class="fas fa-fw fa-address-card sidebar-icon"></i>
              <span>Drivers</span>
            </a>
          </li>
          
          <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
              <a class="nav-link collapsed" href="help-admin.php">
                <i class="fas fa-fw fa-question-circle sidebar-icon"></i>
                <span>Help</span>
              </a>
            </li>

          <!-- Divider -->
          <hr class="sidebar-divider d-none d-md-block">

          <!-- Sidebar Toggler (Sidebar) -->
          <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
          </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

          <!-- Main Content -->
          <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

              <h1 class="page-title">ADMIN</h1>

              <!-- Sidebar Toggle (Topbar) -->
              <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
              </button>


              <!-- Topbar Navbar -->
              <ul class="navbar-nav ml-auto">

                <div class="topbar-divider d-none d-sm-block"></div>

                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                  <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span id="admin-un" class="mr-2 d-none d-lg-inline text-gray-600 small"></span>
                    <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">
                  </a>
                  <!-- Dropdown - User Information -->
                  <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="../feedback/feedback.php">
                      <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                      Give Feedback
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                      <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                      Logout
                    </a>
                  </div>
                </li>

              </ul>

            </nav>
            <!-- End of Topbar -->';
?>