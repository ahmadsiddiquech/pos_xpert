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
          <li>
            <a href="#account" data-toggle="collapse">
                <em class="fa fa-male"></em>
                <span>Account</span>
                <i class="fa fa-caret-down"></i>
            </a>
            <ul id="account" class="nav sidebar-subnav collapse" style="padding-left: 30px">
                <li class="<?php if($curr_url == 'account'){echo 'active';}    ?>">
                  <a href="<?php $controller='account';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-file-text-o"></em>
                    <span>View Account</span>
                  </a>
                </li>
                <li class="<?php if($curr_url == 'account/chart_of_account'){echo 'active';}    ?>">
                  <a href="<?php $controller='account/chart_of_account';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-pie-chart"></em>
                    <span>Chart of Account</span>
                  </a>
                </li>
            </ul>
          </li>
          <li>
            <a href="#transaction" data-toggle="collapse">
                <em class="fa fa-dollar"></em>
                <span>Transaction</span>
                <i class="fa fa-caret-down"></i>
            </a>
            <ul id="transaction" class="nav sidebar-subnav collapse" style="padding-left: 30px">
                <li class="<?php if($curr_url == 'sale_invoice'){echo 'active';}    ?>">
                  <a href="<?php $controller='sale_invoice';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-plus-square"></em>
                    <span>Sale Invoice</span>
                  </a>
                </li>
                <li class="<?php if($curr_url == 'purchase_invoice'){echo 'active';}    ?>">
                  <a href="<?php $controller='purchase_invoice';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-plus-square"></em>
                    <span>Purchase Invoice</span>
                  </a>
                </li>
                <li class="<?php if($curr_url == 'stock_return'){echo 'active';}    ?>">
                  <a href="<?php $controller='stock_return';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-plus-square"></em>
                    <span>Stock Return Invoice</span>
                  </a>
                </li>
                <li class="<?php if($curr_url == 'account/cash_payment'){echo 'active';}    ?>">
                  <a href="<?php $controller='account/cash_payment';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-plus-square"></em>
                    <span>Cash Payment</span>
                  </a>
                </li>
                <li class="<?php if($curr_url == 'account/cash_recieved'){echo 'active';}    ?>">
                  <a href="<?php $controller='account/cash_recieved';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-plus-square"></em>
                    <span>Cash Recieved</span>
                  </a>
                </li>
                <li class="<?php if($curr_url == 'account/bank_deposit'){echo 'active';}    ?>">
                  <a href="<?php $controller='account/bank_deposit';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-plus-square"></em>
                    <span>Bank Deposit</span>
                  </a>
                </li>
                <li class="<?php if($curr_url == 'account/bank_recieved'){echo 'active';}    ?>">
                  <a href="<?php $controller='account/bank_recieved';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-plus-square"></em>
                    <span>Bank Recieved</span>
                  </a>
                </li>
                <li class="<?php if($curr_url == 'account/journal_voucher'){echo 'active';}    ?>">
                  <a href="<?php $controller='account/journal_voucher';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-plus-square"></em>
                    <span>Journal Vouchers</span>
                  </a>
                </li>
            </ul>
          </li>
          <li>
            <a href="#report" data-toggle="collapse">
                <em class="fa fa-bar-chart"></em>
                <span>Report</span>
                <i class="fa fa-caret-down"></i>
            </a>
            <ul id="report" class="nav sidebar-subnav collapse" style="padding-left: 30px">
                <li class="<?php if($curr_url == 'sale_invoice/manage'){echo 'active';}    ?>">
                  <a href="<?php $controller='sale_invoice/manage';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-file-text-o"></em>
                    <span>Sale Report</span>
                  </a>
                </li>
                <li class="<?php if($curr_url == 'purchase_invoice/manage'){echo 'active';}    ?>">
                  <a href="<?php $controller='purchase_invoice/manage';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-file-text-o"></em>
                    <span>Purchase Report</span>
                  </a>
                </li>
                <li class="<?php if($curr_url == 'stock_return/manage'){echo 'active';}    ?>">
                  <a href="<?php $controller='stock_return/manage';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-file-text-o"></em>
                    <span>Stock Return Report</span>
                  </a>
                </li>
                <li class="<?php if($curr_url == 'report/product_report'){echo 'active';}    ?>">
                  <a href="<?php $controller='report/product_report';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-file-text-o"></em>
                    <span>Product Report</span>
                  </a>
                </li>
                <li class="<?php if($curr_url == 'report/overall_report'){echo 'active';}    ?>">
                  <a href="<?php $controller='report/overall_report';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-file-text-o"></em>
                    <span>Overall Report</span>
                  </a>
                </li>
                <li class="<?php if($curr_url == 'report/date_to_date'){echo 'active';}    ?>">
                  <a href="<?php $controller='report/date_to_date';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-file-text-o"></em>
                    <span>Date Wise Report</span>
                  </a>
                </li>
                <li class="<?php if($curr_url == 'account/transaction_list'){echo 'active';}    ?>">
                  <a href="<?php $controller='account/transaction_list';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-file-text-o"></em>
                    <span>Transaction Report</span>
                  </a>
                </li>
                <li class="<?php if($curr_url == 'report/general_ledger'){echo 'active';}    ?>">
                  <a href="<?php $controller='report/general_ledger';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-file-text-o"></em>
                    <span>General Ledger</span>
                  </a>
                </li>
                <li class="<?php if($curr_url == 'report/full_report'){echo 'active';}    ?>">
                  <a href="<?php $controller='report/full_report';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-file-text-o"></em>
                    <span>Full Report</span>
                  </a>
                </li>
                <li class="<?php if($curr_url == 'report/income_statement'){echo 'active';}    ?>">
                  <a href="<?php $controller='report/income_statement';
                    echo ADMIN_BASE_URL . $controller ?>">
                    <em class="fa fa-file-text-o"></em>
                    <span>Income Statement</span>
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




