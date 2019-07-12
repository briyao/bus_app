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
      
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
              <a class="nav-link collapsed" href="student.php">
                <i class="fas fa-fw fa-map sidebar-icon"></i>
                <span>View Your Stop</span>
              </a>
            </li>
            
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
              <a class="nav-link collapsed" href="help-student.php">
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
        
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
        
            <!-- Main Content -->
            <div id="content">
      
              <!-- Topbar -->
              <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
              
                <h1 class="page-title">STUDENT</h1>
      
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
                      <span class="mr-2 d-none d-lg-inline text-gray-600 small" id="student-un"></span>
                      <img class="img-profile rounded-circle" src="https://t3.ftcdn.net/jpg/00/64/67/80/240_F_64678017_zUpiZFjj04cnLri7oADnyMH0XBYyQghG.jpg">
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                      <a class="dropdown-item" href="../feedback/feedback.php">
                        <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                        Give Feedback
                      </a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="../index.html" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                      </a>
                    </div>
                  </li>
      
                </ul>
      
              </nav>
              <!-- End of Topbar -->'
?>