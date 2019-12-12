<?php    
	$curr_url = $this->uri->segment(2);
	$active="active";
  $role_id = $this->session->userdata('user_data')['role_id'];
?>
<!-- sidebar-->
<aside class="aside" >
 <!-- START Sidebar (left)-->
 <div class="aside-inner" >
    <nav data-sidebar-anyclick-close="" class="sidebar">
       <!-- START sidebar nav-->
       <ul class="nav page-sidebar-menu">
          <!-- Iterates over all sidebar items-->

      
      <?php if($role_id!=1){ ?>
         <li class="<?php if($curr_url == 'dashboard'){echo 'active';}    ?>">
                <a href="<?php $controller='dashboard'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-home"></em>
                   <span>Dashboard</span>
                </a>
          </li>
          <?php } if($role_id==1){ ?>
          <li class="<?php if($curr_url == 'organizations'){echo 'active';}    ?>">
              <a href="<?php $controller='organizations'; 
              echo ADMIN_BASE_URL . $controller ?>">
             <em class="fa fa-users"></em>
                <span>Organizations</span>
             </a>
          </li>
          <li class="<?php if($curr_url == 'banner'){echo 'active';}    ?>">
                <a href="<?php $controller='banner'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-flag"></em>
                   <span>Banner</span>
                </a>
          </li>
          <li class="<?php if($curr_url == 'user_log'){echo 'active';}    ?>">
                <a href="<?php $controller='user_log'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-calendar"></em>
                   <span>User Log</span>
                </a>
          </li>
         <?php } if($role_id != 1){ ?>
          <li class="<?php if($curr_url == 'unit'){echo 'active';}    ?>">
                <a href="<?php $controller='unit'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-th-large"></em>
                   <span>Unit</span>
                </a>
          </li>
          <li class="<?php if($curr_url == 'category'){echo 'active';}    ?>">
                <a href="<?php $controller='category'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-delicious"></em>
                   <span>Test Category</span>
                </a>
          </li>
          <li class="<?php if($curr_url == 'test'){echo 'active';}    ?>">
                <a href="<?php $controller='test'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-pencil-square-o"></em>
                   <span>Test Particular</span>
                </a>
          </li>
          <li>
            <a href="#fee" data-toggle="collapse">
                <em class="fa fa-files-o"></em>
                <span>Invoice</span>
                <i class="fa fa-caret-down"></i>
            </a>
            <ul id="fee" class="nav sidebar-subnav collapse" style="padding-left: 30px">
                <li class="<?php if($curr_url == 'invoice'){echo 'active';}    ?>">
                  <a href="<?php $controller='invoice';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-file"></em>
                    <span>New Invoice</span>
                  </a>
                </li>
                <li class="<?php if($curr_url == 'invoice/manage'){echo 'active';}    ?>">
                  <a href="<?php $controller='invoice/manage';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-file-o"></em>
                    <span>View Report</span>
                  </a>
                </li>
                <li class="<?php if($curr_url == 'patient'){echo 'active';}    ?>">
                  <a href="<?php $controller='patient';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-child"></em>
                    <span>Patient</span>
                  </a>
                </li>
            </ul>
          </li>

          <li class="<?php if($curr_url == 'expense'){echo 'active';}    ?>">
                <a href="<?php $controller='expense'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-usd"></em>
                   <span>Expense</span>
                </a>
          </li>
          

          <!-- <li class="<?php if($curr_url == 'subjects'){echo 'active';}    ?>">
                <a href="<?php $controller='subjects'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-book"></em>
                   <span>Subject</span>
                </a>
          </li>

          <li class="<?php if($curr_url == 'student'){echo 'active';}    ?>">
                <a href="<?php $controller='student'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-child"></em>
                   <span>Student</span>
                </a>
          </li>
          <li class="<?php if($curr_url == 'datesheet'){echo 'active';} ?>">
                <a href="<?php $controller='datesheet'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-calendar"></em>
                   <span>Datesheet</span>
                </a>
          </li>
          <li class="<?php if($curr_url == 'timetable'){echo 'active';} ?>">
                <a href="<?php $controller='timetable'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-clock-o"></em>
                   <span>Timetable</span>
                </a>
          </li>
          
          <li class="<?php if($curr_url == 'attendance'){echo 'active';} ?>">
                <a href="<?php $controller='attendance'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-check"></em>
                   <span>Attendance</span>
                </a>
          </li>
          <li class="<?php if($curr_url == 'leave'){echo 'active';}    ?>">
                <a href="<?php $controller='leave'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-clock-o"></em>
                   <span>Leave</span>
                </a>
          </li>
          <li class="<?php if($curr_url == 'feedback'){echo 'active';}    ?>">
                <a href="<?php $controller='feedback'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-comments-o"></em>
                   <span>Feedback</span>
                </a>
          </li>
          <li class="<?php if($curr_url == 'expense'){echo 'active';}    ?>">
                <a href="<?php $controller='expense'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-usd"></em>
                   <span>Expense</span>
                </a>
          </li>
          <li class="<?php if($curr_url == 'gallery'){echo 'active';}    ?>">
                <a href="<?php $controller='gallery'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-image"></em>
                   <span>Gallery</span>
                </a>
          </li>
          <li class="<?php if($curr_url == 'announcement'){echo 'active';}    ?>">
                <a href="<?php $controller='announcement'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-bullhorn"></em>
                   <span>Announcement</span>
                </a>
          </li> -->
        <?php } ?>
       </ul>
       <!-- END sidebar nav-->
    </nav>
 </div>
 <!-- END Sidebar (left)-->
</aside>




