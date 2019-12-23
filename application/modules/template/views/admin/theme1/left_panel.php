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
          <?php if($role_id==1){ ?>
          <li class="<?php if($curr_url == 'organizations'){echo 'active';}    ?>">
              <a href="<?php $controller='organizations'; 
              echo ADMIN_BASE_URL . $controller ?>">
             <em class="fa fa-users"></em>
                <span>Organizations</span>
             </a>
          </li>
         <?php } if($role_id != 1){ ?>
          <li class="<?php if($curr_url == 'dashboard'){echo 'active';}    ?>">
                <a href="<?php $controller='dashboard'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-home"></em>
                   <span>Dashboard</span>
                </a>
          </li>
          <li class="<?php if($curr_url == 'customer'){echo 'active';}    ?>">
                <a href="<?php $controller='customer'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-user"></em>
                   <span>Customer</span>
                </a>
          </li>
          <li class="<?php if($curr_url == 'supplier'){echo 'active';}    ?>">
                <a href="<?php $controller='supplier'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-truck"></em>
                   <span>Supplier</span>
                </a>
          </li>
          <li>
            <a href="#category" data-toggle="collapse">
                <em class="fa fa-tag"></em>
                <span>Categroy</span>
                <i class="fa fa-caret-down"></i>
            </a>
            <ul id="category" class="nav sidebar-subnav collapse" style="padding-left: 30px">
                <li class="<?php if($curr_url == 'category'){echo 'active';}    ?>">
                  <a href="<?php $controller='category';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-list"></em>
                    <span>Parent Category</span>
                  </a>
                </li>
                <li class="<?php if($curr_url == 'sub_category'){echo 'active';}    ?>">
                  <a href="<?php $controller='sub_category';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-list-alt"></em>
                    <span>Sub Category</span>
                  </a>
                </li>
            </ul>
          </li>
          <li class="<?php if($curr_url == 'product'){echo 'active';}    ?>">
                <a href="<?php $controller='product'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-cart-plus"></em>
                   <span>Product</span>
                </a>
          </li>
          <li>
            <a href="#sale_invoice" data-toggle="collapse">
                <em class="fa fa-shopping-cart"></em>
                <span>Sale Invoice</span>
                <i class="fa fa-caret-down"></i>
            </a>
            <ul id="sale_invoice" class="nav sidebar-subnav collapse" style="padding-left: 30px">
                <li class="<?php if($curr_url == 'sale_invoice'){echo 'active';}    ?>">
                  <a href="<?php $controller='sale_invoice';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-plus-square"></em>
                    <span>New Invoice</span>
                  </a>
                </li>
                <li class="<?php if($curr_url == 'sale_invoice/manage'){echo 'active';}    ?>">
                  <a href="<?php $controller='sale_invoice/manage';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-file-text-o"></em>
                    <span>View Report</span>
                  </a>
                </li>
            </ul>
          </li>
          <li>
            <a href="#purchase_invoice" data-toggle="collapse">
                <em class="fa fa-download"></em>
                <span>Purchase Invoice</span>
                <i class="fa fa-caret-down"></i>
            </a>
            <ul id="purchase_invoice" class="nav sidebar-subnav collapse" style="padding-left: 30px">
                <li class="<?php if($curr_url == 'purchase_invoice'){echo 'active';}    ?>">
                  <a href="<?php $controller='purchase_invoice';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-plus-square"></em>
                    <span>New Invoice</span>
                  </a>
                </li>
                <li class="<?php if($curr_url == 'purchase_invoice/manage'){echo 'active';}    ?>">
                  <a href="<?php $controller='purchase_invoice/manage';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-file-text-o"></em>
                    <span>View Report</span>
                  </a>
                </li>
            </ul>
          </li>
           <li>
            <a href="#stock_return" data-toggle="collapse">
                <em class="fa fa-reply"></em>
                <span>Stock Return</span>
                <i class="fa fa-caret-down"></i>
            </a>
            <ul id="stock_return" class="nav sidebar-subnav collapse" style="padding-left: 30px">
                <li class="<?php if($curr_url == 'stock_return'){echo 'active';}    ?>">
                  <a href="<?php $controller='stock_return';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-plus-square"></em>
                    <span>Add Return</span>
                  </a>
                </li>
                <li class="<?php if($curr_url == 'stock_return/manage'){echo 'active';}    ?>">
                  <a href="<?php $controller='stock_return/manage';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-file-text-o"></em>
                    <span>View Report</span>
                  </a>
                </li>
            </ul>
          </li>
          <li class="<?php if($curr_url == 'report'){echo 'active';}    ?>">
                <a href="<?php $controller='report'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-bar-chart"></em>
                   <span>Report</span>
                </a>
          </li>
          <li class="<?php if($curr_url == 'expense'){echo 'active';}    ?>">
                <a href="<?php $controller='expense'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-money"></em>
                   <span>Expense</span>
                </a>
          </li>
        <?php } ?>
       </ul>
       <!-- END sidebar nav-->
    </nav>
 </div>
 <!-- END Sidebar (left)-->
</aside>




